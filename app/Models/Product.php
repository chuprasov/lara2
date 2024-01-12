<?php

namespace App\Models;

use Domain\Catalog\Models\Brand;
use Support\Traits\Models\HasSlug;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Casts\PriceCast;

class Product extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'slug',
        'title',
        'brand_id',
        'price',
        'thumbnail',
        'on_home_page',
        'sorting',
    ];

    protected $casts = [
        'price' => PriceCast::class
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /* protected static function boot()
    {
        parent::boot();

        static::creating(function (Product $product) {
            $product->slug = $product->slug ?? str($product->title)
                ->append(time())
                ->slug();
        });
    } */

    public function scopeHomePage(Builder $query): void
    {
        $query->where('on_home_page', true)
            ->orderBy('sorting')
            ->limit(6);
    }

}
