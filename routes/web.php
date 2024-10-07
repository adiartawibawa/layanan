<?php

use App\Livewire\Layanan\ListLayanan;
use App\Livewire\Layanan\ViewLayanan;
use App\Livewire\Notification\AllNotification;
use App\Livewire\Permohonan\CreatePermohonan;
use App\Livewire\Permohonan\DetailPermohonan;
use App\Livewire\Permohonan\EditPermohonan;
use App\Livewire\Permohonan\ListPermohonan;
use App\Livewire\Posts\AllPosts;
use App\Livewire\Posts\DetailPosts;
use App\Livewire\Sekolah\DetailSekolah;
use App\Livewire\Sekolah\PetaSekolah;
use App\Livewire\Welcome\DetailService;
use App\Livewire\Welcome\TestimonialForm;
use App\Models\Layanan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::prefix('berita')->name('berita.')->group(function () {
    Route::get('/all', AllPosts::class)->name('all');
    Route::get('/{slug}', DetailPosts::class)->name('detail');
});

Route::get('/testimonial', TestimonialForm::class)->name('testimonial.create');

Route::get('/layanan/{slug}', DetailService::class)->name('layanan.detail');

Route::get('/sekolah/peta', PetaSekolah::class)->name('sekolah.map');
Route::get('/sekolah/{npsn}/detail', DetailSekolah::class)->name('sekolah.detail');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Layanan
    Route::get('/layanan', ListLayanan::class)->name('layanan.index');
    Route::get('/layanan/{slug}/view', ViewLayanan::class)->name('layanan.view');

    // Permohonan
    Route::get('/permohonan/all', ListPermohonan::class)->name('permohonan.index');
    Route::get('/permohonan/{slug}/create', CreatePermohonan::class)->name('permohonan.create');
    Route::get('/permohonan/{permohonan}/edit', EditPermohonan::class)->name('permohonan.edit');
    Route::get('/permohonan/{permohonan}/detail', DetailPermohonan::class)->name('permohonan.detail');

    // Notifikasi
    Route::get('/all-notifications', AllNotification::class)->name('all.notifications');
});
