<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('login/tow-factor', 'Auth\TowFactorController@sendOtp')->name('login.towfactor');
Route::post('register/custom', 'Auth\RegisterController@storeAccount')->name('register.custom');
Route::get('verify/otp', 'Auth\TowFactorController@redirectFormConfirmOtp')->middleware('auth')->name('verify.otp.index');
Route::post('verify/otp', 'Auth\TowFactorController@verifyOtp')->name('verify.otp')->middleware('auth');
Route::get('resend-otp', 'Auth\TowFactorController@reSendMailOtp')->middleware('auth')->name('resend.otp');

Route::get('home', 'FrontEndController@home')->name('home');

Auth::routes(['verify' => true]);
