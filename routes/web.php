<?php

use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\AlbumController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\DjController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\EventosController;
use App\Http\Controllers\Web\DjsController;
use App\Http\Controllers\Web\GaleriaController;
use App\Http\Controllers\Web\NosotrosController;
use App\Http\Controllers\Web\ContactoController;
use App\Http\Controllers\Web\AlianzasController;
use Illuminate\Support\Facades\Route;

// Rutas Públicas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/eventos', [EventosController::class, 'index'])->name('eventos');
Route::get('/djs', [DjsController::class, 'index'])->name('djs');
Route::get('/galeria', [GaleriaController::class, 'index'])->name('galeria');
Route::get('/galeria/{slug}', [GaleriaController::class, 'show'])->name('galeria.album');
Route::get('/nosotros', [NosotrosController::class, 'index'])->name('nosotros');
Route::get('/alianzas', [AlianzasController::class, 'index'])->name('alianzas');
Route::get('/contacto', [ContactoController::class, 'index'])->name('contacto');

Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('djs', DjController::class);
    Route::resource('events', EventController::class);
    Route::resource('albums', AlbumController::class);
    Route::resource('gallery', GalleryController::class);
    Route::resource('partners', PartnerController::class);

    // Sobre Nosotros
    Route::get('/about', [AboutUsController::class, 'index'])->name('about.index');
    Route::put('/about', [AboutUsController::class, 'update'])->name('about.update');

    // Configuraciones Globales
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::delete('/settings/slide/{key}', [SettingController::class, 'deleteSlide'])->name('settings.slide.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
