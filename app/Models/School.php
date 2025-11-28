<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class School extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'logo',
        'feature_image',
        'programs_list',
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
        'programs',
        'facilities',
        'awards',
        'gallery',
        'reviews',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'programs_list' => 'array',
        'location' => 'array',
        'social_links' => 'array',
        'certifications' => 'array',
        'features' => 'array',
        'responsible' => 'array',
        'about' => 'array',
        'programs' => 'array',
        'facilities' => 'array',
        'awards' => 'array',
        'gallery' => 'array',
        'reviews' => 'array',
        'rating' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (School $school) {
            if (empty($school->slug)) {
                $school->slug = Str::slug($school->name);
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
            'programsList' => $this->programs_list ?? [],
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
            'programs' => $this->programs ?? [],
            'facilities' => $this->facilities,
            'awards' => $this->awards ?? [],
            'gallery' => $this->gallery ?? [],
            'reviews' => $this->reviews ?? [],
        ];
    }
}

