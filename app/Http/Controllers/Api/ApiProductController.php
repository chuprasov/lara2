<?php

namespace App\Http\Controllers\Api;

use Domain\Product\Models\Product;
use App\Http\Controllers\Controller;

class ApiProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function show(Product $product)
    {
        return $product; //Product::find($id);
    }

}
