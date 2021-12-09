<?php

namespace App\Repositories\ProductCategory;

use App\Model\ProductCategory;
use App\Repositories\BaseRepository;

class ProductCategoryRepository extends BaseRepository
{
    public function __construct(ProductCategory $productCategory)
    {
        parent::__construct($productCategory);
    }
}