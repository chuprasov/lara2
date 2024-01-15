<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
use Support\Traits\Models\HasSlug;
use Database\Factories\BrandFactory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Models\HasThumbnail;
use Domain\Catalog\Collections\BrandCollection;
use Domain\Catalog\QueryBuilders\BrandQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function newCollection($models = [])
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

    protected static function booted()
    {
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
