<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkingSchedule extends Model
{
    protected $table = 'working_schedules';

    protected $fillable = [
        'features_area_content_id',
        'day',
        'hours',
        'is_holiday',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'is_holiday' => 'boolean',
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    public function featuresAreaContent(): BelongsTo
    {
        return $this->belongsTo(FeaturesAreaContent::class);
    }

    public function toApiFormat(): array
    {
        return [
            'id' => $this->id,
            'day' => $this->day,
            'hours' => $this->hours,
            'is_holiday' => $this->is_holiday,
            'display_order' => $this->display_order,
            'is_active' => $this->is_active,
        ];
    }
}

