<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
use Support\Traits\Models\HasSlug;
use Database\Factories\BrandFactory;
use Domain\Catalog\Collections\BrandCollection;
use Domain\Catalog\QueryBuilders\BrandQueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;
    use HasSlug;

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
}
