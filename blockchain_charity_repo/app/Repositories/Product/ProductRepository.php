<?php

namespace App\Repositories\Product;

use App\Model\Product;
use App\Repositories\BaseRepository;

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
            ->where('retailer_address', $retailerAddress)
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
}