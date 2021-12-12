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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/store-blockchain-request', 'Api\BlockchainController@storeBlockchainRequest')->name('store.blockchain.request');
Route::post('/decide-blockchain-request', 'Api\BlockchainController@decideBlockchainRequest')->name('decide.blockchain.request');
Route::post('/store-transaction', 'Api\BlockchainController@storeTransaction')->name('store.transaction'); 
Route::post('/decide-cashout-request', 'Api\BlockchainController@decideCashoutRequest')->name('decide.cashout.request'); 
Route::get('/shopping/order/{donationActivityAddress}/confirm', 'Api\ShoppingController@shoppingCartConfirmOrder')->name('shopping.order.confirm');

// Route::post('/donate/campaign', 'Api\BlockchainController@donateToCampaign')->name('donate.campaign');
// Route::post('/withdraw/campaign', 'Api\BlockchainController@withdrawCampaign')->name('withdraw.campaign');
// Route::post('/host/validate/request', 'Api\BlockchainController@hostValidateRequest')->name('validate.tobehost.request');
// Route::post('/host/openCampaign/request', 'Api\BlockchainController@hostOpenCampaignRequest')->name('validate.openCampaign.request');