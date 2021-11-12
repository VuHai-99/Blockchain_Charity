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