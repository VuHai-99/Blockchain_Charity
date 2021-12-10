<?php

namespace App\Http\Controllers;

use App\Repositories\OrderReceipt\OrderReceiptRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\ProductCategory\ProductCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShoppingController extends Controller
{
    public function __construct(ProductRepository $productRepository, ProductCategoryRepository $categoryRepository, OrderReceiptRepository $orderReceipt)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->orderReceipt = $orderReceipt;
    }

    public function shoppingCart(Request $request)
    {
        $user = Auth::user();
        $keyWord = $request->product_name;
        $products = $this->productRepository->getAll('', $keyWord);
        $categories = $this->categoryRepository->getAll();
        $orders = $this->orderReceipt->getOrderByRetailer($user->user_address);
        return view('retailer.shopping.index', compact('products', 'categories', 'orders'));
    }

    public function getProductByCategory($categoryName)
    {
        $user = Auth::user();
        $products = $this->productRepository->getAll($categoryName);
        $categories = $this->categoryRepository->getAll();
        $orders = $this->orderReceipt->getOrderByRetailer($user->user_address);
        return view('retailer.shopping.index', compact('products', 'categories', 'orders'));
    }

    public function order(Request $request)
    {
        $dataOrder = $request->all();
        $dataOrder['host_address'] = Auth::user()->user_address;
        $dataOrder['order_id'] = rand(1, 100000);
        $dataOrder['total_receipt'] = $request->quantity * $request->price;
        $this->orderReceipt->create($dataOrder);
        return back()->with('message', "Đã thêm hàng vào giỏ");
    }

    public function showCart()
    {
        $user = Auth::user();
        $orders = $this->orderReceipt->getOrderByRetailer($user->user_address);
        $categories = $this->categoryRepository->getAll();
        return view('retailer.shopping.cart', compact('orders', 'categories'));
    }

    public function deleteOrder($orderId)
    {
        $this->orderReceipt->delete($orderId);
        return back()->with('message', 'Xóa sản phẩm thành công');
    }

    public function deleteCart()
    {
        $hostAddress = Auth::user()->user_address;
        $this->orderReceipt->deleteAllCart($hostAddress);
        return redirect()->route('shopping')->with('message', 'Xóa giỏ hàng thành công');
    }

    public function confirmOrder()
    {
        $hostAddress = Auth::user()->user_address;
        $this->orderReceipt->confirmOrder($hostAddress, now()->format('Y-m-d H:i:s'));
        return redirect()->route('shopping')->with('message', 'Mua hàng thành công');
    }
}