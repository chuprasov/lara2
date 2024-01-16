<?php

namespace App\Models;

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Casts\PriceCast;
use Support\Traits\Models\HasSlug;
use Support\Traits\Models\HasThumbnail;

class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;

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
        'price' => PriceCast::class,
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function thumbnailDir(): string
    {
        return 'products';
    }

    public function scopeFiltered(Builder $query): void
    {
        $query->when(request('filters.brands'), function (Builder $builder) {
            $builder->whereIn('brand_id', request('filters.brands'));
        })->when(request('filters.price'), function (Builder $builder) {
            $builder->whereBetween('price', [
                request('filters.price.from', 0) * 100,
                request('filters.price.to', 100000) * 100,
            ]);
        });
    }

    public function scopeSorted(Builder $query): void
    {
        $query->when(request('sort'), function (Builder $builder) {
            $column = request()->str('sort');

            if ($column->contains(['price', 'title'])) {
                $direction = $column->contains('-') ? 'DESC' : 'ASC';

                $builder->orderBy((string) $column->remove('-'), $direction);
            }
        });
    }

    public function scopeHomePage(Builder $query): void
    {
        $query->where('on_home_page', true)
            ->orderBy('sorting')
            ->limit(6);
    }
}
