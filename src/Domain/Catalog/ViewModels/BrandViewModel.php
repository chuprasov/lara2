<?php

declare(strict_types=1);

namespace Domain\Catalog\ViewModels;

use Support\Traits\Makeable;
use Domain\Catalog\Models\Brand;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

class BrandViewModel
{
    use Makeable;

    public function homePage(): Collection|array
    {
        return Cache::rememberForever('brand_home_page', function () {
            return Brand::query()
                ->homePage()
                ->get();
        });
    }
}
