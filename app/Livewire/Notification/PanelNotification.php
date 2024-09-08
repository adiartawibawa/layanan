<?php

namespace App\Livewire\Notification;

use App\Models\LayananPermohonan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class PanelNotification extends Component
{
    use WithPagination;

    public $notifications = [];
    public $notificationDetails = [];
    public $notificationsCount;
    public $page = 1;

    // protected $listeners = ['notificationMarkedAsRead' => 'handleNotificationMarkedAsRead'];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $user = Auth::user();
        if ($user) {
            $notifications = $user->unreadNotifications()
                ->orderBy('created_at', 'desc')
                ->paginate(10, ['*'], 'page', $this->page);

            $this->notificationsCount = $user->unreadNotifications()->count();

            foreach ($notifications as $notification) {
                $notificationDetail = $this->getPermohonanDetail(
                    $notification['data']['viewData']['permohonanId'],
                    $notification['data']['viewData']['permohonanStatus']
                );

                // Menambahkan data read_at ke notificationDetail
                $notificationDetail['read_at'] = $notification->read_at;

                $this->notifications[] = $notification;
                $this->notificationDetails[] = $notificationDetail;
            }

            $this->page++;
        }
    }

    public function markAsRead($notificationId)
    {
        $user = Auth::user();
        if ($user) {
            $notification = $user->unreadNotifications()->where('id', $notificationId)->first();
            if ($notification) {
                $notification->markAsRead();

                // Remove the notification from the local notifications array
                $this->notifications = collect($this->notifications)->filter(function ($notif) use ($notificationId) {
                    return $notif->id !== $notificationId;
                })->toArray();

                // Recalculate notification details
                $this->notificationDetails = [];
                foreach ($this->notifications as $notif) {
                    $this->notificationDetails[] = $this->getPermohonanDetail(
                        $notif['data']['viewData']['permohonanId'],
                        $notif['data']['viewData']['permohonanStatus']
                    );
                }

                $this->notificationsCount = $user->unreadNotifications()->count();
            }
        }
    }

    #[On('read-notification')]
    public function handleNotificationMarkedAsRead()
    {
        $this->loadNotifications();
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
            'read_at' => null, // Default null for initialization
        ];
    }

    public function render()
    {
        return view('livewire.notification.panel-notification')
            ->with('notificationDetails', $this->notificationDetails)
            ->with('notificationsCount', $this->notificationsCount);
    }
}
