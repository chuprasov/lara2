<?php

namespace Domain\Auth\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSocial extends Model
{
    use HasFactory;

    protected $fillable = [
        'social_name',
        'social_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
