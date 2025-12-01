<?php

use App\Http\Controllers\Api\PublicApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public API endpoints - same structure as JSON files
Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::get('blogs', [PublicApiController::class, 'blogs'])->name('blogs');
    Route::get('blogs/{slug}', [PublicApiController::class, 'blog'])->name('blog');
    Route::get('services', [PublicApiController::class, 'services'])->name('services');
    Route::get('services/{slug}', [PublicApiController::class, 'service'])->name('service');
    Route::get('breeders', [PublicApiController::class, 'breeders'])->name('breeders');
    Route::get('breeders/{slug}', [PublicApiController::class, 'breeder'])->name('breeder');
    Route::get('certificates', [PublicApiController::class, 'certificates'])->name('certificates');
    Route::get('certificates/validate/{microchip}', [PublicApiController::class, 'validateCertificate'])->name('certificates.validate');
    Route::get('events', [PublicApiController::class, 'events'])->name('events');
    Route::get('events/{slug}', [PublicApiController::class, 'event'])->name('event');
    Route::get('schools', [PublicApiController::class, 'schools'])->name('schools');
    Route::get('schools/{slug}', [PublicApiController::class, 'school'])->name('school');
    Route::get('judges', [PublicApiController::class, 'judges'])->name('judges');
    Route::get('judges/{id}', [PublicApiController::class, 'judge'])->name('judge');
    Route::get('header', [PublicApiController::class, 'header'])->name('header');
    Route::get('footer', [PublicApiController::class, 'footer'])->name('footer');
    Route::get('faqs', [PublicApiController::class, 'faqs'])->name('faqs');
    Route::get('about', [PublicApiController::class, 'about'])->name('about');
    Route::get('features-area', [PublicApiController::class, 'featuresArea'])->name('features-area');
});

