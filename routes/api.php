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

Route::get('/user', 'App\Http\Controllers\UserController@index');
Route::get('/user/{id}', 'App\Http\Controllers\UserController@show');
Route::post('/user', 'App\Http\Controllers\UserController@store');
Route::post('/user/update/{id}', 'App\Http\Controllers\UserController@update');
Route::delete('/user/delete/{id}', 'App\Http\Controllers\UserController@destroy');
