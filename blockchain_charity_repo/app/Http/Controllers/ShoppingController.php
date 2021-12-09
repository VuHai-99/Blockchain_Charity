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
        $keyWord = $request->key_word;
        $products = $this->productRepository->getAll();
        $categories = $this->categoryRepository->getAll();
        return view('retailer.shopping.index', compact('products', 'categories'));
    }

    public function getProductByCategory($categoryName)
    {
        $products = $this->productRepository->getAll($categoryName);
        $categories = $this->categoryRepository->getAll();
        return view('retailer.shopping.index', compact('products', 'categories'));
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
}