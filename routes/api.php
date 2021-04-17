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

    Route::get('/', 'App\Http\Controllers\v3\ApiStatusController@status');

    // fallback

    Route::fallback('App\Http\Controllers\v3\@fallback');
});
