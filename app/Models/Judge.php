<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Judge extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'city',
        'photo',
        'license_type',
        'categories',
        'breeds',
        'description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'categories' => 'array',
        'breeds' => 'array',
        'is_active' => 'boolean',
    ];

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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'city' => $this->city,
            'photo' => $this->photo,
            'licenseType' => $this->license_type,
            'categories' => $this->categories ?? [],
            'breeds' => $this->breeds ?? [],
            'description' => $this->description,
        ];
    }
}



