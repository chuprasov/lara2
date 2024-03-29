<?php

namespace Domain\Catalog\Models;

use Database\Factories\BrandFactory;
use Domain\Catalog\Collections\BrandCollection;
use Domain\Catalog\QueryBuilders\BrandQueryBuilder;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Models\HasSlug;
use Support\Traits\Models\HasThumbnail;

class Brand extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;

    protected $fillable = [
        'slug',
        'title',
        'thumbnail',
        'on_home_page',
        'sorting',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function thumbnailDir(): string
    {
        return 'brands';
    }

    public function newCollection($models = []): BrandCollection
    {
        return new BrandCollection($models);
    }

    public function newEloquentBuilder($query): BrandQueryBuilder
    {
        return new BrandQueryBuilder($query);
    }

    protected static function newFactory(): BrandFactory
    {
        return BrandFactory::new();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function () {
            Cache::forget('brand_home_page');
        });

        static::updating(function ($user) {
            Cache::forget('brand_home_page');
        });

        static::deleting(function ($user) {
            Cache::forget('brand_home_page');
        });

    }
}
