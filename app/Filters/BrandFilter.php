<?php

declare(strict_types=1);

namespace App\Filters;

use Domain\Catalog\Models\Brand;
use Support\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class BrandFilter extends AbstractFilter
{
    public function title(): string
    {
        return 'Брэнд';
    }

    public function key(): string
    {
        return 'brand';
    }

    public function apply(Builder $builder): Builder
    {
        return $builder->when($this->requestValue(), function (Builder $builder) {
            $builder->whereIn('brand_id', $this->requestValue());
        });
    }

    public function values(): array
    {
        return Brand::query()
            ->select(['id', 'title'])
            ->has('products')
            ->get()
            ->pluck('title', 'id')
            ->toArray();
    }

    public function view(): string
    {
        return 'catalog.filters.brands';
    }
}
