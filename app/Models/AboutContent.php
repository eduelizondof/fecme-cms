<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AboutContent extends Model
{
    protected $table = 'about_content';

    protected $fillable = [
        'background_image',
        'main_image',
        'main_image_alt',
        'subtitle',
        'title',
        'description',
        'experience_from',
        'experience_to',
        'experience_speed',
        'experience_initial_value',
        'experience_label',
    ];

    protected $casts = [
        'experience_from' => 'integer',
        'experience_to' => 'integer',
        'experience_speed' => 'integer',
        'experience_initial_value' => 'integer',
    ];

    public function features(): HasMany
    {
        return $this->hasMany(AboutFeature::class)->orderBy('display_order');
    }

    public function toApiFormat(): array
    {
        return [
            'id' => $this->id,
            'background_image' => $this->background_image,
            'main_image' => $this->main_image,
            'main_image_alt' => $this->main_image_alt,
            'subtitle' => $this->subtitle,
            'title' => $this->title,
            'description' => $this->description,
            'experience_counter' => [
                'from' => $this->experience_from,
                'to' => $this->experience_to,
                'speed' => $this->experience_speed,
                'initial_value' => $this->experience_initial_value,
                'label' => $this->experience_label,
            ],
            'features' => $this->features->map(fn (AboutFeature $feature) => $feature->toApiFormat()),
        ];
    }
}

