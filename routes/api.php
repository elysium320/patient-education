<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => [
    'api',
 ]], function () {
    Route::get('/lessons', 'App\Http\Controllers\ApiController@getLessons');
    Route::get('/categories', 'App\Http\Controllers\ApiController@getCategories');
    Route::get('/categories', 'App\Http\Controllers\CategoryController@index');
    Route::get('/lessons/{id}', 'App\Http\Controllers\ApiController@showLesson');
    Route::post('/lessons', 'App\Http\Controllers\ApiController@storeLesson');

    Route::post('/lessons-update/{id}', 'App\Http\Controllers\ApiController@updateLesson');
    Route::delete('/delete-lesson/{id}', 'App\Http\Controllers\ApiController@deleteLesson');

    Route::post('/lessons/image', 'App\Http\Controllers\ImageController@upload');
    Route::post('/lessons/video', 'App\Http\Controllers\VideoController@upload');
    Route::post('/lessons/external-video', 'App\Http\Controllers\VideoController@externalUpload');
    Route::get('/question-types', 'App\Http\Controllers\QuizController@getQuestionTypes');
    Route::post('/quiz-results', 'App\Http\Controllers\QuizController@storeQuizResults');
    Route::post('/questions', 'App\Http\Controllers\QuizController@store');
    Route::post('/update-questions', 'App\Http\Controllers\QuizController@update');
    Route::post('/users/update', 'App\Http\Controllers\UserController@update');
    Route::post('/admin/create-account', 'App\Http\Controllers\api\ApiAdminController@create_acount');
    Route::post('/delete-question/{id}', 'App\Http\Controllers\QuizController@deleteQuestion');

});

Route::group(['middleware' => ['cors', 'json.response']], function () {

    Route::post('/login', 'App\Http\Controllers\Auth\ApiAuthController@login')->name('login.api');
    Route::post('/register', 'Auth\ApiAuthController@register')->name('register.api');
    Route::post('/logout', 'Auth\ApiAuthController@logout')->name('logout.api');
});

Route::get('/quizzes', 'App\Http\Controllers\api\ApiQuizzesController@allQuiz');
Route::delete('/delete-quiz/{id}', 'App\Http\Controllers\api\ApiQuizzesController@deleteQuiz');
Route::post('create-module', 'App\Http\Controllers\api\ApiModuleController@create_module');
Route::post('update-module', 'App\Http\Controllers\api\ApiModuleController@update_module');
Route::post('delete-module/{id}', 'App\Http\Controllers\api\ApiModuleController@delete');
Route::get('module-with-lesson', 'App\Http\Controllers\api\ApiModuleController@module_with_lesson');


// Admin  Api
