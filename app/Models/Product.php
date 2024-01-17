<?php

namespace App\Models;

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Pipeline\Pipeline;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Searchable;
use Support\Casts\PriceCast;
use Support\Traits\Models\HasSlug;
use Support\Traits\Models\HasThumbnail;

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

    public function scopeFiltered(Builder $builder)
    {
        /* foreach (filters() as $filter) {
            $builder = $filter->apply($builder);
        } */

        return app(Pipeline::class)
            ->send($builder)
            ->through(filters())
            ->thenReturn();
    }

    public function scopeSorted(Builder $query)
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
