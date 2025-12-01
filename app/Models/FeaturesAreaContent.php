<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeaturesAreaContent extends Model
{
    protected $table = 'features_area_content';

    protected $fillable = [
        'working_hours_background',
        'working_hours_title',
        'working_hours_description',
        'is_open_now',
        'subtitle',
        'title',
        'description',
        'slogan',
    ];

    protected $casts = [
        'is_open_now' => 'boolean',
    ];

    public function schedules(): HasMany
    {
        return $this->hasMany(WorkingSchedule::class)->orderBy('display_order');
    }

    public function contactInfo(): HasMany
    {
        return $this->hasMany(ContactInfo::class)->orderBy('display_order');
    }

    public function toApiFormat(): array
    {
        return [
            'id' => $this->id,
            'working_hours_background' => $this->working_hours_background,
            'working_hours_title' => $this->working_hours_title,
            'working_hours_description' => $this->working_hours_description,
            'is_open_now' => $this->is_open_now,
            'subtitle' => $this->subtitle,
            'title' => $this->title,
            'description' => $this->description,
            'slogan' => $this->slogan,
            'schedules' => $this->schedules()->where('is_active', true)->get()->map(fn (WorkingSchedule $schedule) => $schedule->toApiFormat()),
            'contact_info' => $this->contactInfo()->where('is_active', true)->get()->map(fn (ContactInfo $contact) => $contact->toApiFormat()),
        ];
    }
}

