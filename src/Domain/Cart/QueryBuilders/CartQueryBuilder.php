<?php

declare(strict_types=1);

namespace Domain\Cart\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

class CartQueryBuilder extends Builder
{
    public function homePage(): CartQueryBuilder
    {
        return $this->where('on_home_page', true)
            ->orderBy('sorting')
            ->limit(6);
    }

    public function filtered(): CartQueryBuilder
    {
        return app(Pipeline::class)
            ->send($this)
            ->through(filters())
            ->thenReturn();
    }

    public function sorted(): CartQueryBuilder
    {
        return sorter()->run($this);
    }
}
