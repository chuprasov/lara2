<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class CatalogController extends Controller
{
    public function __invoke(?Category $category)
    {
        // dd(session()->get('view-products') === 'list' ? 'pointer-events-none text-pink' : '');

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
                $builder->select(['id', 'title', 'slug', 'price', 'thumbnail', 'brand_id'])
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
