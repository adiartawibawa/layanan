<?php

namespace App\Livewire\Permohonan;

use App\Events\LayananPermohonanCreated;
use App\Models\Layanan;
use App\Models\LayananPermohonan;
use App\Models\LayananPermohonanHistory;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class CreatePermohonan extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public ?Layanan $slug;

    public function mount(): void
    {
        $this->form->fill($this->slug->toArray());
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Wizard::make([
                Step::make('Prasyarat')
                    ->icon('heroicon-o-document-text')
                    ->schema(
                        self::makeBlockBuilder('prasyarat', 'Prasyarat Layanan')
                    ),
                Step::make('Formulir')
                    ->icon('heroicon-o-document-check')
                    ->schema(self::makeBlockBuilder('formulir', 'Formulir Layanan')),
            ])->submitAction(new HtmlString('<button class="px-3 py-2 bg-primary-500 text-sm rounded-md text-white" type="submit">Ajukan Permohonan</button>'))
        ])->statePath('data')->model(LayananPermohonan::class);
    }

    public function create(): void
    {
        $layananPermohonan = LayananPermohonan::create([
            'user_id' => auth()->user()->id,
            'layanan_id' => $this->slug->id,
            'prasyarat' => $this->form->getState()['prasyarat'],
            'formulir' => $this->form->getState()['formulir']
        ]);

        // Event create PermohonanLayananHistory
        event(new LayananPermohonanCreated($layananPermohonan)); // Panggil event LayananPermohonanCreated

        Notification::make()
            ->title('Ajuan permohonan berhasil.')
            ->success()
            ->viewData([
                'permohonanId' => $layananPermohonan->id,
                'permohonanStatus' => LayananPermohonanHistory::DIBUAT
            ])
            ->body('Permohonan layanan ' . Str::lower($this->slug->nama) . ' telah berhasil diajukan.')
            ->send()
            ->sendToDatabase(auth()->user());

        $this->form->fill($this->slug->toArray());

        $this->redirectRoute('permohonan.index');
    }

    private static function makeBlockBuilder(string $title, string $desc): array
    {
        return [
            Builder::make($title)
                ->label($desc)
                ->blocks([
                    Block::make('string')
                        ->label(fn (?array $state): string => $state === null ? 'Jawaban Singkat' : ($state['question'] ?? 'Pertanyaan tanpa judul'))
                        ->icon('heroicon-o-bars-2')
                        ->schema([
                            TextInput::make('content')->label('')->helperText(function (Get $get) {
                                return new HtmlString('<p class="text-rose-500 text-xs italic">' . $get('helperText') . '</p>');
                            })->required(),
                        ]),
                    Block::make('textarea')
                        ->label(fn (?array $state): string => $state === null ? 'Paragraf' : ($state['question'] ?? 'Pertanyaan tanpa judul'))
                        ->icon('heroicon-o-bars-3-bottom-left')
                        ->schema([
                            Textarea::make('content')->label('')->helperText(function (Get $get) {
                                return new HtmlString('<p class="text-rose-500 text-xs italic">' . $get('helperText') . '</p>');
                            })->required()->markAsRequired(false),
                        ]),
                    Block::make('datepicker')
                        ->label(fn (?array $state): string => $state === null ? 'Tanggal' : ($state['question'] ?? 'Pertanyaan tanpa judul'))
                        ->icon('heroicon-o-calendar-days')
                        ->schema([
                            DatePicker::make('content')->label('')->helperText(function (Get $get) {
                                return new HtmlString('<p class="text-rose-500 text-xs italic">' . $get('helperText') . '</p>');
                            })->required(),
                        ]),
                    Block::make('file')
                        ->label(fn (?array $state): string => $state === null ? 'Upload File' : ($state['question'] ?? 'Pertanyaan tanpa judul'))
                        ->icon('heroicon-o-cloud-arrow-up')
                        ->schema([
                            FileUpload::make('content')->label('')->helperText(function (Get $get) {
                                return new HtmlString('<p class="text-rose-500 text-xs italic">' . $get('helperText') . '</p>');
                            })
                                ->directory('permohonan/' . auth()->user()->id)
                                ->getUploadedFileNameForStorageUsing(
                                    fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                        ->prepend('document-' . Str::slug(auth()->user()->name) . '-')
                                )
                                ->acceptedFileTypes(['application/pdf'])
                                ->required(),
                        ]),
                    Block::make('image')
                        ->label(fn (?array $state): string => $state === null ? 'Upload Gambar' : ($state['question'] ?? 'Pertanyaan tanpa judul'))
                        ->icon('heroicon-o-photo')
                        ->schema([
                            FileUpload::make('content')->label('')->helperText(function (Get $get) {
                                return new HtmlString('<p class="text-rose-500 text-xs italic">' . $get('helperText') . '</p>');
                            })
                                ->directory('permohonan/' . auth()->user()->id)
                                ->getUploadedFileNameForStorageUsing(
                                    fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                        ->prepend('image-' . Str::slug(auth()->user()->name) . '-')
                                )
                                ->image()
                                ->required(),
                        ]),
                ])
                ->addable(false)
                ->reorderableWithDragAndDrop(false)
                ->deletable(false)
                ->blockNumbers(false)
        ];
    }

    public function render()
    {
        return view('livewire.permohonan.create-permohonan')
            ->with(['layanan' => $this->slug]);
    }
}
