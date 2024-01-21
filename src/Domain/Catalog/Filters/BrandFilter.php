<?php

declare(strict_types=1);

namespace Domain\Catalog\Filters;

use Domain\Catalog\Models\Brand;
use Illuminate\Database\Eloquent\Builder;
use Support\Filters\AbstractFilter;

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
            ->orderBy('title')
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
