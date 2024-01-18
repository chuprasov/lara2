<?php

use Domain\Catalog\Filters\FilterManager;
use Domain\Catalog\Models\Category;
use Domain\Catalog\Sorters\Sorter;

if (! function_exists('filters')) {
    function filters(): array
    {
        return app(FilterManager::class)->items();
    }
}

if (! function_exists('filters_url')) {
    function filters_url(?Category $category, array $params): string
    {
        return route('catalog', [
            ...request()->only(['filters', 'sort']),
            ...$params,
            'category' => $category,
        ]);
    }
}

if (! function_exists('sorter')) {
    function sorter(): Sorter
    {
        return app(Sorter::class);
    }
}
