<?php
namespace affilate;

use App\Http\Controllers\api\v1\affiliate\AffiliateController;
use Illuminate\Support\Facades\Route;



Route::controller(AffiliateController::class)->middleware(['auth:sanctum','IsAffilate'])->prefix('auth')->group(function () {
    Route::post('signup','store')->withoutMiddleware(['auth:sanctum','IsAffilate']);
});
