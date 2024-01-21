<?php

namespace App\Http\Controllers;

use Domain\Product\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function __invoke(Product $product): Factory|View|Application
    {
        $product->load(['optionValues.option']);

        $watchedProducts = Product::query()
            ->whereIn('id', session('watched') ?? [])
            ->get();

        session()->put('watched.'.$product->id, $product->id);

        $options = $product->optionValues->keyValues();

        return view('product.show', compact('product', 'options', 'watchedProducts'));
    }
}
