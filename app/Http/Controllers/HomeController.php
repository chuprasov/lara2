<?php

namespace App\Http\Controllers;

use Domain\Catalog\Models\Category;
use Domain\Catalog\ViewModels\BrandViewModel;
use Domain\Catalog\ViewModels\CategoryViewModel;
use Domain\Product\Models\Product;

class HomeController extends Controller
{
    public function __invoke(?Category $category)
    {
        $categories = CategoryViewModel::make()->homePage();

        $products = Product::query()
            ->with('brand')
            ->homePage()
            ->get();

        $brands = BrandViewModel::make()->homePage();

        return view('index', compact(
            'categories',
            'products',
            'brands',
            'category',
        ));
    }
}
