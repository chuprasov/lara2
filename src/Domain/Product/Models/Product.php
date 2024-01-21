<?php

namespace Domain\Product\Models;

use Support\Casts\PriceCast;
use Laravel\Scout\Searchable;
use Domain\Catalog\Models\Brand;
use Support\Traits\Models\HasSlug;
use Domain\Catalog\Models\Category;
use App\Jobs\ProductJsonPropertiesJob;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Model;
use Support\Traits\Models\HasThumbnail;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Domain\Product\QueryBuilders\ProductQueryBuilder;
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
        'json_properties',
    ];

    protected $casts = [
        'price' => PriceCast::class,
        'json_properties' => 'array',
    ];

    protected static function newFactory()
    {
        return ProductFactory::new();
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function (Product $product) {
            ProductJsonPropertiesJob::dispatch($product)
                ->delay(now()->addSeconds(10));
        });
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class)
            ->withPivot('value');
    }

    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(OptionValue::class);
    }

    public function thumbnailDir(): string
    {
        return 'products';
    }

    public function newEloquentBuilder($query): ProductQueryBuilder
    {
        return new ProductQueryBuilder($query);
    }

    #[SearchUsingFullText(['title', 'text'])]
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'text' => $this->text,
        ];
    }
}
