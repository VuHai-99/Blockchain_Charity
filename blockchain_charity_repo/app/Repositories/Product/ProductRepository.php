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

}
