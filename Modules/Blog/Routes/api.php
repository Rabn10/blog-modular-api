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
});

// Route::prefix('blog')->group(function () {
//     Route::get('/', 'BlogController@index');
//     Route::post('/store', 'BlogController@store')   ;
// });

Route::middleware('api')->prefix('blog')->group(function () {
    Route::get('/', 'BlogController@index');
    Route::post('/', 'BlogController@store');
    Route::get('/{id}', 'BlogController@show');
    Route::put('/{id}', 'BlogController@update');
    Route::delete('/{id}', 'BlogController@destroy');
});