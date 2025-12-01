<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'type',
        'image',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'organizer',
        'judges',
        'breeds',
        'description',
        'details',
        'requirements',
        'inscription_info',
        'myths',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'location' => 'array',
        'judges' => 'array',
        'breeds' => 'array',
        'requirements' => 'array',
        'inscription_info' => 'array',
        'myths' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Event $event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('start_date');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now()->startOfDay());
    }

    public function toApiFormat(): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'type' => $this->type,
            'image' => $this->image,
            'startDate' => $this->start_date?->format('Y-m-d'),
            'endDate' => $this->end_date?->format('Y-m-d'),
            'startTime' => $this->start_time,
            'endTime' => $this->end_time,
            'location' => $this->location,
            'organizer' => $this->organizer,
            'judges' => $this->judges ?? [],
            'breeds' => $this->breeds ?? [],
            'description' => $this->description,
            'details' => $this->details,
            'requirements' => $this->requirements ?? [],
            'inscriptionInfo' => $this->inscription_info,
            'myths' => $this->myths ?? [],
        ];
    }
}


