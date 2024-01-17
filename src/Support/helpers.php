<?php
use Domain\Catalog\Filters\FilterManager;

if (!function_exists('filters')) {
    function filters(): array
    {
        return app(FilterManager::class)->items();
    }
}

/* if (!function_exists('flash')) {
    function filters(): Flash
    {
        return app(Flash::class);
    }
} */
