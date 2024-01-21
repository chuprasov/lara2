<?php

declare(strict_types=1);

namespace Domain\Catalog\Filters;

use Illuminate\Database\Eloquent\Builder;
use Support\Filters\AbstractFilter;

class PriceFilter extends AbstractFilter
{
    public function title(): string
    {
        return 'Цена';
    }

    public function key(): string
    {
        return 'price';
    }

    public function apply(Builder $builder): Builder
    {
        return $builder->when($this->requestValue(), function (Builder $b) {
            $b->whereBetween('price', [
                $this->requestValue('from', 0) * 100,
                $this->requestValue('to', 100000) * 100,
            ]);
        });
    }

    public function values(): array
    {
        return [
            'from' => 0,
            'to' => 100000,
        ];
    }

    public function view(): string
    {
        return 'catalog.filters.price';
    }
}
