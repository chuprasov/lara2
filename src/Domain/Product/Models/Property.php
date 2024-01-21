<?php

namespace Domain\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Domain\Product\Collections\PropertyCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function newCollection($models = []): PropertyCollection
    {
        return new PropertyCollection($models);
    }
}
