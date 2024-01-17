<?php

namespace App\Models;

use Support\Casts\PriceCast;
use Laravel\Scout\Searchable;
use Domain\Catalog\Models\Brand;
use Support\Traits\Models\HasSlug;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Models\HasThumbnail;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;
    use Searchable;

    protected $fillable = [
        'slug',
        'title',
        'brand_id',
        'price',
        'thumbnail',
        'on_home_page',
        'sorting',
        'text',
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

    #[SearchUsingFullText(['title', 'text'])]
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'text' => $this->text,
        ];
    }

    public function scopeFiltered(Builder $query): void
    {
        foreach (filters() as $filter) {
            $query = $filter->apply($query);
        }
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
