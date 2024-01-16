<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;

class CatalogController extends Controller
{
    public function __invoke(?Category $category)
    {
        $categories = Category::query()
            ->select(['id', 'title', 'slug'])
            ->has('products')
            ->get();

        $brands = Brand::query()
            ->select(['id', 'title'])
            ->has('products')
            ->get();

        $products = Product::query()
            ->select(['id', 'title', 'slug', 'price', 'thumbnail'])
            ->filtered()
            ->sorted()
            ->paginate(6);

        return view('catalog.index', compact(
            'categories',
            'products',
            'brands',
            'category',
        ));
    }
}
