<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'language',
        'name',
        'slug',
        'show_at_nav',
        'status',
    ];

    protected $casts = [
        'show_at_nav' => 'boolean',
        'status' => 'boolean',
    ];

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }
}
