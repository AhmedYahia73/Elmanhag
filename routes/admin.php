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

use App\Http\Controllers\api\v1\admin\lesson\CreateLessonController;

use App\Http\Controllers\api\v1\admin\settings\RelationController;
use App\Http\Controllers\api\v1\admin\settings\CountriesController;

use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum','IsAdmin'])->group(function () {
    // Start Module Student Sign UP
    Route::prefix('student')->group(function () {
        Route::controller(StudentsDataController::class)->group(function () {
            Route::get('/', 'show')->name('student.show');
        });
        Route::controller(CreateStudentController::class)->group(function () {
            Route::post('/add', 'store')->name('student.add');
            Route::put('/update/{id}', 'modify')->name('student.modify');
            Route::delete('/delete/{id}', 'delete')->name('student.delete');
        });
    });

    // Start Category Module
    Route::prefix('category')->group(function () {
        Route::controller(CategoryController::class)->group(function(){
            Route::get('/', 'show')->name('category.show');
        });
        Route::controller(CreateCategoryController::class)->group(function(){
            Route::post('/add', 'create')->name('category.add');
            Route::put('/update/{id}', 'modify')->name('category.update');
            Route::delete('/delete/{id}', 'delete')->name('category.delete');
        });
    });

    // Start Subject Module
    Route::prefix('subject')->group(function () {
        Route::controller(SubjectController::class)->group(function(){
            Route::get('/', 'show')->name('subject.show');
        });
        Route::controller(CreateSubjectController::class)->group(function(){
            Route::post('/add', 'create')->name('subject.add');
            Route::put('/update/{id}', 'modify')->name('subject.update');
            Route::delete('/delete/{id}', 'delete')->name('subject.delete');
        });
    });

    // Start Chapter Module
    Route::prefix('chapter')->group(function () {
        Route::controller(ChapterController::class)->group(function(){
            Route::get('/', 'show')->name('subject.show');
        });
        Route::controller(CreateChapterController::class)->group(function(){
            Route::post('/add/{sub_id}', 'create')->name('subject.add');
            Route::put('/update/{id}', 'modify')->name('subject.update');
            Route::delete('/delete/{id}', 'delete')->name('subject.delete');
        });
    });

    // Start Lesson Module
    Route::prefix('lesson')->group(function () {
        Route::controller(CreateLessonController::class)->group(function(){
            Route::post('/add/{sub_id}', 'create')->name('lesson.add');
            Route::put('/update/{id}', 'modify')->name('lesson.update');
            Route::delete('/delete/{id}', 'delete')->name('lesson.delete');
        });
    });

    // Start Settings Module
    Route::prefix('Settings')->group(function () {
        // Start Parent Relations
        Route::prefix('relation')->group(function () {
            Route::controller(RelationController::class)->group(function(){
                Route::get('/', 'show')->name('relation.show');
                Route::post('/add', 'create')->name('relation.add');
                Route::put('/update/{id}', 'modify')->name('relation.update');
                Route::delete('/delete/{id}', 'delete')->name('relation.delete');
            });
        }); 
        // Start Countries
        Route::prefix('countries')->group(function () {
            Route::controller(CountriesController::class)->group(function(){
                Route::get('/', 'show')->name('countries.show');
                Route::post('/add', 'create')->name('countries.add');
                Route::put('/update/{id}', 'modify')->name('countries.update');
                Route::delete('/delete/{id}', 'delete')->name('countries.delete');
            });
        });
    });
});
