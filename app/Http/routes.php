<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['middleware' => 'auth', 'uses' => 'TeamController@dashboard']);
Route::get('dashboard', ['middleware' => 'auth', 'uses' => 'TeamController@dashboard']);
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');


Route::get('tagteam', 'AdminController@dashboard');

// Version 1.0 API
Route::group(['prefix' => 'api/v1/'], function() {

    // Team endpoints
    Route::post('teams', 'Api\v1\TeamController@create');
    Route::post('teams/{id}', 'Api\v1\TeamController@update')->where('id', '[0-9]+');
    Route::get('teams/{id}', 'Api\v1\TeamController@show')->where('id', '[0-9]+');

    // User endpoints
    Route::post('users', 'Api\v1\UserController@create');
    Route::post('users/{id}', 'Api\v1\UserController@update')->where('id', '[0-9]+');
    Route::get('users/{id}', 'Api\v1\UserController@show')->where('id', '[0-9]+');

    // Message endpoints
    Route::post('messages/read/{id}', 'Api\v1\MessageController@markAsRead')->where('id', '[0-9]+');
    Route::post('messages', 'Api\v1\MessageController@create');
});