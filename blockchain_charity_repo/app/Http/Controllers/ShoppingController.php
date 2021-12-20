<?php

namespace App\Http\Controllers;

use App\Repositories\OrderReceipt\OrderReceiptRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\ProductCategory\ProductCategoryRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShoppingController extends Controller
{
    public function __construct(
        ProductRepository $productRepository,
        ProductCategoryRepository $categoryRepository,
        OrderReceiptRepository $orderReceipt,
        UserRepository $userRepository
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->orderReceipt = $orderReceipt;
        $this->userRepository = $userRepository;
    }

    public function shoppingCart(Request $request, $donationActivityAddress)
    {
        $user = Auth::user();
        $keyWord = $request->product_name;
        $products = $this->productRepository->getAll('', $keyWord);
        $categories = $this->categoryRepository->getAll();
        $orders = $this->orderReceipt->getOrderByRetailer($donationActivityAddress);
        return view('retailer.shopping.index', compact('products', 'categories', 'orders', 'donationActivityAddress'));
    }

    public function getProductByCategory($donationActivityAddress, $categoryName)
    {
        $user = Auth::user();
        $products = $this->productRepository->getAll($categoryName);
        $categories = $this->categoryRepository->getAll();
        $orders = $this->orderReceipt->getOrderByRetailer($donationActivityAddress);
        return view('retailer.shopping.index', compact('products', 'categories', 'orders', 'donationActivityAddress'));
    }

    public function order(Request $request)
    {
        $dataOrder = $request->all();
        $dataOrder['host_address'] = Auth::user()->user_address;
        $dataOrder['order_id'] = rand(1, 100000);
        $dataOrder['total_receipt'] = $request->quantity * $request->price;
        $product = $this->productRepository->getProduct($request->product_id);
        $quantityRemain = $product->quantity - $request->quantity;
        if ($quantityRemain < 0) {
            return back()->with('messages', "Số lượng hàng ko đủ");
        }
        $this->orderReceipt->create($dataOrder);
        return back()->with('messages', "Đã thêm hàng vào giỏ");
    }

    public function showCart($donationActivityAddress)
    {
        $user = Auth::user();
        $orders = $this->orderReceipt->getOrderByRetailer($donationActivityAddress);
        $categories = $this->categoryRepository->getAll();
        return view('retailer.shopping.cart', compact('orders', 'categories', 'donationActivityAddress'));
    }

    public function deleteOrder($orderId)
    {
        $this->orderReceipt->delete($orderId);
        return back()->with('messages', 'Xóa sản phẩm thành công');
    }

    public function deleteCart($donationActivityAddress)
    {
        $hostAddress = Auth::user()->user_address;
        $this->orderReceipt->deleteAllCart($donationActivityAddress);
        return redirect()->route('shopping')->with('messages', 'Xóa giỏ hàng thành công');
    }

    public function confirmOrder($donationActivityAddress)
    {
        $hostAddress = Auth::user()->user_address;
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
            dd(1);
            $this->userRepository->updateUser($hostAddress, ['amount_of_money' => $amountRemain]);
            $this->productRepository->updateQuantityProduct($orders);
        });
        return redirect()->route('shopping', $donationActivityAddress)->with('messages', 'Mua hàng thành công');
    }

    public function historyPurchase($orderId)
    {
        $orders = $this->orderReceipt->getHistoryPuchase($orderId);
        return view('history_purchase', compact('orders'));
    }
}
