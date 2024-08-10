<?php
namespace Admin;

use App\Http\Controllers\api\v1\admin\student\CreateStudent;
use App\Http\Controllers\api\v1\admin\student\CreateStudentController;
use App\Http\Controllers\api\v1\admin\student\StudentsDataController;

use App\Http\Controllers\api\v1\admin\Category\CategoryController;
use App\Http\Controllers\api\v1\admin\Category\CreateCategoryController;

use App\Http\Controllers\api\v1\admin\Subject\SubjectController;
use App\Http\Controllers\api\v1\admin\Subject\CreateSubjectController;

use App\Http\Controllers\api\v1\admin\chapter\ChapterController;
use App\Http\Controllers\api\v1\admin\chapter\CreateChapterController;

use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum'])->group(function () {
    // Start Module Student Sign UP
    Route::prefix('student')->group(function () {
        Route::controller(StudentsDataController::class)->group(function () {
            Route::get('/', 'show')->name('student.show');
        });
        Route::controller(CreateStudentController::class)->group(function () {
            Route::post('/add', 'store')->name('student.add');
            Route::post('/update/{id}', 'modify')->name('student.modify');
            Route::get('/delete/{id}', 'delete')->name('student.delete');
        });
    });

    // Start Category Module
    Route::prefix('category')->group(function () {
        Route::controller(CategoryController::class)->group(function(){
            Route::get('/', 'show')->name('category.show');
        });
        Route::controller(CreateCategoryController::class)->group(function(){
            Route::post('/add', 'create')->name('category.add');
            Route::post('/update/{id}', 'modify')->name('category.update');
            Route::get('/delete/{id}', 'delete')->name('category.delete');
        });
    });

    // Start Subject Module
    Route::prefix('subject')->group(function () {
        Route::controller(SubjectController::class)->group(function(){
            Route::get('/', 'show')->name('subject.show');
        });
        Route::controller(CreateSubjectController::class)->group(function(){
            Route::post('/add', 'create')->name('subject.add');
            Route::post('/update/{id}', 'modify')->name('subject.update');
            Route::get('/delete/{id}', 'delete')->name('subject.delete');
        });
    });

    // Start Chapter Module
    Route::prefix('chapter')->group(function () {
        Route::controller(ChapterController::class)->group(function(){
            Route::get('/', 'show')->name('subject.show');
        });
        Route::controller(CreateChapterController::class)->group(function(){
            Route::post('/add/{sub_id}', 'create')->name('subject.add');
            Route::post('/update/{id}', 'modify')->name('subject.update');
            Route::get('/delete/{id}', 'delete')->name('subject.delete');
        });
    });
});