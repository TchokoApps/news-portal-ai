<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
