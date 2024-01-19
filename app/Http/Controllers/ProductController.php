<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function __invoke(Product $product): Factory|View|Application
    {
        $product->load(['optionValues.option']);

        $options = $product->optionValues->mapToGroups(function ($item) {
            return [$item->option->title => $item];
        });

        $watchedProducts = Product::query()
            ->whereIn('id', session('watched') ?? [])
            ->get();

        session()->put('watched.'.$product->id, $product->id);

        return view('product.show', compact('product', 'options', 'watchedProducts'));
    }
}
