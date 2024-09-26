<?php
namespace Teacher;

use App\Http\Controllers\api\v1\teacher\LiveSessionsController;
use App\Http\Controllers\api\v1\teacher\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::controller(ProfileController::class)->prefix('profile')->group(function () {
        Route::get('view','show')->name('profile.view');
    });
    Route::controller(LiveSessionsController::class)->prefix('live')->group(function () {
        Route::get('view','show')->name('profile.view');
    });
});
