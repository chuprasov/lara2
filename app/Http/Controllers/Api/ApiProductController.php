<?php

namespace App\Http\Controllers\Api;

use Domain\Product\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;

class ApiProductController extends Controller
{
    public function getList()
    {
        return new ProductCollection(Product::paginate(3));
    }

    public function getOne(Product $product)
    {
        return new ProductResource($product);
    }

}
