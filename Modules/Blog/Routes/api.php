<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/blog', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->prefix('user')->group(function () {
    Route::post('/user-register', 'UserController@UserRegister');
    Route::post('/login', 'UserController@login');
    Route::get('/', 'UserController@index')->middleware(['auth:api', 'role:admin']);
});

// Route::prefix('blog')->group(function () {
//     Route::get('/', 'BlogController@index');
//     Route::post('/store', 'BlogController@store')   ;
// });

Route::group(['middleware' => ['auth:api'], 'prefix' => 'blog'], function () {
    Route::get('/', 'BlogController@index');
    Route::post('/', 'BlogController@store');
    Route::get('/{id}', 'BlogController@show');
    Route::put('/{id}', 'BlogController@update');
    Route::delete('/{id}', 'BlogController@destroy');
    Route::post('/like/{id}', 'BlogController@PostLike');
    Route::put('/statusupdate/{id}', 'BlogController@statusupdate')->middleware(['role:admin']);
});

Route::group(['middleware' => ['auth:api'], 'prefix' => 'comment'], function () {
    Route::get('/', 'CommentController@index');
    Route::post('/', 'CommentController@store');
    Route::get('/{id}', 'CommentController@show');
    Route::put('/{id}', 'CommentController@update');
    Route::delete('/{id}', 'CommentController@destroy');
});

Route::resource('reply', 'ReplyController')->middleware('auth:api');
Route::resource('category', 'CategoryController')->middleware(['auth:api', 'role:admin']);