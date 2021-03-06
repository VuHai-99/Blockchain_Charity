<?php

use App\User;
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
        Route::get('list/campaign', 'AdminController@listCampaign')->name('campaign.list');
        Route::get('list/open-campaign-request', 'AdminController@listOpenCampaignRequest')->name('open-campaign-request.list');
        Route::get('list/validate-host-request', 'AdminController@listValidateHostRequest')->name('validate-host-request.list');
        Route::get('add/account', 'AdminController@createAccount')->name('create.account');
        Route::get('list/withdraw-money-request', 'AdminController@listWithdrawMoneyRequest')->name('withdraw-money-request.list');
        Route::get('list/create-donationActivity-request', 'AdminController@listcreateDonationActivityRequest')->name('create-donationActivity-request.list');
        Route::get('list/create-donationActivityCashout-request', 'AdminController@listcreateDonationActivityCashoutRequest')->name('create-donationActivityCashout-request.list');
        Route::get('list/create-donationActivityOrder-request', 'AdminController@listcreateDonationActivityOrderRequest')->name('create-donationActivityOrder-request.list');
    });
//user
Route::post('login/tow-factor', 'Auth\TowFactorController@sendOtp')->name('login.towfactor');
Route::post('register/custom', 'Auth\RegisterController@storeAccount')->name('register.custom');
Route::get('verify/otp', 'Auth\TowFactorController@redirectFormConfirmOtp')->middleware(['auth'])->name('verify.otp.index');
Route::post('verify/otp', 'Auth\TowFactorController@verifyOtp')->name('verify.otp')->middleware('auth');
Route::get('resend-otp', 'Auth\TowFactorController@reSendMailOtp')->middleware('auth')->name('resend.otp');
Route::post('api/verify-otp', 'Api\VerifyOtpController@verify')->name('api.verify.otp');
Route::post('api/confirm-password', 'Api\VerifyOtpController@confirmPassword')->name('api.verify.password');
Route::get('api/send-otp', 'Api\VerifyOtpController@sendOtp')->name('api.send.otp');
Route::get('redirect-login', 'Auth\TowFactorController@redirectWhenErrorOtp')->name('redirect.error');

Route::prefix('charity')
    ->middleware(['verify_otp'])
    ->group(function () {
        Route::prefix('donator')
            ->middleware('donator-wallet-hard')
            ->name('donator.')
            ->group(function () {
                Route::get('', 'DonatorController@home')->name('home');
                Route::get('campaign', 'DonatorController@listCampaign')->name('campaign');
                Route::get('campaign-detail/{id}', 'DonatorController@campaignDetail')->name('campaign.detail');
            });
        Route::get('donation-activity/{id}/detail', 'DonatorController@donationActivityDetail')->name('donator.donation_activity.detail');
        Route::prefix('donatorws')
            ->middleware('donator-wallet-soft')
            ->name('donatorws.')
            ->group(function () {
                Route::get('', 'DonatorController@home')->name('home');
                Route::get('campaign', 'DonatorController@WS_listCampaign')->name('campaign');
                Route::get('campaign-detail/{id}', 'DonatorController@WS_campaignDetail')->name('campaign.detail');
                Route::post('donate/campaign', 'DonatorController@WS_donateToCampaign')->name('donate.campaign');
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
                Route::get('list-request', 'HostController@listRequest')->name('list.request');
                // Route::post('store/request-create-campaign/img', 'CampaignController@addCampaignRequestImg')->name('campaign.request.img.add');
                Route::get('edit/campaign_detail/{blockchainAddress}', 'HostController@editCampaignDetail')->name('campaign_detail.edit');
                Route::post('update/campaign_detail/{blockchainAddress}', 'HostController@updateCampaign')->name('campaign.update');
                Route::get('create/request/donation_activity/{blockchainAddress}', 'HostController@createDonationActivityRequest')->name('donationActivity.create.request');
                Route::get('create/request/donation_activity_cashout/{donationActivityAddress}', 'HostController@createDonationActivityCashoutRequest')->name('donationActivity.cashout.create.request');
                Route::get('donation_activity/{blockchainAddress}/{donationActivityAddress}', 'HostController@donationActivityDetail')->name('donationActivity.detail');
                Route::get('edit/donation_activity_detail/{donationActivityAddress}', 'HostController@editDonationActivityDetail')->name('donation_activity_detail.edit');
                Route::post('update/donation_activity_detail/{donationActivityAddress}', 'HostController@updateDonationActivity')->name('donationActivity.update');
                Route::get('{donationActivityAddress}/shopping/shopping_cart', 'HostController@shoppingCart')->name('shopping.cart');
                Route::get('{donationActivityAddress}/shopping/shopping_cart/{category}', 'HostController@shoppingCartByCategory')->name('shopping.cart.byCategory');
                Route::get('{donation_address}/shopping/order/detail', 'HostController@showCartOrderDetail')->name('shopping.order.show');
                Route::get('shopping/order/{id}/delete', 'HostController@shoppingCartDeleteOrder')->name('shopping.order.delete');
                Route::get('shopping/order/{donationActivityAddress}/delete/cart', 'HostController@shoppingCartDeleteCart')->name('shopping.order.delete.cart');
                Route::get('shopping/order/{donationActivityAddress}/confirm', 'HostController@shoppingCartConfirmOrder')->name('shopping.order.confirm');
                Route::get('comfirm/blockchain_order/{orderId}', 'HostController@confirmOrderBlockchain')->name('shopping.order.blockchain');
                // Route::get('shopping/order/{donationActivityAddress}/confirm', 'HostController@shoppingCartConfirmOrder')->name('shopping.order.confirm');
                
                // Route::get('shopping/order/{donationActivityAddress}/blockchain/confirm', 'HostController@shoppingCartBlockchainConfirm')->name('shopping.order.blockchain.confirm');

            });
        Route::get('delete/request/{id}', 'HostController@deleteRequest')->name('host.delete.request')->middleware('auth');
        Route::prefix('hostws')
            ->middleware('host-wallet-soft')
            ->name('hostws.')
            ->group(function () {
                Route::get('', 'HostController@home')->name('home');
                Route::get('campaign', 'HostController@WS_listCampaign')->name('campaign');
                Route::get('create-campaign', 'HostController@WS_createCampaign')->name('campaign.create');
                Route::get('campaign_detail/{blockchainAddress}', 'HostController@WS_campaignDetail')->name('campaign.detail');
                Route::get('validate-host', 'HostController@WS_validateHost')->name('validate.host');
                Route::post('donate/campaign', 'HostController@WS_donateToCampaign')->name('donate.campaign');
                Route::post('/withdraw/campaign', 'HostController@WS_withdrawCampaign')->name('withdraw.campaign');
                Route::post('/validate/request', 'HostController@WS_hostValidateRequest')->name('validate.tobehost.request');
                Route::post('/openCampaign/request', 'HostController@WS_hostOpenCampaignRequest')->name('validate.openCampaign.request');
                Route::get('list-request', 'HostController@WS_listRequest')->name('list.request');
                Route::get('edit/campaign_detail/{blockchainAddress}', 'HostController@WS_editCampaignDetail')->name('campaign_detail.edit');
                Route::post('update/campaign_detail/{blockchainAddress}', 'HostController@WS_updateCampaign')->name('campaign.update');
                Route::post('cancel/request/openCampaign/{requestId}', 'HostController@WS_cancelRequestOpenCampaign')->name('cancel.request.openCampaign');
                Route::get('create/request/donation_activity/{blockchainAddress}', 'HostController@WS_createDonationActivityRequest')->name('donationActivity.create.request');
                Route::post('/openDonationActivity/request/{campaignAddress}', 'HostController@WS_hostOpenDonationActivityRequest')->name('validate.openDonationActivity.request');
                Route::get('donation_activity/{blockchainAddress}/{donationActivityAddress}', 'HostController@WS_donationActivityDetail')->name('donationActivity.detail');
                Route::get('create/request/donation_activity_cashout/{donationActivityAddress}', 'HostController@WS_createDonationActivityCashoutRequest')->name('donationActivity.cashout.create.request');
                Route::post('/openDonationActivityCashout/request/{donationActivityAddress}', 'HostController@WS_hostCreateDonationActivityCashoutRequest')->name('validate.createDonationActivityCashout.request');
                Route::post('cancel/request/openDonationActivity/{requestId}', 'HostController@WS_cancelRequestOpenDonationActivity')->name('cancel.request.openDonationActivity');
                Route::post('cancel/request/createDonationActivityCashout/{requestId}', 'HostController@WS_cancelRequestCreateDonationActivityCashout')->name('cancel.request.createDonationActivityCashout');
                Route::post('cancel/request/createDonationActivityOrder/{requestId}', 'HostController@WS_cancelRequestCreateDonationActivityOrder')->name('cancel.request.createDonationActivityOrder');
                Route::get('edit/donation_activity_detail/{donationActivityAddress}', 'HostController@WS_editDonationActivityDetail')->name('donation_activity_detail.edit');
                Route::post('update/donation_activity_detail/{donationActivityAddress}', 'HostController@WS_updateDonationActivity')->name('donationActivity.update');
                Route::get('{donationActivityAddress}/shopping/shopping_cart', 'HostController@WS_shoppingCart')->name('shopping.cart');
                Route::get('{donationActivityAddress}/shopping/shopping_cart/{category}', 'HostController@WS_shoppingCartByCategory')->name('shopping.cart.byCategory');
                Route::get('{donation_address}/shopping/order/detail', 'HostController@WS_showCartOrderDetail')->name('shopping.order.show');
                Route::get('shopping/order/{id}/delete', 'HostController@WS_shoppingCartDeleteOrder')->name('shopping.order.delete');
                Route::get('shopping/order/{donationActivityAddress}/delete/cart', 'HostController@WS_shoppingCartDeleteCart')->name('shopping.order.delete.cart');
                Route::get('shopping/order/{donationActivityAddress}/confirm', 'HostController@WS_shoppingCartConfirmOrder')->name('shopping.order.confirm');
                Route::get('comfirm/blockchain_order/{donationActivityAddress}', 'HostController@WS_listOrderBlockchain')->name('shopping.order.blockchain');
                Route::post('send/blockchain_order', 'HostController@WS_createDonationActivityOrderRequest')->name('shopping.send.order.request.blockchain');
                Route::post('confirm/received/blockchain_order', 'HostController@WS_confirmReceivedDonationActivityOrder')->name('confirm.received.donationActivity.order');
            });
        Route::get('campaign/list-donator', 'DonatorController@listDonator')->name('campaign.donator');
        Route::get('profile', 'UserController@profile')->name('user.profile');
        Route::post('profile', 'UserController@updateProfile')->name('user.update');
        Route::post('change/password', 'UserController@changePassword')->name('user.change.password');
    });

Route::prefix('authority')
    ->name('authority.')
    ->group(function () {
        Route::get('login', 'AuthorityController@login')->name('login');
        Route::post('login', 'AuthorityController@validateAuthority')->name('validate');
        Route::get('logout', 'AuthorityController@logout')->name('logout');
        Route::get('', 'AuthorityController@index')->name('index');
        Route::get('list/cashout-request', 'AuthorityController@listDonationActivityCashoutRequest')->name('cashout_request.list');
        Route::get('list/order-request', 'AuthorityController@listDonationActivityOrderRequest')->name('order_request.list');
    });


Route::prefix('retailer')
    ->name('retailer.')
    ->group(function () {
        Route::get('login', 'RetailerController@login')->name('login');
        Route::post('login', 'RetailerController@validateRetailer')->name('validate');
        Route::get('logout', 'RetailerController@logout')->name('logout');
        Route::get('index', 'RetailerController@index')->name('dashboard');
        Route::prefix('product')->group(function () {
            Route::get('', 'RetailerController@listProduct')->name('product.list');
            Route::get('create', 'RetailerController@createProduct')->name('product.create');
            Route::post('create', 'RetailerController@storeProduct')->name('product.store');
            Route::get('edit/{id}', 'RetailerController@editProduct')->name('product.edit');
            Route::post('edit/{id}', 'RetailerController@updateProduct')->name('product.update');
            Route::get('delete/{id}', 'RetailerController@deleteProduct')->name('product.delete');
        });
        Route::get('order', 'RetailerController@listOrder')->name('order.list');
        Route::get('profile', 'RetailController@profile')->name('profile');
    });

Route::get('/', 'FrontEndController@home')->name('home');
Route::get('/campaign', 'FrontendController@campaign')->name('campaign');
Route::get('/campaign/{id}', 'FrontendController@detail')->name('campaign.detail');
Route::get('/campaign/{id}/top-donator', 'HostController@getDonatorTop')->name('campaign.top.donator');
Route::get('/campaign/{id}/monthly-donator', 'HostController@getDonatorMonthly')->name('campaign.monthly.donator');
Route::get('donation_activity/{donation_activity_address}/detail', 'FrontendController@donationActivityDetail')->name('donation_activity.detail');
Auth::routes(['verify' => true]);

Route::get('my-wallet', 'DonatorController@myWallet')->name('wallet')->middleware('auth');
Route::post('api/change-key', 'Api\ResetKeyController@changeKey')->name('api.change.key');

Route::prefix('shopping')
    ->middleware('host')
    ->group(function () {
        Route::get('{donation_address}', 'ShoppingController@shoppingCart')->name('shopping');
        Route::get('/{donationActivityAddress}/{category}', 'ShoppingController@getProductByCategory')->name('search.category');
        Route::post('/order', 'ShoppingController@order')->name('order');
        Route::get('/{donation_address}/order/detail', 'ShoppingController@showCart')->name('order.show');
        Route::get('order/{id}/delete', 'ShoppingController@deleteOrder')->name('order.delete');
        Route::get('order/{donationActivityAddress}/delete/cart', 'ShoppingController@deleteCart')->name('order.delete.cart');
        Route::get('oder/{donationActivityAddress}/confirm', 'ShoppingController@confirmOrder')->name('order.confirm');
    });
Route::get('order/{id}/update', 'Api\OrderController@updateQuantityOrder')->name('order.update');
Route::get('history/purchase/{orderId}', 'ShoppingController@historyPurchase')->name('order.history');