<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::redirect('/', '/en');
//Route::group(['prefix' => '{language}'], function (){

    Route::get('en', function() {
        session(['locale' => 'en']);
        return back();
    });

    Route::get('es', function() {
        session(['locale' => 'es']);
        return back();
    });

    Route::get('/modules', 'App\Http\Controllers\ModuleController@index')->name('modules');
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/modules/{id}', 'App\Http\Controllers\ModuleController@show');
    Route::get('/modules', 'App\Http\Controllers\ModuleController@index')->name('modules');
    Route::get('/modules/{moduleId}/lessons/{lessonId}', 'App\Http\Controllers\SingleLessonController@index');

    Route::get('/language/{locale}', 'App\Http\Controllers\LessonController@setLocale');
    Route::get('/lessons', 'App\Http\Controllers\LessonController@index')->name('lessons');
    Route::get('/lessons/{id}', 'App\Http\Controllers\SingleLessonController@singleLesson');
    Route::get('/quizzes', 'App\Http\Controllers\QuizController@index')->name('quizzes');
    Route::get('/quizzes/{id}', 'App\Http\Controllers\QuizController@show')->name('quizzes/{id}');
    Route::get('/quiz/report-card/{quizId}', 'App\Http\Controllers\ReportCardController@index');

    Route::get('/quiz/get-results/{quizId}', 'App\Http\Controllers\ReportCardController@getResults');
    Route::get('/glossary', 'App\Http\Controllers\GlossaryController@index');

        Route::middleware(['auth:sanctum'])->group(function () {
          Route::get('/admin', 'App\Http\Controllers\AdminController@index')->name('admin');

          Route::get('/admin/profile', 'App\Http\Controllers\AdminController@profile')->name('admin/profile');

          Route::get('/admin/modules', 'App\Http\Controllers\AdminController@modules')->name('admin/modules');
          Route::get('/admin/lessons', 'App\Http\Controllers\AdminController@lessons')->name('admin/lessons');
          Route::get('/admin/update-lesson/{id}', 'App\Http\Controllers\AdminController@showUpdateForm')->name('admin/update-lesson/{id}');
          Route::get('/admin/modules/{id}/lessons', 'App\Http\Controllers\AdminController@getModuleLessons')->name('admin/modules/{id}/lessons');

          Route::get('/admin/quizzes', 'App\Http\Controllers\AdminController@quizzes')->name('admin/quizzes');


          Route::get('/admin/create-lesson', 'App\Http\Controllers\AdminController@createLesson')->name('admin/create-lesson');
          Route::get('/admin/create-module', 'App\Http\Controllers\AdminController@createModule')->name('admin/create-module');
          Route::get('/admin/modules/update-module/{id}', 'App\Http\Controllers\AdminController@editModule');

          Route::get('/admin', 'App\Http\Controllers\AdminController@index')->name('admin');

          Route::get('/admin/analytic', 'App\Http\Controllers\AnalyticController@index')->name('admin/analytics');
        });

    Auth::routes();
    Route::get('/about', [App\Http\Controllers\AboutController::class, 'index'])->name('about');
    Route::get('/admin/create-account', 'App\Http\Controllers\AdminController@createAccount');
//    });
