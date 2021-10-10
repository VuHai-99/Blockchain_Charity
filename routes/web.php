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

Route::get('logout', function () {
    Auth::user()->resetOtp();
    Auth::logout();
    return redirect(route('home'));
});

//admin
Route::get('admin/login', 'AdminController@login')->name('admin.login');
Route::get('admin', 'AdminController@index')->name('admin.index')->middleware('admin');
//user
Route::post('login/tow-factor', 'Auth\TowFactorController@sendOtp')->name('login.towfactor');
Route::post('register/custom', 'Auth\RegisterController@storeAccount')->name('register.custom');
Route::get('verify/otp', 'Auth\TowFactorController@redirectFormConfirmOtp')->middleware(['auth'])->name('verify.otp.index');
Route::post('verify/otp', 'Auth\TowFactorController@verifyOtp')->name('verify.otp')->middleware('auth');
Route::get('resend-otp', 'Auth\TowFactorController@reSendMailOtp')->middleware('auth')->name('resend.otp');
Route::post('api/verify-otp', 'Api\VerifyOtpController@verify')->name('api.verify.otp');
Route::get('redirect-login', 'Auth\TowFactorController@redirectWhenErrorOtp')->name('redirect.error');

Route::prefix('charity')
    ->middleware(['verified', 'verify_otp'])
    ->group(function () {
        Route::get('profile', 'DonatorController@profile')->name('profile');
        Route::prefix('donator')
            ->name('donator.')
            ->group(function () {
                Route::get('/', 'DonatorController@index')->name('index');
            });
        Route::prefix('host')
            ->name('host    .')
            ->group(function () {
                Route::get('/', 'DonatorController@index')->name('index');
            });
    });

Route::get('/', 'FrontEndController@home')->name('home');
Route::get('/events', 'FrontendController@events')->name('events');

Auth::routes(['verify' => true]);