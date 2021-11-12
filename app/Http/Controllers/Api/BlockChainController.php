<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\BlockchainRequest;
class BlockChainController extends Controller
{
    public function storeBlockchainRequest(Request $request)
    {
        dd($request->all());
        $new_blockchain_request = new BlockchainRequest();
        // dd($new_blockchain_request);
        $new_blockchain_request->request_id	 = $request->request_id	;
        $new_blockchain_request->request_type = $request->request_type;
        $new_blockchain_request->amount = $request->amount;
        $new_blockchain_request->requested_user_address = $request->requested_user_address;
        $new_blockchain_request->save();

        if($new_blockchain_request->request_type == 0){
            // valid host request
            $host = User::findOrFail($new_blockchain_request->requested_user_address);
            $host->validate_state = 1;
            $host->save();
        }
        return response('Store Successfully');   
    }
    
}
