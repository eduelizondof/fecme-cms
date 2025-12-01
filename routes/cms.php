<?php

use App\Http\Controllers\Cms\AboutController;
use App\Http\Controllers\Cms\BlogController;
use App\Http\Controllers\Cms\BreederController;
use App\Http\Controllers\Cms\CertificateController;
use App\Http\Controllers\Cms\EventController;
use App\Http\Controllers\Cms\FaqController;
use App\Http\Controllers\Cms\FeaturesAreaController;
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

    // FAQ
    Route::resource('faq', FaqController::class)->except(['show']);
    Route::patch('faq/reorder', [FaqController::class, 'reorder'])->name('faq.reorder');

    // About
    Route::get('about', [AboutController::class, 'index'])->name('about.index');
    Route::put('about', [AboutController::class, 'update'])->name('about.update');
    Route::post('about/features', [AboutController::class, 'storeFeature'])->name('about.features.store');
    Route::put('about/features/{feature}', [AboutController::class, 'updateFeature'])->name('about.features.update');
    Route::delete('about/features/{feature}', [AboutController::class, 'destroyFeature'])->name('about.features.destroy');

    // Features Area
    Route::get('features-area', [FeaturesAreaController::class, 'index'])->name('features-area.index');
    Route::put('features-area', [FeaturesAreaController::class, 'update'])->name('features-area.update');
    Route::post('features-area/schedules', [FeaturesAreaController::class, 'storeSchedule'])->name('features-area.schedules.store');
    Route::put('features-area/schedules/{schedule}', [FeaturesAreaController::class, 'updateSchedule'])->name('features-area.schedules.update');
    Route::delete('features-area/schedules/{schedule}', [FeaturesAreaController::class, 'destroySchedule'])->name('features-area.schedules.destroy');
    Route::post('features-area/contact-info', [FeaturesAreaController::class, 'storeContactInfo'])->name('features-area.contact-info.store');
    Route::put('features-area/contact-info/{contactInfo}', [FeaturesAreaController::class, 'updateContactInfo'])->name('features-area.contact-info.update');
    Route::delete('features-area/contact-info/{contactInfo}', [FeaturesAreaController::class, 'destroyContactInfo'])->name('features-area.contact-info.destroy');
});

