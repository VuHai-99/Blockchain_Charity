<?php

namespace App\Repositories\Product;

use App\Model\Product;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class ProductRepository extends BaseRepository
{
    public function __construct(Product $product)
    {
        parent::__construct($product);
    }

    public function getProdcutByRetailer($retailerAddress, $keyWord)
    {
        return $this->model->select('products.*', 'product_categories.category_name')
            ->join('product_categories', 'product_categories.id', '=', 'products.category_id')
            ->where('products.retailer_address', $retailerAddress)
            ->when($keyWord, function ($request) use ($keyWord) {
                return $request->where('product_name', 'like', '%' . $keyWord . '%');
            })
            ->paginate(10);
    }

    public function getProduct($id)
    {
        return $this->model->select('products.*', 'product_categories.category_name')
            ->join('product_categories', 'product_categories.id', '=', 'products.category_id')
            ->where('products.id', $id)
            ->first();
    }

    public function getAll($categoryName = null, $keyWord = null)
    {
        return $this->model
            ->select(
                'products.product_name',
                'products.id as product_id',
                'products.image',
                'products.price',
                'products.quantity',
                'product_categories.category_name',
                'retailers.name as retailer_name',
                'products.retailer_address'
            )
            ->join('product_categories', 'product_categories.id', '=', 'products.category_id')
            ->join('retailers', 'retailers.retailer_address', '=', 'products.retailer_address')
            ->when($categoryName, function ($query) use ($categoryName) {
                return $query->where('product_categories.slug', $categoryName);
            })
            ->when($keyWord, function ($query) use ($keyWord) {
                return $query->where('products.product_name', 'like', '%' . $keyWord . '%');
            })
            ->get();
    }

    public function updateQuantityProduct($orders)
    {
        $query = "update products set ";
        foreach ($orders as $order) {
            $query .= " quantity = CASE WHEN products.id = $order->product_id THEN quantity - $order->quantity END ,";
        }
        $query = rtrim($query, ', ');
        return DB::statement($query);
    }
}