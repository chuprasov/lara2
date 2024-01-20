<?php

namespace App\Http\Controllers;

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Builder;

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

        $products = Product::search(request('search'))
            ->query(function (Builder $builder) use ($category) {
                $builder->select(['id', 'title', 'slug', 'price', 'thumbnail', 'brand_id', 'json_properties'])
                    ->with('brand')
                    ->when($category->exists, function (Builder $builder) use ($category) {
                        $builder->whereRelation(
                            'categories',
                            'categories.id',
                            '=',
                            $category->id
                        );
                    })
                    ->filtered()
                    ->sorted();
            })
            ->paginate(6);

        return view('catalog.index', compact(
            'categories',
            'products',
            'brands',
            'category',
        ));
    }
}
