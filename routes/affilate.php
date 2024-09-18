<?php
namespace affilate;

use App\Http\Controllers\api\v1\affiliate\AffiliateController;
use App\Http\Controllers\api\v1\affiliate\BonusController;
use App\Http\Controllers\api\v1\affiliate\PayoutController;
use App\Http\Controllers\api\v1\affiliate\ProfileController;
use App\Http\Controllers\api\v1\student\setting\SettingController;
use Illuminate\Support\Facades\Route;



Route::controller(AffiliateController::class)->middleware(['auth:sanctum','IsAffilate'])->prefix('auth')->group(function () {
    Route::post('signup','store')->withoutMiddleware(['auth:sanctum','IsAffilate'])->name('affilate.signup');
});
Route::middleware(['auth:sanctum', 'IsAffilate'])->group(function () {
    Route::controller(ProfileController::class)->prefix('profile')->group(function () {
        Route::get('view','show')->name('affilate.profile');
        Route::post('update','modify')->name('affilate.modify');
    });
    Route::controller(PayoutController::class)->prefix('account')->group(function () {
        Route::post('withdraw','payout')->name('affilate.payout');
    });
    Route::controller(BonusController::class)->prefix('bonus')->group(function () {
        Route::get('/view','get_bonus')->name('affilate.bonus');
    });

    
});
        Route::middleware(['auth:sanctum','IsAffilate'])->group(function(){
                     Route::prefix('setting')->controller(SettingController::class)->group(function () {
                     Route::get('video','videos_explain')->name('setting.view');
                     }); // Guest Data
        });
