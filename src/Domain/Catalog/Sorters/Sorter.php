<?php

declare(strict_types=1);

namespace Domain\Catalog\Sorters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Stringable;

class Sorter
{
    public const SORT_KEY = 'sort';

    public function __construct(
        protected array $columns = []
    ) {
    }

    public function run(Builder $builder): Builder
    {
        $sortData = $this->sortData();

        return $builder->when($sortData->contains($this->columns()), function (Builder $b) use ($sortData) {
            $b->orderBy(
                (string) $sortData->remove('-'),
                $sortData->contains('-') ? 'DESC' : 'ASC'
            );
        });
    }

    public function key(): string
    {
        return self::SORT_KEY;
    }

    public function columns(): array
    {
        return $this->columns;
    }

    public function sortData(): Stringable
    {
        return request()->str($this->key());
    }

    public function isActive(string $column, string $direction = 'ASC'): bool
    {
        $column = trim($column, '-');

        if (strtoupper($direction) === 'DESC') {
            $column = '-'.$column;
        }

        return request($this->key()) === $column;
    }
}
