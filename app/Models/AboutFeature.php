<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AboutFeature extends Model
{
    protected $table = 'about_features';

    protected $fillable = [
        'about_content_id',
        'icon',
        'color',
        'label',
        'display_order',
    ];

    protected $casts = [
        'display_order' => 'integer',
    ];

    public function aboutContent(): BelongsTo
    {
        return $this->belongsTo(AboutContent::class);
    }

    public function toApiFormat(): array
    {
        return [
            'id' => $this->id,
            'icon' => $this->icon,
            'color' => $this->color,
            'label' => $this->label,
            'display_order' => $this->display_order,
        ];
    }
}

