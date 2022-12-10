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
Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('/login', '\App\Http\Controllers\Auth\ApiAuthController@login')->name('login.api');
    Route::post('/register','\App\Http\Controllers\Auth\ApiAuthController@register')->name('register.api');
});

Route::middleware('auth:api')->group(function () {
    // our routes to be protected will go in here
    Route::get('get-user', '\App\Http\Controllers\Auth\ApiAuthController@userInfo');
    Route::get('get_csv', [\App\Http\Controllers\Csv\CsvController::class, 'get_csv'])->name('get_csv');
});