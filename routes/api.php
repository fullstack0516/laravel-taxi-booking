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

//Route::post('/register', 'AuthController@register');
//Route::post('/login', 'AuthController@login');
//
//Route::group(['middleware' => ['auth:api']], function() {
//    Route::get('/user', function (Request $request) {
//        return $request->user();
//    });
//    Route::get('/logout', 'AuthController@logout');
//});
//
//Route::group(['middleware' => ['verified', 'auth:api']], function() {
//    Route::get('/user', function (Request $request) {
//        return $request->user();
//    });
//});
//
//Route::get('email/verify/{id}', 'VerificationController@verify')->name('verificationapi.verify');
//Route::get('email/resend', 'VerificationController@resend')->name('verificationapi.resend');
//
//Route::group(['middleware' => ['verified', 'auth:api', 'role:admin']], function() {
//    Route::apiResource('users', 'UserController')->names('users-api');
//});
