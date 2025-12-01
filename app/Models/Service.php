<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'type',
        'short_description',
        'main_image',
        'image',
        'show_in_services',
        'show_in_pricing',
        'pricing_category',
        'pricing_features',
        'description',
        'featured',
        'gallery',
        'requirements',
        'cost',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'pricing_features' => 'array',
        'featured' => 'array',
        'gallery' => 'array',
        'requirements' => 'array',
        'cost' => 'array',
        'show_in_services' => 'boolean',
        'show_in_pricing' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Service $service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->title);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function scopeShowInServices($query)
    {
        return $query->where('show_in_services', true);
    }

    public function scopeShowInPricing($query)
    {
        return $query->where('show_in_pricing', true);
    }

    public function toApiFormat(): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'type' => $this->type,
            'shortDescription' => $this->short_description,
            'mainImage' => $this->main_image,
            'image' => $this->image,
            'showInServices' => $this->show_in_services,
            'showInPricing' => $this->show_in_pricing,
            'pricingCategory' => $this->pricing_category,
            'pricingFeatures' => $this->pricing_features ?? [],
            'description' => $this->description,
            'featured' => $this->featured,
            'gallery' => $this->gallery ?? [],
            'requirements' => $this->requirements ?? [],
            'cost' => $this->cost,
        ];
    }
}


