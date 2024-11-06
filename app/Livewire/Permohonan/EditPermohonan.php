<?php

namespace App\Livewire\Permohonan;

use App\Models\LayananPermohonan;
use App\Models\LayananPermohonanHistory;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\HtmlString;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Support\Str;

class EditPermohonan extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $permohonanData = []; // Holds the form data for 'permohonan'.

    public LayananPermohonan $permohonan; // The LayananPermohonan model instance.

    public function mount(): void
    {
        // Initialize form data with the model's current attributes.
        $this->editPermohonanForm->fill($this->permohonan->attributesToArray());
    }

    protected function getForms(): array
    {
        // Define the form name for use within the component.
        return [
            'editPermohonanForm',
        ];
    }

    public function editPermohonanForm(Form $form): Form
    {
        // Build the form structure using a Wizard component.
        return $form
            ->schema([
                Wizard::make([
                    // Define the first step with custom schema for 'Prasyarat'.
                    Step::make('Prasyarat')
                        ->icon('heroicon-o-document-text')
                        ->schema(
                            self::makeBlockBuilder('prasyarat', 'Prasyarat Layanan')
                        ),
                    // Define the second step with custom schema for 'Formulir'.
                    Step::make('Formulir')
                        ->icon('heroicon-o-document-check')
                        ->schema(
                            self::makeBlockBuilder('formulir', 'Formulir Layanan')
                        ),
                ])->submitAction(new HtmlString(
                    // Custom submit button HTML for form submission.
                    '<button class="mt-4 px-3 py-2 font-semibold bg-red-600 text-sm rounded-md text-white" type="submit">
                        Ajukan Ulang
                    </button>'
                ))
            ])
            ->statePath('permohonanData') // Bind form data to $permohonanData.
            ->model($this->permohonan); // Set the model for the form.
    }

    public function save(): void
    {
        // Retrieve form state data.
        $data = $this->editPermohonanForm->getState();

        // Update the LayananPermohonan model with form data.
        $this->permohonan->update($data);

        // Log the status in the LayananPermohonanHistory model.
        $this->permohonan->histories()->create([
            'status' => LayananPermohonanHistory::DIBUAT,
            'note' => "Permohonan telah diajukan kembali.",
        ]);

        // Send a success notification to the user.
        Notification::make()
            ->title('Ajuan permohonan berhasil.')
            ->success()
            ->viewData([
                'permohonanId' => $this->permohonan->id,
                'permohonanStatus' => LayananPermohonanHistory::DIBUAT
            ])
            ->body('Permohonan layanan ' . Str::lower($this->permohonan->layanan->nama) . ' telah berhasil diajukan.')
            ->send()
            ->sendToDatabase(auth()->user());

        // Redirect to the main permohonan page after saving.
        $this->redirectRoute('permohonan.index');
    }

    private static function makeBlockBuilder(string $title, string $desc): array
    {
        // Create a block builder schema based on the provided title and description.
        return [
            Builder::make($title)
                ->label($desc)
                ->blocks([
                    // Block for short answer text input.
                    Block::make('string')
                        ->label(fn(?array $state): string => $state === null ? 'Jawaban Singkat' : ($state['question'] ?? 'Pertanyaan tanpa judul'))
                        ->icon('heroicon-o-bars-2')
                        ->schema([
                            TextInput::make('content')->label('')->helperText(function (Get $get) {
                                // Helper text for the TextInput field.
                                return new HtmlString('<p class="text-rose-500 text-xs italic">' . $get('helperText') . '</p>');
                            })->required(),
                            Textarea::make('note')->label('Catatan')->readOnly(), // Read-only note field.
                        ]),
                    // Block for paragraph text area.
                    Block::make('textarea')
                        ->label(fn(?array $state): string => $state === null ? 'Paragraf' : ($state['question'] ?? 'Pertanyaan tanpa judul'))
                        ->icon('heroicon-o-bars-3-bottom-left')
                        ->schema([
                            Textarea::make('content')->label('')->helperText(function (Get $get) {
                                return new HtmlString('<p class="text-rose-500 text-xs italic">' . $get('helperText') . '</p>');
                            })->required()->markAsRequired(false),
                            Textarea::make('note')->label('Catatan')->readOnly(),
                        ]),
                    // Block for date picker input.
                    Block::make('datepicker')
                        ->label(fn(?array $state): string => $state === null ? 'Tanggal' : ($state['question'] ?? 'Pertanyaan tanpa judul'))
                        ->icon('heroicon-o-calendar-days')
                        ->schema([
                            DatePicker::make('content')->label('')->helperText(function (Get $get) {
                                return new HtmlString('<p class="text-rose-500 text-xs italic">' . $get('helperText') . '</p>');
                            })->required(),
                            Textarea::make('note')->label('Catatan')->readOnly(),
                        ]),
                    // Block for file upload input.
                    Block::make('file')
                        ->label(fn(?array $state): string => $state === null ? 'Upload File' : ($state['question'] ?? 'Pertanyaan tanpa judul'))
                        ->icon('heroicon-o-cloud-arrow-up')
                        ->schema([
                            FileUpload::make('content')->label('')->helperText(function (Get $get) {
                                return new HtmlString('<p class="text-rose-500 text-xs italic">' . $get('helperText') . '</p>');
                            })
                                ->directory('permohonan/' . auth()->user()->id) // Set upload directory based on user ID.
                                ->getUploadedFileNameForStorageUsing(
                                    fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                        ->prepend('document-' . Str::slug(auth()->user()->name) . '-')
                                )
                                ->acceptedFileTypes(['application/pdf']) // Restrict accepted file types to PDF.
                                ->openable()
                                ->deletable(true)
                                ->required(),
                            Textarea::make('note')->label('Catatan')->readOnly(),
                        ]),
                    // Block for image upload input.
                    Block::make('image')
                        ->label(fn(?array $state): string => $state === null ? 'Upload Gambar' : ($state['question'] ?? 'Pertanyaan tanpa judul'))
                        ->icon('heroicon-o-photo')
                        ->schema([
                            FileUpload::make('content')->label('')->helperText(function (Get $get) {
                                return new HtmlString('<p class="text-rose-500 text-xs italic">' . $get('helperText') . '</p>');
                            })
                                ->directory('permohonan/' . auth()->user()->id)
                                ->getUploadedFileNameForStorageUsing(
                                    fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                                        ->prepend('image-' . Str::slug(auth()->user()->name) . '-')
                                )
                                ->imageEditor() // Enable image editor.
                                ->image() // Restrict file types to images.
                                ->deletable(true)
                                ->previewable()
                                ->required(),
                            Textarea::make('note')->label('Catatan')->readOnly(),
                        ]),
                ])
                ->addable(false)
                ->reorderableWithDragAndDrop(false)
                ->deletable(false)
                ->blockNumbers(false), // Disable block numbering.
        ];
    }

    public function render(): View
    {
        // Render the associated view for this component.
        return view('livewire.permohonan.edit-permohonan');
    }
}
