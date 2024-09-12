<?php
namespace Parent;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\v1\parent\childreen\ChildreenController;
use App\Http\Controllers\api\v1\parent\profile\ProfileController;
use App\Http\Controllers\api\v1\parent\notifications\NotificationController;

Route::middleware(['auth:sanctum', 'IsParent'])->group(function(){    
    // Start Childreen Module
    Route::prefix('childreen')->group(function() {
        Route::controller(ChildreenController::class)->group(function(){
            Route::get('/', 'show')->name('childreen.show');
            Route::put('/profile/{id}', 'child_profile')->name('childreen.child_profile');
        });
    });
    // Start Profile Module
    Route::prefix('profile')->group(function() {
        Route::controller(ProfileController::class)->group(function(){
            Route::put('/', 'modify')->name('profile.update');
        });
    });
    // Start Profile Module
    Route::prefix('profile')->group(function() {
        Route::controller(ProfileController::class)->group(function(){
            Route::put('/', 'modify')->name('profile.update');
        });
    });
    // Start Notifications Module
    Route::prefix('notification')->group(function() {
        Route::controller(NotificationController::class)->group(function(){
            Route::put('/', 'show')->name('notification.show');
        });
    });
});