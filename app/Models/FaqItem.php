<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqItem extends Model
{
    protected $table = 'faq_items';

    protected $fillable = [
        'question',
        'answer',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }

    public function toApiFormat(): array
    {
        return [
            'id' => $this->id,
            'question' => $this->question,
            'answer' => $this->answer,
            'is_active' => $this->is_active,
            'display_order' => $this->display_order,
        ];
    }
}

