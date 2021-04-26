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

Route::group(['prefix' => '/', 'middleware' => ['jsonify']], function () {
    // API status
    Route::get('/', 'App\Http\Controllers\ApiStatusController@status');

    // Auth
    Route::post('/auth', 'App\Http\Controllers\AuthController@login');   

    // User
    Route::middleware('auth:api')->get('user', 'App\Http\Controllers\UserController@index');
    Route::middleware('auth:api')->get('user/{id}', 'App\Http\Controllers\UserController@get');
    Route::middleware('auth:api')->put('user/{id}', 'App\Http\Controllers\UserController@put');

    // Unions
    Route::get('/union', 'App\Http\Controllers\UnionController@index');
    Route::get('/union/{id}', 'App\Http\Controllers\UnionController@get');

    // API fallback
    Route::fallback('App\Http\Controllers\ApiStatusController@fallback');
});
