<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class News extends Model
{
    protected $table = 'news';

    protected $fillable = [
        'language',
        'category_id',
        'author_id',
        'image',
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'is_breaking_news',
        'show_at_slider',
        'show_at_popular',
        'status',
    ];

    protected $casts = [
        'is_breaking_news' => 'boolean',
        'show_at_slider' => 'boolean',
        'show_at_popular' => 'boolean',
        'status' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'author_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'news_tags')->withTimestamps();
    }

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        if (str_starts_with($this->image, 'news/') || str_contains($this->image, '/')) {
            return asset('storage/' . ltrim($this->image, '/'));
        }

        return asset($this->image);
    }
}
