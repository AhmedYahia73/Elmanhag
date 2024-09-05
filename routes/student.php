<?php
namespace Student;

use App\Http\Controllers\api\v1\student\chapter\ChapterController;
use App\Http\Controllers\api\v1\student\HomeWorkController;
use App\Http\Controllers\api\v1\student\lesson\LessonController;
use App\Http\Controllers\api\v1\student\setting\SettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\StudentMiddleware;
use App\Http\Controllers\api\v1\student\LoginController;
use App\Http\Controllers\api\v1\student\SignupController;
use App\Http\Controllers\api\v1\student\profile\ProfileController;
use App\Http\Controllers\api\v1\student\subject\SubjectController;
use App\Http\Controllers\api\v1\student\bundles\BundlesController;
use App\Http\Controllers\api\v1\student\Payment\PlaceOrderController;

Route::prefix('auth')->group(function () {
    Route::controller(SignupController::class)->group(function () {
        Route::post('signup/create','store')->name('student.signup');
    });
    Route::controller(LoginController::class)->group(function () {
        Route::post('login','login')->name('login.index');
        Route::post('logout','logout')->name('logout')->middleware(['auth:sanctum']);
    });
});

Route::prefix('profile')->middleware(['auth:sanctum','IsStudent'])->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('view','profile')->name('profile.view');
        Route::post('modify','update')->name('profile.view');
        Route::post('delete','delete_account')->name('profile.delete');
    });
});
Route::middleware(['auth:sanctum','IsStudent'])->group(function(){
        Route::prefix('setting')->group(function () {
            Route::controller(SettingController::class)->withoutMiddleware(['auth:sanctum','IsStudent'])->group(function () {
                Route::get('view','show')->name('setting.view');
            }); // Guest Data
            Route::controller(SubjectController::class)->group(function () { // This All Subject For Student
                Route::post('subject/view','show')->name('setting.view');
                Route::get('subject/student','student_subject')->name('setting.view');
            });
        });
        Route::controller(ChapterController::class)->group(function () { // This All Chapters For Student
                Route::prefix('mySubject')->group(function () {
                    Route::post('chapter/view', 'show')->name('student_chapter_view');
                });
                  Route::prefix('subject')->group(function () {
                  Route::post('chapter/view', 'chapters')->name('chapters');
                  });
        });
        Route::controller(LessonController::class)->group(function () { // This All Chapters For Student
                Route::prefix('chapter')->group(function () {
                    Route::post('lesson/view', 'show_lesson')->name('student_chapter_view');
                });
        });
        Route::controller(HomeWorkController::class)->group(function () { // This All Chapters For Student
                Route::prefix('chapter')->group(function () {
                    Route::post('lesson/MyHmework', 'show')->name('student_homework_view');
                });
        });
        Route::controller(BundlesController::class)->group(function () { // This All Chapters For Student
                Route::prefix('bundles')->group(function () {
                    Route::get('/', 'show')->name('student_bundels_view');
                });
        });
        Route::controller(PlaceOrderController::class)->group(function () { // This All Chapters For Student
                Route::prefix('order')->group(function () {
                    Route::post('/place', 'place_order')->name('order.place');
                });
        });

        

        
});
