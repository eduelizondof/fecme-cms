<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Breeder extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'logo',
        'feature_image',
        'breeds',
        'location',
        'member_since',
        'rating',
        'total_reviews',
        'description',
        'short_description',
        'website',
        'email',
        'phone',
        'whatsapp',
        'social_links',
        'certifications',
        'features',
        'responsible',
        'about',
        'sires',
        'care',
        'awards',
        'gallery',
        'reviews',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'breeds' => 'array',
        'location' => 'array',
        'social_links' => 'array',
        'certifications' => 'array',
        'features' => 'array',
        'responsible' => 'array',
        'about' => 'array',
        'sires' => 'array',
        'care' => 'array',
        'awards' => 'array',
        'gallery' => 'array',
        'reviews' => 'array',
        'rating' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Breeder $breeder) {
            if (empty($breeder->slug)) {
                $breeder->slug = Str::slug($breeder->name);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function toApiFormat(): array
    {
        return [
            'slug' => $this->slug,
            'name' => $this->name,
            'logo' => $this->logo,
            'featureImage' => $this->feature_image,
            'breeds' => $this->breeds ?? [],
            'location' => $this->location,
            'memberSince' => $this->member_since,
            'rating' => (float) $this->rating,
            'totalReviews' => $this->total_reviews,
            'description' => $this->description,
            'shortDescription' => $this->short_description,
            'website' => $this->website,
            'email' => $this->email,
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
            'socialLinks' => $this->social_links ?? [],
            'certifications' => $this->certifications ?? [],
            'features' => $this->features ?? [],
            'responsible' => $this->responsible,
            'about' => $this->about,
            'sires' => $this->sires ?? [],
            'care' => $this->care,
            'awards' => $this->awards ?? [],
            'gallery' => $this->gallery ?? [],
            'reviews' => $this->reviews ?? [],
        ];
    }
}

