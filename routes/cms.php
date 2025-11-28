<?php

use App\Http\Controllers\Cms\BlogController;
use App\Http\Controllers\Cms\BreederController;
use App\Http\Controllers\Cms\CertificateController;
use App\Http\Controllers\Cms\EventController;
use App\Http\Controllers\Cms\JudgeController;
use App\Http\Controllers\Cms\MediaController;
use App\Http\Controllers\Cms\SchoolController;
use App\Http\Controllers\Cms\ServiceController;
use App\Http\Controllers\Cms\SiteSettingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->prefix('cms')->name('cms.')->group(function () {
    // Blog
    Route::resource('blogs', BlogController::class)->except(['show']);

    // Services
    Route::resource('services', ServiceController::class)->except(['show']);

    // Breeders
    Route::resource('breeders', BreederController::class)->except(['show']);

    // Certificates
    Route::resource('certificates', CertificateController::class)->except(['show']);

    // Events
    Route::resource('events', EventController::class)->except(['show']);

    // Schools
    Route::resource('schools', SchoolController::class)->except(['show']);

    // Judges
    Route::resource('judges', JudgeController::class)->except(['show']);

    // Site Settings
    Route::get('settings', [SiteSettingController::class, 'index'])->name('settings.index');
    Route::put('settings/header', [SiteSettingController::class, 'updateHeader'])->name('settings.header');
    Route::put('settings/footer', [SiteSettingController::class, 'updateFooter'])->name('settings.footer');

    // Media
    Route::get('media', [MediaController::class, 'index'])->name('media.index');
    Route::post('media', [MediaController::class, 'store'])->name('media.store');
    Route::put('media/{media}', [MediaController::class, 'update'])->name('media.update');
    Route::delete('media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');
});

