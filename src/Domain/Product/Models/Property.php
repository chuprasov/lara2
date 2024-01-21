<?php

namespace Domain\Product\Models;

use Domain\Product\Collections\PropertyCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
