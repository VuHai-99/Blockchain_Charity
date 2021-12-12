<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShoppingController extends Controller
{
    public function shoppingCartConfirmOrder($donationActivityAddress)
    {
        // dd(Auth::user());
        $hostAddress = Auth::user()->user_address;
        // dd($hostAddress);
        $amount = Auth::user()->amount_of_money;
        $totalReceipt = $this->orderReceipt->getTotalOrder($hostAddress);
        $dataUpdateOrder = [
            'order_id' => strtotime(now()),
            'date_of_payment' => now()->format('Y-m-d H:i:s'),
        ];
        if ($amount < $totalReceipt) {
            return back()->with('messages', 'Số tiền của bạn không đủ');
        }
        $amountRemain = $amount - $totalReceipt;
        $orders = $this->orderReceipt->getProductOrder($donationActivityAddress);
        DB::transaction(function () use ($hostAddress, $donationActivityAddress, $dataUpdateOrder, $orders, $amountRemain) {
            $this->orderReceipt->confirmOrder($donationActivityAddress, $dataUpdateOrder);
            $this->userRepository->updateUser($hostAddress, ['amount_of_money' => $amountRemain]);
            $this->productRepository->updateQuantityProduct($orders);
        });
        return response()->json([
            'status' => 200
        ]);
    }
}
