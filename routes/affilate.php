<?php
namespace affilate;

use App\Http\Controllers\api\v1\affiliate\AffiliateController;
use App\Http\Controllers\api\v1\affiliate\ProfileController;
use Illuminate\Support\Facades\Route;



Route::controller(AffiliateController::class)->middleware(['auth:sanctum','IsAffilate'])->prefix('auth')->group(function () {
    Route::post('signup','store')->withoutMiddleware(['auth:sanctum','IsAffilate'])->name('affilate.signup');
});
Route::controller(ProfileController::class)->middleware(['auth:sanctum','IsAffilate'])->prefix('profile')->group(function () {
    Route::post('view','show')->name('affilate.profile');
    Route::post('update','modify')->name('affilate.modify');
});
