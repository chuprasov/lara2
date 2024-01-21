<?php

declare(strict_types=1);

namespace Support\Filters;

class FilterManager
{
    public function __construct(
        protected array $items = []
    ) {
    }

    public function registerItems(array $items): void
    {
        $this->items = $items;
    }

    public function items(): array
    {
        return $this->items;
    }
}
