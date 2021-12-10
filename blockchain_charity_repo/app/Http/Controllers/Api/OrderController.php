<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\OrderReceipt\OrderReceiptRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(OrderReceiptRepository $orderReceipt)
    {
        $this->orderReceipt = $orderReceipt;
    }

    public function updateQuantityOrder(Request $request, $orderId)
    {
        $quantity = $request->quantity;
        $price = $request->price;
        $this->orderReceipt->updateOrder($orderId, [
            'quantity' => $quantity,
            'total_receipt' => $quantity * $price
        ]);
        return response()->json([
            'status' => 200
        ]);
    }
}