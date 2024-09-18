<?php

// use App\Http\Controllers\api\v1\payment\PaymentController;
use App\Http\Controllers\Api\FawryPayController;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\v1\auth\LoginController;
use App\Http\Controllers\api\v1\auth\SignupController;

use App\Http\Controllers\api\v1\admin\ProfileAdminController;

use App\Http\Controllers\api\v1\student\SubjectsController;
use App\Http\Controllers\api\v1\student\ProfileController as ProfileStudentController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Route::middleware('auth:sanctum')->prefix('Student')->group(function () {
//     Route::controller(ProfileStudentController::class)->prefix('Profile')->group(function () {
//         Route::get('/','index')->name('stu_profile');
//         Route::post('/Update','update_profile')->name('stu_update_profile');
//     });
// });

Route::controller(LoginController::class)->prefix('admin')->group(function () {
    Route::post('auth/login','login')->name('login');
    Route::post('auth/logout','logout')->name('user.logout')->middleware('auth:sanctum');
});

// Route::controller(LoginController::class)->prefix('user')->group(function () {
//     Route::post('auth/login','user_login')->name('user_login');
// });

Route::controller(SignupController::class)->prefix('admin')->group(function () {
    Route::get('auth/signup','signup')->name('signup');
    Route::post('auth/signup_proccess','signup_proccess')->name('signup_proccess');
});
Route::controller(ProfileAdminController::class)->prefix('admin')->group(function () {
    Route::get('profile/view','view')->name('profile.admin')->middleware('auth:sanctum');
});

Route::middleware(['auth:sanctum','IsStudent'])->group(function () {
    Route::post('/pay-at-fawry', [FawryPayController::class, 'payAtFawry']);
    Route::post('fawry/check-status', [FawryPayController::class, 'checkPaymentStatus']);
});



Route::get('/unauthorized', function () {
return response()->json(['error'=>'Unauthorized'],401);
})->name('unauthorized');
