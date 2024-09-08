<?php

namespace App\Livewire\Notification;

use App\Models\LayananPermohonan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class AllNotification extends Component
{
    use WithPagination;

    public $notifications = [];
    public $page = 1;
    public $totalNotifications;

    public function mount()
    {
        $user = Auth::user();
        if ($user) {
            $this->totalNotifications = $user->notifications()->count();
        }
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $user = Auth::user();
        if ($user) {
            $notifications = $user->notifications()
                ->orderBy('created_at', 'desc')
                ->paginate(10, ['*'], 'page', $this->page);

            foreach ($notifications as $notification) {
                $notificationDetail = $this->getPermohonanDetail(
                    $notification['data']['viewData']['permohonanId'],
                    $notification['data']['viewData']['permohonanStatus']
                );
                $notificationDetail['notification'] = $notification;
                $this->notifications[] = $notificationDetail;
            }

            $this->page++;
        }
    }

    public function markGroupAsRead($group)
    {
        $user = Auth::user();
        if ($user) {
            foreach ($this->notifications as $notification) {
                $createdAt = Carbon::parse($notification['notification']['created_at']);
                $today = Carbon::today();
                $weekAgo = Carbon::now()->subWeek();
                $monthAgo = Carbon::now()->subMonth();

                $markAsRead = false;

                if ($group === 'today' && $createdAt->isSameDay($today)) {
                    $markAsRead = true;
                } elseif ($group === 'week' && $createdAt->greaterThanOrEqualTo($weekAgo)) {
                    $markAsRead = true;
                } elseif ($group === 'month' && $createdAt->greaterThanOrEqualTo($monthAgo)) {
                    $markAsRead = true;
                } elseif ($group === 'older' && $createdAt->lessThan($monthAgo)) {
                    $markAsRead = true;
                }

                if ($markAsRead && is_null($notification['notification']['read_at'])) {
                    $notif = $user->notifications()->where('id', $notification['notification']['id'])->first();
                    if ($notif) {
                        $notif->markAsRead();
                        $this->dispatch('read-notification');
                    }
                }
            }
        }
        $this->mount(); // Re-mount to refresh notifications
    }

    public function singleMarkAsRead($notificationId)
    {
        $user = Auth::user();
        if ($user) {
            $notification = $user->notifications()->where('id', $notificationId)->first();
            if ($notification && is_null($notification->read_at)) {
                $notification->markAsRead();
                $this->notifications = collect($this->notifications)->map(function ($notif) use ($notificationId) {
                    if ($notif['notification']['id'] === $notificationId) {
                        $notif['notification']['read_at'] = Carbon::now();
                    }
                    return $notif;
                })->toArray();
                $this->dispatch('read-notification');
            }
        }
    }

    protected function getPermohonanDetail($id, $status)
    {
        $data = LayananPermohonan::findOrFail($id);

        return [
            'id' => $data->id,
            'nama' => $data->layanan->nama,
            'ilustrasi_url' => $data->layanan->ilustrasi_url,
            'status' => $status,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
        ];
    }

    public function render()
    {
        $groupedNotifications = $this->groupNotifications($this->notifications);

        return view('livewire.notification.all-notification')
            ->with('groupedNotifications', $groupedNotifications);
    }

    private function groupNotifications($notifications)
    {
        $today = Carbon::today();
        $weekAgo = Carbon::now()->subWeek();
        $monthAgo = Carbon::now()->subMonth();

        $grouped = [
            'today' => [],
            'week' => [],
            'month' => [],
            'older' => []
        ];

        foreach ($notifications as $notification) {
            $createdAt = Carbon::parse($notification['notification']['created_at']);

            if ($createdAt->isSameDay($today)) {
                $grouped['today'][] = $notification;
            } elseif ($createdAt->greaterThanOrEqualTo($weekAgo)) {
                $grouped['week'][] = $notification;
            } elseif ($createdAt->greaterThanOrEqualTo($monthAgo)) {
                $grouped['month'][] = $notification;
            } else {
                $grouped['older'][] = $notification;
            }
        }

        return $grouped;
    }
}
