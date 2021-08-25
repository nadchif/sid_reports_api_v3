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
    Route::post('user', 'App\Http\Controllers\UserController@post');
    Route::middleware('auth:api')->get('user', 'App\Http\Controllers\UserController@index');
    Route::middleware('auth:api')->get('user/{id}', 'App\Http\Controllers\UserController@get');
    Route::middleware('auth:api')->put('user/{id}', 'App\Http\Controllers\UserController@put');    
    Route::get('user/verify/{id}', 'App\Http\Controllers\VerificationController@verify')->name('verification.verify');
    Route::post('user/resend', 'App\Http\Controllers\VerificationController@resend')->name('verification.resend');
    Route::post('user/forgot-password', 'App\Http\Controllers\ForgotPasswordController@requestLink')->middleware('guest')->name('password.email');
    Route::get('user/reset-password', 'App\Http\Controllers\ForgotPasswordController@resetPasswordToken')->middleware('guest')->name('password.reset');
    Route::post('user/reset-password', 'App\Http\Controllers\ForgotPasswordController@setNewPassword')->middleware('guest')->name('password.update');

    // Unions
    Route::get('/union', 'App\Http\Controllers\UnionController@index');
    Route::get('/union/{id}', 'App\Http\Controllers\UnionController@get');
    Route::middleware('auth:api')->post('union', 'App\Http\Controllers\UnionController@post');
    Route::middleware('auth:api')->put('union/{id}', 'App\Http\Controllers\UnionController@put');


    // API fallback
    Route::fallback('App\Http\Controllers\ApiStatusController@fallback');
});
