<?php

namespace Support\Traits\Models;


use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    protected static function bootHasSlug()
    {
        // dump('tr');

        static::creating(function (Model $model) {
            $model->slug = $model->slug ?? str($model->{self::slugFrom()})
                ->append(rand(1,100))
                ->slug();
        });
    }

    public static function slugFrom(): string
    {
        return 'title';
    }
}
