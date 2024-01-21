<?php

namespace App\View\ViewModels;

use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Spatie\ViewModels\ViewModel;

class CatalogViewModel extends ViewModel
{
    public function __construct(
        public Category $category
    ) {
    }

    public function categories(): Collection|array
    {
        return Category::query()
            ->select(['id', 'title', 'slug'])
            ->has('products')
            ->get();
    }

    public function products(): LengthAwarePaginator
    {
        $category = $this->category;

        return Product::search(request('search'))
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
    }
}
