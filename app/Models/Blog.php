<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'short_description',
        'main_image',
        'date',
        'author',
        'author_url',
        'tags',
        'tags_url',
        'excerpt',
        'content',
        'related_posts',
        'gallery',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'tags' => 'array',
        'content' => 'array',
        'related_posts' => 'array',
        'gallery' => 'array',
        'date' => 'date',
        'is_active' => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Blog $blog) {
            if (empty($blog->slug) && !empty($blog->title)) {
                $blog->slug = Str::slug($blog->title);
            }
        });

        static::updating(function (Blog $blog) {
            if (empty($blog->slug) && !empty($blog->title)) {
                $blog->slug = Str::slug($blog->title);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('date');
    }

    public function toApiFormat(): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'shortDescription' => $this->short_description,
            'mainImage' => $this->main_image,
            'date' => $this->date?->format('d M Y'),
            'author' => $this->author,
            'authorUrl' => $this->author_url,
            'tags' => $this->tags ?? [],
            'tagsUrl' => $this->tags_url,
            'excerpt' => $this->excerpt,
            'content' => $this->content ?? [],
            'relatedPosts' => $this->related_posts ?? [],
            'gallery' => $this->gallery ?? [],
        ];
    }
}

