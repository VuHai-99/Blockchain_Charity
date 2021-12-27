<?php

namespace App\Http\Controllers;

use App\Model\Authority;
use App\Model\BlockchainRequest;
use App\Model\Campaign;
use App\Model\CampaignImg;
use App\Model\CashoutDonationActivity;
use App\Model\DonationActivity;
use App\Model\OrderDonationActivity;
use App\Model\OrderReceipt;
use App\Model\Product;
use App\Model\ProductCategory;
use App\Model\Retailer;
use App\Model\Transaction;
use App\Repositories\BlockChain\BlockChainRequestRepository;
use App\Repositories\Campaign\CampaignRepository;
use App\Repositories\OrderReceipt\OrderReceiptRepository;
use App\Services\UploadImageService;
use App\Repositories\Product\ProductRepository;
use App\Repositories\ProductCategory\ProductCategoryRepository;
use App\Repositories\User\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class HostController extends Controller
{
    public function __construct(
        BlockChainRequestRepository $blockChainRequest,
        CampaignRepository $campaignRepository,
        UploadImageService $uploadImageService,
        OrderReceiptRepository $orderReceipt,
        ProductRepository $productRepository,
        ProductCategoryRepository $categoryRepository,
        UserRepository $userRepository
    ) {
        $this->blockChainRequest = $blockChainRequest;
        $this->campaignRepository = $campaignRepository;
        $this->uploadImageService = $uploadImageService;
        $this->orderReceipt = $orderReceipt;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
    }

    public function home()
    {
        return view('frontend.home');
    }

    public function listCampaign()
    {
        // $campaigns = $this->campaignRepository->getListCampaign();
        $campaigns = Campaign::all();
        return view('host.list_campaign', compact('campaigns'));
    }

    public function createCampaign()
    {
        return view('host.create_campaign');
    }

    public function editCampaignDetail($blockchainAddress)
    {
        $campaign = Campaign::findOrFail($blockchainAddress);
        $campaign_main_pic = CampaignImg::where('campaign_address', $blockchainAddress)->where('photo_type', 0)->get();
        if (count($campaign_main_pic) != 0) {
            $campaign_main_pic = $campaign_main_pic[0];
        } else {
            $campaign_main_pic = null;
        }
        $campaign_side_pic = CampaignImg::where('campaign_address', $blockchainAddress)->where('photo_type', 1)->get();
        return view('host.edit_campaign_detail', compact('campaign', 'campaign_main_pic', 'campaign_side_pic'));
    }

    public function listRequest()
    {
        $listRequestOpenCampaign = BlockchainRequest::where('requested_user_address', Auth::user()->user_address)->where('request_type', 1)->get();
        $requestValidateHost = BlockchainRequest::where('requested_user_address', Auth::user()->user_address)->where('request_type', 0)->get();
        $listRequestOpenDonationActivity = BlockchainRequest::where('requested_user_address', Auth::user()->user_address)->where('request_type', 3)->get();
        $listRequestCreateDonationActivityCashout = BlockchainRequest::where('requested_user_address', Auth::user()->user_address)->where('request_type', 4)->get();
        return view('host.list_request', compact('listRequestOpenCampaign', 'requestValidateHost', 'listRequestOpenDonationActivity', 'listRequestCreateDonationActivityCashout'));
    }


    public function deleteRequest($requestId)
    {
        $notification = array(
            'message' => 'Hủy request thành công',
            'alert-type' => 'success'
        );
        $this->blockChainRequest->deleteRequest($requestId);
        return back()->with($notification);
    }

    public function validateHost()
    {
        return view('host.validate_host');
    }

    public function campaignDetail($blockchainAddress)
    {
        $campaign = Campaign::findOrFail($blockchainAddress);
        $userTopDonate = $this->campaignRepository->getListUserTopDonate($blockchainAddress, 10);
        $limit =  10;
        $userUserDonateMonthLy = $this->campaignRepository->getListUserDonate($blockchainAddress, $limit);
        $campaign_main_pic = CampaignImg::where('campaign_address', $blockchainAddress)->where('photo_type', 0)->get();

        if (count($campaign_main_pic) != 0) {
            $campaign_main_pic = $campaign_main_pic[0];
        } else {
            $campaign_main_pic = null;
        }
        $campaign_side_pic = CampaignImg::where('campaign_address', $blockchainAddress)->where('photo_type', 1)->get();

        $donationActivities = DonationActivity::where('campaign_address', $blockchainAddress)->get();
        if (count($donationActivities) == 0) {
            $donationActivities = null;
        }
        return view('host.campaign_detail', compact('campaign', 'userUserDonateMonthLy', 'userTopDonate', 'campaign_main_pic', 'campaign_side_pic', 'donationActivities', 'blockchainAddress'));
    }

    public function updateCampaign($blockchainAddress, Request $request)
    {
        $notification = array(
            'message' => 'Update campaign thành công',
            'alert-type' => 'success'
        );
        $new_campaign = Campaign::findOrFail($blockchainAddress);
        $new_campaign->name = $request->campaign_name;
        $new_campaign->campaign_address = $blockchainAddress;
        $new_campaign->description = $request->description;
        $new_campaign->target_contribution_amount = $request->target_contribution_amount;
        $new_campaign->date_start = $request->date_start;
        $new_campaign->date_end = $request->date_end;
        $new_campaign->save();

        if ($request->hasFile('image')) {
            $file = $request->image;
            $data['image'] = $this->uploadService->upload($file);
        }

        if ($request->campaign_main_pic) {
            $campaignImg = new CampaignImg();
            $campaignImg->file_path = $this->uploadImageService->upload($request->campaign_main_pic);
            $campaignImg->campaign_address = $blockchainAddress;
            $campaignImg->photo_type = 0;
            $campaignImg->save();
        }

        if ($request->campaign_multi_img) {
            foreach ($request->campaign_multi_img as $multi_img) {
                $campaignImg = new CampaignImg();
                $campaignImg->file_path = $this->uploadImageService->upload($multi_img);
                $campaignImg->campaign_address = $blockchainAddress;
                $campaignImg->photo_type = 1;
                $campaignImg->save();
            }
        }

        return back()->with($notification);
    }

    public function createDonationActivityRequest($blockchainAddress)
    {
        $campaign = Campaign::findOrFail($blockchainAddress);
        $authorities = Authority::all();
        // dd($authorities);
        return view('host.create_donation_activity_request', compact('campaign', 'authorities'));
    }
    public function donationActivityDetail($blockchainAddress, $donationActivityAddress)
    {
        $campaign = Campaign::findOrFail($blockchainAddress);
        $donationActivity = DonationActivity::findOrFail($donationActivityAddress);
        $donationActivityCashouts = CashoutDonationActivity::where('donation_activity_address', $donationActivityAddress)->get();
        if (count($donationActivityCashouts) == 0) {
            $donationActivityCashouts = null;
        }
        $donation_activity_main_pic = CampaignImg::where('donation_activity_address', $donationActivityAddress)->where('photo_type', 2)->get();
        // dd($donation_activity_main_pic);
        if (count($donation_activity_main_pic) != 0) {
            $donation_activity_main_pic = $donation_activity_main_pic[0];
        } else {
            $donation_activity_main_pic = null;
        }
        $donation_activity_side_pic = CampaignImg::where('donation_activity_address', $donationActivityAddress)->where('photo_type', 3)->get();
        $orders = $this->orderReceipt->getOrderDonationActivition($donationActivityAddress);
        // dd($orders);
        return view('host.donation_activity_detail', compact('donationActivityAddress', 'campaign', 'donationActivity', 'donationActivityCashouts', 'donation_activity_side_pic', 'donation_activity_main_pic', 'orders'));
    }

    public function createDonationActivityCashoutRequest($donationActivityAddress)
    {
        $donationActivity = DonationActivity::findOrFail($donationActivityAddress);
        return view('host.create_donation_activity_cashout_request', compact('donationActivity'));
    }


    public function editDonationActivityDetail($donationActivityAddress)
    {
        $donationActivity = DonationActivity::findOrFail($donationActivityAddress);
        $campaign = $donationActivity->campaign;
        $donation_activity_main_pic = CampaignImg::where('donation_activity_address', $donationActivityAddress)->where('photo_type', 2)->get();
        // dd($donation_activity_main_pic);
        if (count($donation_activity_main_pic) != 0) {
            $donation_activity_main_pic = $donation_activity_main_pic[0];
        } else {
            $donation_activity_main_pic = null;
        }
        $donation_activity_side_pic = CampaignImg::where('donation_activity_address', $donationActivityAddress)->where('photo_type', 3)->get();

        return view('host.edit_donation_activity_detail', compact('campaign', 'donation_activity_main_pic', 'donation_activity_side_pic', 'donationActivity'));
    }

    public function updateDonationActivity($donationActivityAddress, Request $request)
    {
        $notification = array(
            'message' => 'Successfully update donation activity',
            'alert-type' => 'success'
        );

        $donation_activity = DonationActivity::findOrFail($donationActivityAddress);
        $donation_activity->donation_activity_name = $request->donation_activity_name;
        $donation_activity->donation_activity_description = $request->description;
        $donation_activity->date_start = $request->date_start;
        $donation_activity->date_end = $request->date_end;
        $donation_activity->save();

        if ($request->donation_activity_main_pic) {
            $campaignImg = new CampaignImg();
            $campaignImg->file_path = $this->uploadImageService->upload($request->donation_activity_main_pic);
            $campaignImg->donation_activity_address = $donationActivityAddress;
            $campaignImg->photo_type = 2;
            $campaignImg->save();
        }

        if ($request->donation_activity_multi_img) {
            foreach ($request->donation_activity_multi_img as $multi_img) {
                $campaignImg = new CampaignImg();
                $campaignImg->file_path = $this->uploadImageService->upload($multi_img);
                $campaignImg->donation_activity_address = $donationActivityAddress;
                $campaignImg->photo_type = 3;
                $campaignImg->save();
            }
        }

        return back()->with($notification);
    }

    public function shoppingCart($donationActivityAddress,Request $request){
        $user = Auth::user();
        $keyWord = $request->product_name;
        $products = $this->productRepository->getAll('', $keyWord);
        $categories = $this->categoryRepository->getAll();
        $orders = $this->orderReceipt->getOrderByRetailer($donationActivityAddress);
        return view('host.shopping_index', compact('products', 'categories', 'orders', 'donationActivityAddress'));
    }

    public function shoppingCartByCategory($donationActivityAddress, $categoryName)
    {
        $user = Auth::user();
        $products = $this->productRepository->getAll($categoryName);
        $categories = $this->categoryRepository->getAll();
        $orders = $this->orderReceipt->getOrderByRetailer($donationActivityAddress);
        return view('host.shopping_index', compact('products', 'categories', 'orders', 'donationActivityAddress'));
    }

    public function showCartOrderDetail($donationActivityAddress)
    {
        $user = Auth::user();
        $orders = $this->orderReceipt->getOrderByRetailer($donationActivityAddress);
        $categories = $this->categoryRepository->getAll();
        // $order_donation_activities = OrderDonationActivity::where()
        return view('host.shopping_order_detail', compact('orders', 'categories', 'donationActivityAddress'));
    }

    public function shoppingCartDeleteOrder($orderId)
    {
        $this->orderReceipt->delete($orderId);
        return back()->with('messages', 'Xóa sản phẩm thành công');
    }
    
    public function shoppingCartDeleteCart($donationActivityAddress)
    {
        $hostAddress = Auth::user()->user_address;
        $this->orderReceipt->deleteAllCart($donationActivityAddress);
        return redirect()->back()->with('messages', 'Xóa giỏ hàng thành công');
    }
    public function shoppingCartConfirmOrder($donationActivityAddress)
    {   
        $hostAddress = Auth::user()->user_address;
        $donationActivity = DonationActivity::findOrFail($donationActivityAddress);
        $campaign = Campaign::findOrFail($donationActivity->campaign_address);
        $amount = $campaign->current_balance;
        $totalReceipt = $this->orderReceipt->getTotalOrder($hostAddress);
        
        $orderID = strtotime(now());
        $dataUpdateOrder = [
            'order_id' => $orderID,
            'date_of_payment' => now()->format('Y-m-d H:i:s'),
        ];
        if ($amount < $totalReceipt) {
            return back()->with('messages_fail', 'Số tiền của bạn không đủ');
        }
        $amountRemain = $amount - $totalReceipt;
        $orders = $this->orderReceipt->getProductOrder($donationActivityAddress);
        // dd($orders);
        if(count($orders)!=0){
            $product_id= $orders[0]->product_id;
            $retailerAddress = (Product::findOrFail($product_id))->retailer_address;
            // dd($retailerAddress);
            $url = 'http://127.0.0.1:8000/history/purchase/'.strval($orderID);
            DB::transaction(function () use ($hostAddress, $donationActivityAddress, $dataUpdateOrder, $orders, $amountRemain) {
                $this->orderReceipt->confirmOrder($donationActivityAddress, $dataUpdateOrder);
                $this->productRepository->updateQuantityProduct($orders);
            });

            $orderDonationActivity = new OrderDonationActivity();
            $orderDonationActivity->receipt_url = $url;
            $orderDonationActivity->retailer_address = $retailerAddress;
            $orderDonationActivity->order_state = 3;
            $orderDonationActivity->order_code = $orderID;
            $orderDonationActivity->authority_confirmation = false;
            $orderDonationActivity->total_amount = $totalReceipt;
            $orderDonationActivity->donation_activity_address = $donationActivityAddress;
            $orderDonationActivity->save();

            $campaign->current_balance = $amount - $totalReceipt;
            $campaign->save();
            
            return redirect()->back()->with('message','Mua hang thanh cong');
        }
    }

    public function confirmOrderBlockchain($donationActivityAddress)
    {
        // $order_donation_activities = OrderDonationActivity::where('donation_activity_address',$donationActivityAddress)->where('order_state',3)->get();
        $order_donation_activities = OrderDonationActivity::where('donation_activity_address',$donationActivityAddress)->get();
        // dd($order_donation_activities);
        return view('host.confirm_order_blockchain_history_purchase', compact('order_donation_activities'));
    }

    //WS

    public function WS_listRequest()
    {
        $listRequestOpenCampaign = BlockchainRequest::where('requested_user_address', Auth::user()->user_address)->where('request_type', 1)->get();
        $requestValidateHost = BlockchainRequest::where('requested_user_address', Auth::user()->user_address)->where('request_type', 0)->get();
        $listRequestOpenDonationActivity = BlockchainRequest::where('requested_user_address', Auth::user()->user_address)->where('request_type', 3)->get();
        $listRequestCreateDonationActivityCashout = BlockchainRequest::where('requested_user_address', Auth::user()->user_address)->where('request_type', 4)->get();
        return view('host.list_request_ws', compact('listRequestOpenCampaign', 'requestValidateHost', 'listRequestOpenDonationActivity', 'listRequestCreateDonationActivityCashout'));
    }
    public function WS_listCampaign()
    {
        // $campaigns = $this->campaignRepository->getListCampaign();
        $campaigns = Campaign::all();
        return view('host.list_campaign_ws', compact('campaigns'));
    }

    public function WS_campaignDetail($blockchainAddress)
    {
        $campaign = Campaign::findOrFail($blockchainAddress);
        $userTopDonate = $this->campaignRepository->getListUserTopDonate($blockchainAddress, 10);
        $limit =  10;
        $userUserDonateMonthLy = $this->campaignRepository->getListUserDonate($blockchainAddress, $limit);
        $campaign_main_pic = CampaignImg::where('campaign_address', $blockchainAddress)->where('photo_type', 0)->get();
        if (count($campaign_main_pic) != 0) {
            $campaign_main_pic = $campaign_main_pic[0];
        } else {
            $campaign_main_pic = null;
        }
        $donationActivities = DonationActivity::where('campaign_address', $blockchainAddress)->get();
        if (count($donationActivities) == 0) {
            $donationActivities = null;
        }
        $campaign_side_pic = CampaignImg::where('campaign_address', $blockchainAddress)->where('photo_type', 1)->get();
        return view('host.campaign_detail_ws', compact('campaign', 'userUserDonateMonthLy', 'userTopDonate', 'campaign_main_pic', 'campaign_side_pic', 'donationActivities', 'blockchainAddress'));
    }

    public function WS_validateHost()
    {
        $host = Auth::user();
        return view('host.validate_host_ws', compact('host'));
    }

    public function WS_createCampaign()
    {
        return view('host.create_campaign_ws');
    }

    public function WS_donateToCampaign(Request $request)
    {

        $campaign_address = $request->campaign_address;
        $donateAPI = 'http://localhost:3000/donator/donate/campaign/';
        $donateAPI .= $campaign_address;

        $response = Http::post($donateAPI, [
            // 'donator_address' => Auth::user()->user_address,
            'donator_address' => Auth::user()->user_address,
            'amoutOfEthereum' => $request->donation_amount,
        ]);
        if ($response->status() == 200) {
            $notification = array(
                'message' => 'Donate Successfully',
                'alert-type' => 'success'
            );

            $transaction_info = $response->json();
            $requestToValidateHost = new Transaction();
            $requestToValidateHost->transaction_hash = $transaction_info['transactionHash'];
            $requestToValidateHost->sender_address = $transaction_info['from'];
            $requestToValidateHost->receiver_address = $transaction_info['to'];
            $requestToValidateHost->transaction_type = 0;
            $requestToValidateHost->amount = $request->donation_amount;
            $requestToValidateHost->save();
            // return redirect()->back()->with($notification);

            $currentCampaign = Campaign::findOrFail($campaign_address);
            $currentCampaign->current_balance = strval(gmp_add($currentCampaign->current_balance, $request->donation_amount));
            $currentCampaign->save();

            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Donate Unsuccessfully',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function WS_withdrawCampaign(Request $request)
    {
        $withdrawAPI = 'http://localhost:3000/host/withdraw/campaign/request';

        $response = Http::post($withdrawAPI, [
            // 'donator_address' => Auth::user()->user_address,
            'validated_host_address' => Auth::user()->user_address,
            'amount_of_money' => $request->withdrawal_amount,
            "campaign_adress_target" =>  $request->campaign_address
        ]);
        if ($response->status() == 200) {
            $notification = array(
                'message' => 'Request to Withdraw Money Successfully',
                'alert-type' => 'success'
            );
            $transaction_info = $response->json();
            $requestToWithdrawMoney = new BlockchainRequest();
            $requestToWithdrawMoney->request_id = $transaction_info['request_id'];
            $requestToWithdrawMoney->requested_user_address = $transaction_info['requested_user_address'];
            $requestToWithdrawMoney->amount = $transaction_info['amount'];
            $requestToWithdrawMoney->campaign_address = $request->campaign_address;
            $requestToWithdrawMoney->request_type = 2;
            $requestToWithdrawMoney->save();
            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Request to Withdraw Money Unsuccessfully',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function WS_hostValidateRequest(Request $request)
    {
        $withdrawAPI = 'http://localhost:3000/host/validate/request';

        $response = Http::post($withdrawAPI, [
            // 'donator_address' => Auth::user()->user_address,
            'requested_to_be_host_address' => Auth::user()->user_address,
        ]);
        if ($response->status() == 200) {
            $notification = array(
                'message' => 'Request to Validate Account Successfully',
                'alert-type' => 'success'
            );
            $requestToWithdrawMoney = new BlockchainRequest();
            $requestToWithdrawMoney->request_id = $request->user_address;
            $requestToWithdrawMoney->requested_user_address = $request->user_address;
            $requestToWithdrawMoney->request_type = 0;
            $requestToWithdrawMoney->save();

            $user = User::findOrFail($request->user_address);
            $user->validate_state = 1;
            $user->save();
            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Request to Validate Account Unsuccessfully',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function WS_hostOpenCampaignRequest(Request $request)
    {
        $withdrawAPI = 'http://localhost:3000/host/create/campaign/request';

        $response = Http::post($withdrawAPI, [
            // 'donator_address' => Auth::user()->user_address,
            'validated_host_address' => Auth::user()->user_address,
            "minimum_contribution" => $request->minimum_contribution
        ]);
        if ($response->status() == 200) {
            $notification = array(
                'message' => 'Request to open campaign Successfully',
                'alert-type' => 'success'
            );

            $transaction_info = $response->json();
            $requestToWithdrawMoney = new BlockchainRequest();
            $requestToWithdrawMoney->request_id = $transaction_info['request_id'];
            $requestToWithdrawMoney->requested_user_address = $request->user_address;
            $requestToWithdrawMoney->request_type = 1;
            $requestToWithdrawMoney->amount = $request->minimum_contribution;
            $requestToWithdrawMoney->campaign_name = $request->campaign_name;
            $requestToWithdrawMoney->date_start = $request->date_start;
            $requestToWithdrawMoney->date_end = $request->date_end;
            $requestToWithdrawMoney->target_contribution_amount = $request->target_contribution_amount;
            $requestToWithdrawMoney->description = $request->description;
            $requestToWithdrawMoney->save();

            return redirect()->route('hostws.list.request')->with($notification);
        } else {
            $notification = array(
                'message' => 'Request to open campaign Unsuccessfully',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function WS_editCampaignDetail($blockchainAddress)
    {
        $campaign = Campaign::findOrFail($blockchainAddress);
        $campaign_main_pic = CampaignImg::where('campaign_address', $blockchainAddress)->where('photo_type', 0)->get();
        if (count($campaign_main_pic) != 0) {
            $campaign_main_pic = $campaign_main_pic[0];
        } else {
            $campaign_main_pic = null;
        }
        $campaign_side_pic = CampaignImg::where('campaign_address', $blockchainAddress)->where('photo_type', 1)->get();
        return view('host.edit_campaign_detail_ws', compact('campaign', 'campaign_main_pic', 'campaign_side_pic'));
    }

    public function WS_updateCampaign($blockchainAddress, Request $request)
    {
        $notification = array(
            'message' => 'Update campaign thành công',
            'alert-type' => 'success'
        );
        $new_campaign = Campaign::findOrFail($blockchainAddress);
        $new_campaign->name = $request->campaign_name;
        $new_campaign->campaign_address = $blockchainAddress;
        $new_campaign->description = $request->description;
        $new_campaign->target_contribution_amount = $request->target_contribution_amount;
        $new_campaign->date_start = $request->date_start;
        $new_campaign->date_end = $request->date_end;
        $new_campaign->save();

        // $campaign_main_pic = CampaignImg::where('campaign_address',$blockchainAddress)->where('photo_type',0)->get();
        // unlink($campaign_main_pic[0]->file_path);
        if ($request->campaign_main_pic) {
            $campaignImg = new CampaignImg();
            $campaignImg->file_path = $this->uploadImageService->upload($request->campaign_main_pic);
            $campaignImg->campaign_address = $blockchainAddress;
            $campaignImg->photo_type = 0;
            $campaignImg->save();
        }

        if ($request->campaign_multi_img) {
            foreach ($request->campaign_multi_img as $multi_img) {
                $campaignImg = new CampaignImg();
                $campaignImg->file_path = $this->uploadImageService->upload($multi_img);
                $campaignImg->campaign_address = $blockchainAddress;
                $campaignImg->photo_type = 1;
                $campaignImg->save();
            }
        }

        return back()->with($notification);
    }

    public function WS_cancelRequestOpenCampaign($request_id, Request $request)
    {
        $withdrawAPI = 'http://127.0.0.1:3000/host/cancel/openCampaign/request';

        $response = Http::post($withdrawAPI, [
            // 'donator_address' => Auth::user()->user_address,
            'host_address' => Auth::user()->user_address,
            "request_id" => $request_id
        ]);
        if ($response->status() == 200) {
            $notification = array(
                'message' => 'Request to cancel open campaign Successfully',
                'alert-type' => 'success'
            );

            $requestcancel = BlockchainRequest::where('request_id', $request_id);
            $requestcancel->delete();

            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Request to open campaign Unsuccessfully',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function WS_createDonationActivityRequest($blockchainAddress)
    {
        $campaign = Campaign::findOrFail($blockchainAddress);
        $authorities = Authority::all();
        $campaign_address_ = $blockchainAddress;
        // dd($authorities);
        return view('host.create_donation_activity_request_ws', compact('campaign', 'authorities', 'campaign_address_'));
    }

    public function WS_hostOpenDonationActivityRequest($campaignAddress, Request $request)
    {
        $withdrawAPI = 'http://localhost:3000/host/create/donationActivity/request';

        $response = Http::post($withdrawAPI, [
            // 'donator_address' => Auth::user()->user_address,
            'validated_host_address' => Auth::user()->user_address,
            'campaign_address' => $campaignAddress,
            'authority_address' => $request->authority_address,
            'campaign_factory' => $request->campaign_factory
        ]);
        if ($response->status() == 200) {
            $notification = array(
                'message' => 'Request to open Donation Activity Successfully',
                'alert-type' => 'success'
            );

            $transaction_info = $response->json();
            $requestToCreateDonationActivity = new BlockchainRequest();
            $requestToCreateDonationActivity->request_id = $transaction_info['request_id'];
            $requestToCreateDonationActivity->requested_user_address = Auth::user()->user_address;
            $requestToCreateDonationActivity->request_type = 3;
            $requestToCreateDonationActivity->campaign_name = $request->donation_activity_name;
            $requestToCreateDonationActivity->campaign_address = $campaignAddress;
            $requestToCreateDonationActivity->authority_address = $request->authority_address;
            $requestToCreateDonationActivity->date_start = $request->date_start;
            $requestToCreateDonationActivity->date_end = $request->date_end;
            $requestToCreateDonationActivity->description = $request->donation_activity_description;
            $requestToCreateDonationActivity->save();

            return redirect()->route('hostws.list.request')->with($notification);
        } else {
            $notification = array(
                'message' => 'Request to create Donation Activity Unsuccessfully',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function WS_donationActivityDetail($blockchainAddress, $donationActivityAddress)
    {
        $campaign = Campaign::findOrFail($blockchainAddress);
        $donationActivity = DonationActivity::findOrFail($donationActivityAddress);
        $donationActivityCashouts = CashoutDonationActivity::where('donation_activity_address', $donationActivityAddress)->get();
        if (count($donationActivityCashouts) == 0) {
            $donationActivityCashouts = null;
        }
        $donation_activity_main_pic = CampaignImg::where('donation_activity_address', $donationActivityAddress)->where('photo_type', 2)->get();
        if (count($donation_activity_main_pic) != 0) {
            $donation_activity_main_pic = $donation_activity_main_pic[0];
        } else {
            $donation_activity_main_pic = null;
        }
        $donation_activity_side_pic = CampaignImg::where('donation_activity_address', $donationActivityAddress)->where('photo_type', 3)->get();
        
        $orders = $this->orderReceipt->getOrderDonationActivition($donationActivityAddress);
        // dd($orders);
        return view('host.donation_activity_detail_ws', compact('donationActivityAddress', 'campaign', 'donationActivity', 'donationActivityCashouts', 'donation_activity_main_pic', 'donation_activity_side_pic', 'orders'));
    }

    public function WS_createDonationActivityCashoutRequest($donationActivityAddress)
    {
        $donationActivity = DonationActivity::findOrFail($donationActivityAddress);
        return view('host.create_donation_activity_cashout_request_ws', compact('donationActivity'));
    }

    public function WS_hostCreateDonationActivityCashoutRequest($donationActivityAddress, Request $request)
    {
        $withdrawAPI = 'http://localhost:3000/host/create/donationActivityCashout/request';

        $a = [
            'validated_host_address' => Auth::user()->user_address,
            'campaign_address' => $request->campaign_address,
            'donation_activity_address' => $donationActivityAddress,
            'cashout_value' => $request->cashout_value
        ];
        dd($a);
        $response = Http::post($withdrawAPI, [
            'validated_host_address' => Auth::user()->user_address,
            'campaign_address' => $request->campaign_address,
            'donation_activity_address' => $donationActivityAddress,
            'cashout_value' => $request->cashout_value
        ]);
        if ($response->status() == 200) {
            $notification = array(
                'message' => 'Request to create Donation Activity CashOut Successfully',
                'alert-type' => 'success'
            );

            $transaction_info = $response->json();
            $requestToCreateDonationActivity = new BlockchainRequest();
            $requestToCreateDonationActivity->request_id = $transaction_info['request_id'];
            $requestToCreateDonationActivity->requested_user_address = Auth::user()->user_address;
            $requestToCreateDonationActivity->request_type = 4;
            $requestToCreateDonationActivity->donation_activity_address = $donationActivityAddress;
            $requestToCreateDonationActivity->amount = $request->cashout_value;
            $requestToCreateDonationActivity->save();

            return redirect()->route('hostws.list.request')->with($notification);
        } else {
            $notification = array(
                'message' => 'Request to create Donation Activity Unsuccessfully',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function WS_cancelRequestOpenDonationActivity($request_id, Request $request)
    {
        $withdrawAPI = 'http://127.0.0.1:3000/host/cancel/openDonationActivity/request';

        $response = Http::post($withdrawAPI, [
            'validated_host_address' => Auth::user()->user_address,
            'request_id' => $request_id,
            'campaign_address' => $request->campaign_address
        ]);
        if ($response->status() == 200) {
            $notification = array(
                'message' => 'Request to cancel donation activity Successfully',
                'alert-type' => 'success'
            );

            $requestcancel = BlockchainRequest::where('request_id', $request_id);
            $requestcancel->delete();

            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Request to donation activity Unsuccessfully',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function WS_cancelRequestCreateDonationActivityCashout($request_id, Request $request)
    {
        $withdrawAPI = 'http://127.0.0.1:3000/host/cancel/createDonationActivityCashout/request';

        $response = Http::post($withdrawAPI, [
            // 'donator_address' => Auth::user()->user_address,
            'validated_host_address' => Auth::user()->user_address,
            'request_id' => $request_id,
            'campaign_address' => $request->campaign_address
        ]);
        if ($response->status() == 200) {
            $notification = array(
                'message' => 'Request to cancel donation activity Cashout Successfully',
                'alert-type' => 'success'
            );

            $requestcancel = BlockchainRequest::where('request_id', $request_id);
            $requestcancel->delete();

            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Request to donation activity Cashout Unsuccessfully',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function WS_editDonationActivityDetail($donationActivityAddress)
    {
        $donationActivity = DonationActivity::findOrFail($donationActivityAddress);
        $campaign = $donationActivity->campaign;
        $donation_activity_main_pic = CampaignImg::where('donation_activity_address', $donationActivityAddress)->where('photo_type', 2)->get();
        if (count($donation_activity_main_pic) != 0) {
            $donation_activity_main_pic = $donation_activity_main_pic[0];
        } else {
            $donation_activity_main_pic = null;
        }
        $donation_activity_side_pic = CampaignImg::where('donation_activity_address', $donationActivityAddress)->where('photo_type', 3)->get();

        return view('host.edit_donation_activity_detail_ws', compact('campaign', 'donation_activity_main_pic', 'donation_activity_side_pic', 'donationActivity'));
    }

    public function WS_updateDonationActivity($donationActivityAddress, Request $request)
    {
        $notification = array(
            'message' => 'Successfully update donation activity',
            'alert-type' => 'success'
        );

        $donation_activity = DonationActivity::findOrFail($donationActivityAddress);
        $donation_activity->donation_activity_name = $request->donation_activity_name;
        $donation_activity->donation_activity_description = $request->description;
        $donation_activity->date_start = $request->date_start;
        $donation_activity->date_end = $request->date_end;
        $donation_activity->save();

        if ($request->donation_activity_main_pic) {
            $campaignImg = new CampaignImg();
            $campaignImg->file_path = $this->uploadImageService->upload($request->donation_activity_main_pic);
            $campaignImg->donation_activity_address = $donationActivityAddress;
            $campaignImg->photo_type = 2;
            $campaignImg->save();
        }

        if ($request->donation_activity_multi_img) {
            foreach ($request->donation_activity_multi_img as $multi_img) {
                $campaignImg = new CampaignImg();
                $campaignImg->file_path = $this->uploadImageService->upload($multi_img);
                $campaignImg->donation_activity_address = $donationActivityAddress;
                $campaignImg->photo_type = 3;
                $campaignImg->save();
            }
        }

        return back()->with($notification);
    }

    public function WS_shoppingCart($donationActivityAddress,Request $request){
        $user = Auth::user();
        $keyWord = $request->product_name;
        $products = $this->productRepository->getAll('', $keyWord);
        $categories = $this->categoryRepository->getAll();
        $orders = $this->orderReceipt->getOrderByRetailer($donationActivityAddress);
        return view('host.shopping_index_ws', compact('products', 'categories', 'orders', 'donationActivityAddress'));
    }


    public function WS_shoppingCartByCategory($donationActivityAddress, $categoryName)
    {
        $user = Auth::user();
        $products = $this->productRepository->getAll($categoryName);
        $categories = $this->categoryRepository->getAll();
        $orders = $this->orderReceipt->getOrderByRetailer($donationActivityAddress);
        return view('host.shopping_index_ws', compact('products', 'categories', 'orders', 'donationActivityAddress'));
    }


    public function WS_showCartOrderDetail($donationActivityAddress)
    {
        $user = Auth::user();
        $orders = $this->orderReceipt->getOrderByRetailer($donationActivityAddress);
        $categories = $this->categoryRepository->getAll();
        // $order_donation_activities = OrderDonationActivity::where()
        return view('host.shopping_order_detail_ws', compact('orders', 'categories', 'donationActivityAddress'));
    }

    public function WS_shoppingCartDeleteOrder($orderId)
    {
        $this->orderReceipt->delete($orderId);
        return back()->with('messages', 'Xóa sản phẩm thành công');
    }

    public function WS_shoppingCartDeleteCart($donationActivityAddress)
    {
        $hostAddress = Auth::user()->user_address;
        $this->orderReceipt->deleteAllCart($donationActivityAddress);
        return redirect()->back()->with('messages', 'Xóa giỏ hàng thành công');
    }

    public function WS_shoppingCartConfirmOrder($donationActivityAddress)
    {   
        $hostAddress = Auth::user()->user_address;
        $donationActivity = DonationActivity::findOrFail($donationActivityAddress);
        $campaign = Campaign::findOrFail($donationActivity->campaign_address);
        $amount = $campaign->current_balance;
        $totalReceipt = $this->orderReceipt->getTotalOrder($hostAddress);
        
        $orderID = strtotime(now());
        $dataUpdateOrder = [
            'order_id' => $orderID,
            'date_of_payment' => now()->format('Y-m-d H:i:s'),
        ];
        if ($amount < $totalReceipt) {
            return back()->with('messages_fail', 'Số tiền của bạn không đủ');
        }
        $amountRemain = $amount - $totalReceipt;
        $orders = $this->orderReceipt->getProductOrder($donationActivityAddress);
        if(count($orders)!=0){
            $product_id= $orders[0]->product_id;
            $retailerAddress = (Product::findOrFail($product_id))->retailer_address;
            // dd($retailerAddress);
            $url = 'http://127.0.0.1:8000/history/purchase/'.strval($orderID);
            DB::transaction(function () use ($hostAddress, $donationActivityAddress, $dataUpdateOrder, $orders, $amountRemain) {
                $this->orderReceipt->confirmOrder($donationActivityAddress, $dataUpdateOrder);
                $this->productRepository->updateQuantityProduct($orders);
            });

            $orderDonationActivity = new OrderDonationActivity();
            $orderDonationActivity->receipt_url = $url;
            $orderDonationActivity->retailer_address = $retailerAddress;
            $orderDonationActivity->order_state = 3;
            $orderDonationActivity->order_code = $orderID;
            $orderDonationActivity->authority_confirmation = false;
            $orderDonationActivity->total_amount = $totalReceipt;
            $orderDonationActivity->donation_activity_address = $donationActivityAddress;
            $orderDonationActivity->save();

            $campaign->current_balance = $amount - $totalReceipt;
            $campaign->save();
            
            return redirect()->back()->with('message','Mua hang thanh cong');
        }
    }

    public function getDonatorMonthly($blockchainAddress)
    {
        $donators = $this->campaignRepository->getListUserDonate($blockchainAddress, 0);
        return view('host.donator_monthly', compact('donators'));
    }

    public function getDonatorTop($blockchainAddress)
    {
        $donators =  $userTopDonate = $this->campaignRepository->getListUserTopDonate($blockchainAddress, 10);
        return view('host.donator_top', compact('donators'));
    }

    public function WS_listOrderBlockchain($donationActivityAddress)
    {
        $order_donation_activities = OrderDonationActivity::where('donation_activity_address',$donationActivityAddress)->get();
        // dd($order_donation_activities);
        return view('host.confirm_order_blockchain_history_purchase_ws', compact('order_donation_activities'));
    }
    
    public function WS_createDonationActivityOrderRequest(Request $request)
    {
        $withdrawAPI = 'http://localhost:3000/host/create/donationActivityOrder/request';

        $response = Http::post($withdrawAPI, [
            // 'donator_address' => Auth::user()->user_address,
            'campaign_address'=>$request->campaign_address,
            'validated_host_address' => Auth::user()->user_address,
            'donation_activity_address'=>$request->donation_activity_address,
            'retailer_address'=>$request->retailer_address,
            'receipt_url'=>$request->receipt_url,
            'total_amount'=>$request->total_amount
        ]);
        if ($response->status() == 200) {
            $notification = array(
                'message' => 'Request to Create Donation Activity Order Successfully',
                'alert-type' => 'success'
            );

            $transaction_info = $response->json();
            $requestToCreateDonationActivity = new BlockchainRequest();
            $requestToCreateDonationActivity->request_id = $transaction_info['request_id'];
            $requestToCreateDonationActivity->amount = $request->total_amount;
            $requestToCreateDonationActivity->requested_user_address = Auth::user()->user_address;
            $requestToCreateDonationActivity->donation_activity_address = $request->donation_activity_address;
            $requestToCreateDonationActivity->retailer_address = $request->retailer_address;
            $requestToCreateDonationActivity->url = $request->receipt_url;
            $requestToCreateDonationActivity->request_type = 5;
            $requestToCreateDonationActivity->save();


            $orderDonationActivity = OrderDonationActivity::where('receipt_url',$request->receipt_url)->first();
            $orderDonationActivity->order_code =  $transaction_info['request_id'];
            $orderDonationActivity->order_state = 4;
            $orderDonationActivity->save();
            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Request to Create Donation Activity Order Unsuccessfully',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function WS_confirmReceivedDonationActivityOrder(Request $request)
    {
        $withdrawAPI = 'http://localhost:3000/host/confirm/received/donationActivityOrder';

        $response = Http::post($withdrawAPI, [
            // 'donator_address' => Auth::user()->user_address,
            'validated_host_address' => Auth::user()->user_address,
            'donation_activity_address'=>$request->donation_activity_address,
            'order_code'=>$request->order_code
        ]);
        if ($response->status() == 200) {
            $notification = array(
                'message' => 'Host confirm received Donation Activity Order Successfully',
                'alert-type' => 'success'
            );

            $orderDonationActivity = OrderDonationActivity::where('receipt_url',$request->receipt_url)->first();
            $orderDonationActivity->order_state = 2;
            $orderDonationActivity->save();
            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Request to Create Donation Activity Order Unsuccessfully',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
    
}