<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Support\Casts\SeoUrlCast;

class Seo extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'title',
    ];

    protected $casts = [
        'url' => SeoUrlCast::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Seo $seo) {
            Cache::forget('seo_'.str($seo->url)->slug('_'));
        });

        static::updating(function (Seo $seo) {
            Cache::forget('seo_'.str($seo->url)->slug('_'));
        });

        static::deleting(function (Seo $seo) {
            Cache::forget('seo_'.str($seo->url)->slug('_'));
        });
    }
}
