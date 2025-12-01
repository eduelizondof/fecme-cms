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
    Route::get('blogs/{id}', [PublicApiController::class, 'blog'])->name('blog');
    Route::get('services', [PublicApiController::class, 'services'])->name('services');
    Route::get('services/{id}', [PublicApiController::class, 'service'])->name('service');
    Route::get('breeders', [PublicApiController::class, 'breeders'])->name('breeders');
    Route::get('breeders/{id}', [PublicApiController::class, 'breeder'])->name('breeder');
    Route::get('certificates', [PublicApiController::class, 'certificates'])->name('certificates');
    Route::get('certificates/validate/{microchip}', [PublicApiController::class, 'validateCertificate'])->name('certificates.validate');
    Route::get('events', [PublicApiController::class, 'events'])->name('events');
    Route::get('events/{id}', [PublicApiController::class, 'event'])->name('event');
    Route::get('schools', [PublicApiController::class, 'schools'])->name('schools');
    Route::get('schools/{id}', [PublicApiController::class, 'school'])->name('school');
    Route::get('judges', [PublicApiController::class, 'judges'])->name('judges');
    Route::get('judges/{id}', [PublicApiController::class, 'judge'])->name('judge');
    Route::get('header', [PublicApiController::class, 'header'])->name('header');
    Route::get('footer', [PublicApiController::class, 'footer'])->name('footer');
});

