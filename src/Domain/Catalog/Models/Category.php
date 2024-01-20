<?php

namespace Domain\Catalog\Models;

use Database\Factories\CategoryFactory;
use Domain\Catalog\Collections\CategoryCollection;
use Domain\Catalog\QueryBuilders\CategoryQueryBuilder;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Models\HasSlug;

class Category extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'slug',
        'title',
        'on_home_page',
        'sorting',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    /* protected static function boot()
    {
        parent::boot();

        static::creating(function (Category $category) {
            $category->slug = $category->slug ?? str($category->title)
                ->append(time())
                ->slug();
        });
    } */

    public function newCollection($models = []): CategoryCollection
    {
        return new CategoryCollection($models);
    }

    public function newEloquentBuilder($query): CategoryQueryBuilder
    {
        return new CategoryQueryBuilder($query);
    }

    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }

    protected static function booted()
    {
        static::creating(function () {
            Cache::forget('category_home_page');
        });

        static::updating(function ($user) {
            Cache::forget('category_home_page');
        });

        static::deleting(function ($user) {
            Cache::forget('category_home_page');
        });

    }
}
