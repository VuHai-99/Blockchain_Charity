<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FrontEndController extends Controller
{
    public function home()
    {
        return view('frontEnd.home');
    }

    public function campaign()
    {
        return view('frontEnd.campaign');
    }

    public function detail($id)
    {
        return view('frontEnd.campaign_detail');
    }

    public function testMetamaskKYC(){
        return view('test_metamask_kyc');
    }

    public function validateSignMetamask(Request $request){
        // dd($request->all());
        $response = Http::post('http://localhost:3000/validate/metaMaskSignature', [
            'publicAddress' => $request->publicAddress,
            'signData' => $request->signData,
            'CSRF' => $request->CSRF
        ]);
        if($response->status() == 200){
            return response($response,200);
        } else {
            return response($response,500);
        }
        // return response($request->signData,200);

    }
}