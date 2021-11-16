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
    $notification = array(
        'message' => 'Logout Successfully',
        'alert-type' => 'success'
    );
    Auth::user()->resetOtp();
    Auth::logout();
    return redirect()->route('home')->with($notification);
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
            ->middleware('donator-wallet-hard')
            ->name('donator.')
            ->group(function () {
                // Route::get('/specific-project/{blockchainAddress}', 'DonatorController@specificProject')->name('list.specific.project');
                Route::get('', 'DonatorController@home')->name('home');
                Route::get('campaign', 'DonatorController@listCampaign')->name('campaign');
                Route::get('campaign-detail/{id}', 'DonatorController@campaignDetail')->name('campaign.detail');
            });
        Route::prefix('donatorws')
            ->middleware('donator-wallet-soft')
            ->name('donatorws.')
            ->group(function () {
                // Route::get('/specific-project/{blockchainAddress}', 'DonatorController@WS_specificProject')->name('list.specific.project');
                Route::get('', 'DonatorController@home')->name('home');
                Route::get('campaign', 'DonatorController@WS_listCampaign')->name('campaign');
                Route::get('campaign-detail/{id}', 'DonatorController@WS_campaignDetail')->name('campaign.detail');
            });
        Route::prefix('host')
            ->middleware('host-wallet-hard')
            ->name('host.')
            ->group(function () {
                Route::get('', 'HostController@home')->name('home');
                Route::get('campaign', 'HostController@listCampaign')->name('campaign');
                Route::get('create-campaign', 'HostController@createCampaign')->name('campaign.create');
                Route::get('campaign_detail/{blockchainAddress}', 'HostController@campaignDetail')->name('campaign.detail');
                Route::get('validate-host', 'HostController@validateHost')->name('validate.host');
            });
        Route::prefix('hostws')
            ->middleware('host-wallet-soft')
            ->name('hostws.')
            ->group(function () {
                Route::get('', 'HostController@home')->name('home');
                Route::get('campaign', 'HostController@WS_listCampaign')->name('campaign');
                Route::get('create-campaign', 'HostController@WS_createCampaign')->name('campaign.create');
                Route::get('campaign_detail/{blockchainAddress}', 'HostController@WS_campaignDetail')->name('campaign.detail');
                Route::get('validate-host', 'HostController@WS_validateHost')->name('validate.host');
            });
        Route::get('campaign/list-donator', 'DonatorController@listDonator')->name('campaign.donator');
    });

Route::get('/', 'FrontEndController@home')->name('home');
Route::get('/campaign', 'FrontendController@campaign')->name('campaign');
Route::get('/campaign/{id}', 'FrontendController@detail')->name('campaign.detail');
Auth::routes(['verify' => true]);
// Route::get('/store-blockchain-request', 'BlockchainController@storeBlockchainRequest')->name('store.blockchain.request'); 