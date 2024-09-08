<?php

namespace App\Livewire\Permohonan;

use App\Models\LayananPermohonan;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\HtmlString;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Support\Str;

class DetailPermohonan extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $permohonanData = [];
    public LayananPermohonan $permohonan;

    public function mount(): void
    {
        $this->viewPermohonanForm->fill($this->permohonan->toArray());
    }

    protected function getForms(): array
    {
        return [
            'viewPermohonanForm',
        ];
    }

    public function viewPermohonanForm(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Prasyarat')
                        ->icon('heroicon-o-document-text')
                        ->schema(
                            self::makeBlockBuilder('prasyarat', 'Prasyarat Layanan')
                        ),
                    Step::make('Formulir')
                        ->icon('heroicon-o-document-check')
                        ->schema(
                            self::makeBlockBuilder('formulir', 'Formulir Layanan')
                        ),
                ])
            ])
            ->statePath('permohonanData')
            ->model($this->permohonan);
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
                            })->readOnly()->required(),
                            Textarea::make('note')->label('Catatan')->readOnly(),
                            Toggle::make('valid')->label('Validasi')->onColor('success')->onIcon('heroicon-o-check')->offColor('danger')->offIcon('heroicon-o-x-mark')->inline(),
                        ]),
                    Block::make('textarea')
                        ->label(fn (?array $state): string => $state === null ? 'Paragraf' : ($state['question'] ?? 'Pertanyaan tanpa judul'))
                        ->icon('heroicon-o-bars-3-bottom-left')
                        ->schema([
                            Textarea::make('content')->label('')->helperText(function (Get $get) {
                                return new HtmlString('<p class="text-rose-500 text-xs italic">' . $get('helperText') . '</p>');
                            })->readOnly()->required()->markAsRequired(false),
                            Textarea::make('note')->label('Catatan')->readOnly(),
                            Toggle::make('valid')->label('Validasi')->onColor('success')->onIcon('heroicon-o-check')->offColor('danger')->offIcon('heroicon-o-x-mark')->inline(),
                        ]),
                    Block::make('datepicker')
                        ->label(fn (?array $state): string => $state === null ? 'Tanggal' : ($state['question'] ?? 'Pertanyaan tanpa judul'))
                        ->icon('heroicon-o-calendar-days')
                        ->schema([
                            DatePicker::make('content')->label('')->helperText(function (Get $get) {
                                return new HtmlString('<p class="text-rose-500 text-xs italic">' . $get('helperText') . '</p>');
                            })->readOnly()->required(),
                            Textarea::make('note')->label('Catatan')->readOnly(),
                            Toggle::make('valid')->label('Validasi')->onColor('success')->onIcon('heroicon-o-check')->offColor('danger')->offIcon('heroicon-o-x-mark')->inline(),
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
                                ->openable()
                                ->deletable(false)
                                ->required(),
                            Textarea::make('note')->label('Catatan')->readOnly(),
                            Toggle::make('valid')->label('Validasi')->onColor('success')->onIcon('heroicon-o-check')->offColor('danger')->offIcon('heroicon-o-x-mark')->inline(),
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
                                ->deletable(false)
                                ->previewable()
                                ->required(),
                            Textarea::make('note')->label('Catatan')->readOnly(),
                            Toggle::make('valid')->label('Validasi')->onColor('success')->onIcon('heroicon-o-check')->offColor('danger')->offIcon('heroicon-o-x-mark')->inline(),
                        ]),
                ])
                ->addable(false)
                ->reorderableWithDragAndDrop(false)
                ->deletable(false)
                ->blockNumbers(false)
        ];
    }

    public function save(): void
    {
        dd($this->form->getState());
    }

    public function render(): View
    {
        return view('livewire.permohonan.detail-permohonan');
    }
}
