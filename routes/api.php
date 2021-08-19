<?php

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

Route::post('register', 'RegisterController@store')->name('register');

Route::group(['middleware' => 'auth:api'], function () {

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('me', 'UserController@show')->name('me');
        Route::put('me', 'UserController@update')->name('me.update');
        Route::post('me/avatar', 'UserAvatarController@store')->name('me.avatar.store');
    });
});
