<?php

namespace App\Livewire\Permohonan;

use App\Events\LayananPermohonanCreated;
use App\Models\Layanan;
use App\Models\LayananPermohonan;
use App\Models\LayananPermohonanHistory;
use App\Notifications\LayananPermohonanNotification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class FormWizard extends Component implements HasForms
{
    use InteractsWithForms;

    // Deklarasi properti
    public Layanan $layanan;
    public ?array $formData = [];
    public $formFields = [];
    public $prerequisites = [];
    public $layananID;
    public $recordId;
    public $editMode = false;

    // Metode untuk menginisialisasi komponen
    public function mount($recordId = null)
    {
        // Mengambil data formulir dan prasyarat dari model Layanan
        $this->formFields = $this->layanan->formulir ?? [];
        $this->prerequisites = $this->layanan->prasyarat ?? [];
        $this->layananID = $this->layanan->id ?? [];

        // Mengisi nilai awal formData dengan nilai kosong
        foreach ($this->prerequisites as $field) {
            $this->formData[$field['nama']] = '';
        }
        foreach ($this->formFields as $field) {
            $this->formData[$field['nama']] = '';
        }

        // Jika ada $recordId, artinya mode edit, maka load data record
        if ($recordId) {
            $this->editMode = true;
            $this->recordId = $recordId;
            $this->loadRecord($recordId);
        }
    }

    // Metode untuk memuat data record yang akan diedit
    public function loadRecord($id)
    {
        $record = LayananPermohonan::findOrFail($id);
        foreach ($record->getAttributes() as $key => $value) {
            $this->formData[$key] = $value;
        }
    }

    // Metode untuk mendefinisikan form menggunakan Filament Forms
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Prasyarat')
                        ->schema([
                            Group::make($this->getPrerequisiteFields())
                        ]),
                    Step::make('Formulir')
                        ->schema([
                            Group::make($this->getFormFields())
                        ]),
                ])
                    ->submitAction(new HtmlString('<button type="submit">Submit</button>'))
            ])
            ->statePath('formData');
    }

    // Metode untuk mendapatkan fields prasyarat dari layanan
    protected function getPrerequisiteFields(): array
    {
        $fields = [];
        foreach ($this->prerequisites as $field) {
            $slug = Str::slug($field['nama']);

            // Bangun komponen form berdasarkan jenis field prasyarat
            $fields[] = match ($field['type']) {
                'string' => TextInput::make("prerequisiteData.{$slug}.value")
                    ->label($field['desc'])
                    ->required($field['required']),
                'text' => Textarea::make("prerequisiteData.{$slug}.value")
                    ->label($field['desc'])
                    ->required($field['required']),
                'image' => FileUpload::make("prerequisiteData.{$slug}.value")
                    ->label($field['desc'])
                    ->directory('permohonan/' . auth()->user()->id)
                    ->getUploadedFileNameForStorageUsing(
                        fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                            ->prepend('image-' . Str::slug(auth()->user()->name) . '-')
                    )
                    ->image(),
                'file' => FileUpload::make("prerequisiteData.{$slug}.value")
                    ->label($field['desc'])
                    ->directory('permohonan/' . auth()->user()->id)
                    ->getUploadedFileNameForStorageUsing(
                        fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                            ->prepend('document-' . Str::slug(auth()->user()->name) . '-')
                    )
                    ->acceptedFileTypes(['application/pdf']),
                'date' => DatePicker::make("prerequisiteData.{$slug}.value")
                    ->label($field['desc'])
                    ->required($field['required']),
                default => null,
            };
        }
        return $fields;
    }

    // Metode untuk mendapatkan fields formulir dari layanan
    protected function getFormFields(): array
    {
        $fields = [];
        foreach ($this->formFields as $field) {
            $slug = Str::slug($field['nama']);
            $fields[] = match ($field['type']) {
                'string' => TextInput::make("formData.{$slug}.value")
                    ->label($field['desc'])
                    ->required($field['required']),
                'text' => Textarea::make("formData.{$slug}.value")
                    ->label($field['desc'])
                    ->required($field['required']),
                'image' => FileUpload::make("formData.{$slug}.value")
                    ->label($field['desc'])
                    ->directory('permohonan/' . auth()->user()->id)
                    ->getUploadedFileNameForStorageUsing(
                        fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                            ->prepend('image-' . Str::slug(auth()->user()->name) . '-')
                    )
                    ->image(),
                'file' => FileUpload::make("formData.{$slug}.value")
                    ->label($field['desc'])
                    ->directory('permohonan/' . auth()->user()->id)
                    ->getUploadedFileNameForStorageUsing(
                        fn (TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                            ->prepend('document-' . Str::slug(auth()->user()->name) . '-')
                    )
                    ->acceptedFileTypes(['application/pdf']),
                'date' => DatePicker::make("formData.{$slug}.value")
                    ->label($field['desc'])
                    ->required($field['required']),
                default => null,
            };
        }
        return $fields;
    }

    // Metode untuk menangani submit form
    public function submit()
    {
        // Validasi form menggunakan form state
        $this->form->validate();

        // Ambil data form state setelah divalidasi
        $formData = $this->form->getState();

        // Proses prasyarat untuk disimpan
        $prasyaratData = [];
        foreach ($this->prerequisites as $field) {
            $slug = Str::slug($field['nama']);
            $prasyaratData[] = [
                'nama' => $field['nama'],
                'desc' => $field['desc'],
                'value' => $formData['prerequisiteData'][$slug]['value'] ?? '',
                'comment' => '', // Inisialisasi comment dengan string kosong
                'valid' => false, // Inisialisasi valid dengan false
                'type' => $field['type'],
                'required' => $field['required'],
            ];
        }

        // Proses formulir untuk disimpan
        $formulirData = [];
        foreach ($this->formFields as $field) {
            $slug = Str::slug($field['nama']);
            $formulirData[] = [
                'nama' => $field['nama'],
                'desc' => $field['desc'],
                'value' => $formData['formData'][$slug]['value'] ?? '',
                'comment' => '', // Inisialisasi comment dengan string kosong
                'valid' => false, // Inisialisasi valid dengan false
                'type' => $field['type'],
                'required' => $field['required'],
            ];
        }

        // Data yang akan disimpan ke database
        $dataToSave = [
            'user_id' => auth()->id(),
            'layanan_id' => $this->layananID,
            'prasyarat' => $prasyaratData,
            'formulir' => $formulirData,
        ];

        // Cek mode edit atau create
        if ($this->editMode) {
            // Mode edit: cari record berdasarkan ID dan update
            $record = LayananPermohonan::findOrFail($this->recordId);
            $record->update($dataToSave);
            session()->flash('message', 'Record successfully updated.');
        } else {
            // Mode create: buat record baru
            $layananPermohonan = LayananPermohonan::create($dataToSave);
            event(new LayananPermohonanCreated($layananPermohonan)); // Panggil event LayananPermohonanCreated

            Notification::make()
                ->title('Permohonan berhasil.')
                ->success()
                ->viewData([
                    'permohonanId' => $layananPermohonan->id,
                    'permohonanStatus' => LayananPermohonanHistory::DIBUAT
                ])
                ->body('Permohonan layanan ' . Str::lower($this->layanan->nama) . ' telah berhasil diajukan.')
                ->send()
                ->sendToDatabase(auth()->user());

            // auth()->user()->notify(new LayananPermohonanNotification([
            //     'layanan_id' => $this->layananID,
            //     'layanan_nama' => $this->layanan->nama,
            //     'layanan_ilustrasi_url' => $this->layanan->ilustrasi_url,
            //     'status' => LayananPermohonanHistory::DIBUAT,
            // ]));
        }

        // Reset form setelah proses submit selesai
        $this->resetForm();

        $this->redirectRoute('permohonan.index');
    }

    // Metode untuk mereset form ke nilai awal setelah submit
    public function resetForm()
    {
        $this->formData = [];
        $this->editMode = false;
        $this->recordId = null;
    }

    // Metode untuk merender komponen Livewire
    public function render()
    {
        return view('livewire.permohonan.form-wizard');
    }
}
