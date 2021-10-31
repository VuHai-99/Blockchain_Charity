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
})->name('charity.logout');

Route::get('admin/login', 'AdminController@login')->name('admin.login');
Route::post('admin/login', 'AdminController@verify')->name('admin.login.verify');
Route::get('admin/logout', 'AdminController@logout')->name('admin.logout');
Route::prefix('admin')
    ->name('admin.')
    ->middleware('admin')
    ->group(function () {
        Route::get('/', 'AdminController@index')->name('dashboard.index');
        Route::get('list/host', 'AdminController@listHost')->name('host.list');
        Route::get('list/project', 'AdminController@listProject')->name('project.list');
        Route::get('list/open-project-request', 'AdminController@listOpenProjectRequest')->name('open-project-request.list');
        Route::get('list/validate-host-request', 'AdminController@listValidateHostRequest')->name('validate-host-request.list');
        Route::get('profile', 'AdminController@profile')->name('profile.edit');
        Route::get('add/account', 'AdminController@createAccount')->name('create.account');
        Route::get('list/withdraw-money-request', 'AdminController@listWithdrawMoneyRequest')->name('withdraw-money-request.list');
        
    });
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
                Route::get('/', 'DonatorController@listProject')->name('list.project');
                Route::get('/specific-project/{blockchainAddress}', 'DonatorController@specificProject')->name('list.specific.project');
            });
        Route::prefix('host')
            ->name('host.')
            ->group(function () {
                Route::get('/', 'HostController@listProject')->name('list.project');
                Route::get('/my-project', 'HostController@listMyProject')->name('list.my.project');
                Route::get('/specific-project/{blockchainAddress}', 'HostController@specificProject')->name('list.specific.project');
                Route::get('create-project', 'HostController@createProject')->name('create.project');
                Route::post('store-project', 'HostController@storeProject')->name('store.project');
                Route::get('validate-host', 'HostController@validateHost')->name('validate.host');
                
            });
    });

Route::get('/', 'FrontEndController@home')->name('home');
Route::get('/events', 'FrontendController@events')->name('events');
Route::get('/event/{id}', 'FrontendController@detail')->name('event.detail');

Auth::routes(['verify' => true]);
