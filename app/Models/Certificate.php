<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'microchip',
        'registration_number',
        'name',
        'breed',
        'variety',
        'sex',
        'color',
        'birth_place',
        'birth_date',
        'image',
        'valid',
        'certificate_number',
        'certificate_date',
        'breeder',
        'owner',
        'co_owner',
        'address',
        'zip_code',
        'neighborhood',
        'city',
        'phone',
        'titles',
        'observations',
        'status',
        'is_active',
    ];

    protected $casts = [
        'titles' => 'array',
        'birth_date' => 'date',
        'certificate_date' => 'date',
        'valid' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeValid($query)
    {
        return $query->where('valid', true);
    }

    public function toApiFormat(): array
    {
        return [
            'microchip' => $this->microchip,
            'registrationNumber' => $this->registration_number,
            'name' => $this->name,
            'breed' => $this->breed,
            'variety' => $this->variety,
            'sex' => $this->sex,
            'color' => $this->color,
            'birthPlace' => $this->birth_place,
            'birthDate' => $this->birth_date?->format('Y-m-d'),
            'image' => $this->image,
            'valid' => $this->valid,
            'certificateNumber' => $this->certificate_number,
            'certificateDate' => $this->certificate_date?->format('Y-m-d'),
            'breeder' => $this->breeder,
            'owner' => $this->owner,
            'coOwner' => $this->co_owner,
            'address' => $this->address,
            'zipCode' => $this->zip_code,
            'neighborhood' => $this->neighborhood,
            'city' => $this->city,
            'phone' => $this->phone,
            'titles' => $this->titles ?? [],
            'observations' => $this->observations,
            'status' => $this->status,
        ];
    }
}

