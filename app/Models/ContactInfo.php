<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactInfo extends Model
{
    protected $table = 'contact_info';

    protected $fillable = [
        'features_area_content_id',
        'icon_class',
        'title',
        'description',
        'link',
        'is_external',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'is_external' => 'boolean',
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
            'icon_class' => $this->icon_class,
            'title' => $this->title,
            'description' => $this->description,
            'link' => $this->link,
            'is_external' => $this->is_external,
            'display_order' => $this->display_order,
            'is_active' => $this->is_active,
        ];
    }
}

