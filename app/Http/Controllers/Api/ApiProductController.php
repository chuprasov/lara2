<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use Domain\Product\Models\Product;

class ApiProductController extends Controller
{
    /**
     * @unauthenticated
     */
    public function getAll()
    {
        return new ProductCollection(Product::all());
    }

    /**
     * @unauthenticated
     */
    public function getPaginate(int $cnt)
    {
        return new ProductCollection(Product::paginate($cnt));
    }

    /**
     * @unauthenticated
     */
    public function getOne(Product $product)
    {
        return new ProductResource($product);
    }
}
