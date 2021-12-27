<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ProductRequest;
use App\Repositories\Product\ProductRepository;
use App\Repositories\ProductCategory\ProductCategoryRepository;
use App\Services\UploadImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RetailerController extends Controller
{
    public function __construct(ProductRepository $productRepository, ProductCategoryRepository $categoryRepository, UploadImageService $uploadImageService)
    {
        $this->middleware('retailer')->except('login', 'validateRetailer', 'logout');
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->uploadImageService = $uploadImageService;
    }

    public function login()
    {
        return view('retailer.login');
    }

    public function validateRetailer(LoginRequest $request)
    {
        $notification = array(
            'message' => 'Login Successfully',
            'alert-type' => 'success'
        );

        $validate = $request->only('email', 'password');
        if (!Auth::guard('retailer')->attempt($validate)) {
            return back()->with('error-login', 'Email hoặc mật khẩu không đúng. Vui lòng kiểm tra lại.')->withInput();
        } else {
            if (Auth::guard('retailer')->check()) {
                return redirect()->route('retailer.dashboard')->with($notification);
            }
        }
    }

    public function logout()
    {
        Auth::guard('retailer')->logout();
        return redirect(route('retailer.login'));
    }

    public function index()
    {
        return view('retailer.dashboard');
    }

    public function listProduct(Request $request)
    {
        $keyWord = $request->key_word;
        $retailer = Auth::guard('retailer')->user()->retailer_address;
        $products = $this->productRepository->getProdcutByRetailer($retailer, $keyWord);
        return view('retailer.product.show', compact('products'));
    }

    public function createProduct()
    {
        $categories = $this->categoryRepository->getAll();
        return view('retailer.product.create', compact('categories'));
    }
    public function listOrder()
    {
        return view('retailer.order.listOrder');
    }

    public function storeProduct(ProductRequest $request)
    {
        $data = $request->only('product_name', 'category_id', 'quantity', 'price', 'display');
        $data['retailer_address'] = Auth::guard('retailer')->user()->retailer_address;
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImageService->upload($request->image);
        }
        $data['slug'] = unUniCode($request->product_name);
        $this->productRepository->create($data);
        return back()->with('message', 'Thêm sản phẩm thành công');
    }

    public function editProduct($id)
    {
        $product = $this->productRepository->getProduct($id);
        $categories = $this->categoryRepository->getAll();
        return view('retailer.product.edit', compact('categories', 'product'));
    }

    public function updateProduct($id, ProductRequest $request)
    {
        $data = $request->only('product_name', 'category_id', 'quantity', 'price', 'display');
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImageService->upload($request->image);
        }
        $data['slug'] = unUniCode($request->product_name);
        $this->productRepository->update($id, $data);
        return redirect()->route('retailer.product.list')->with('message', 'Sửa sản phẩm thành công');
    }

    public function deleteProduct($id)
    {
        $this->productRepository->delete($id);
        return back()->with('message', 'Xóa sản phẩm thành công');
    }
}