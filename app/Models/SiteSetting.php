<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'group',
        'value',
    ];

    protected $casts = [
        'value' => 'array',
    ];

    public static function getByKey(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function setByKey(string $key, mixed $value, string $group = 'general'): static
    {
        // Asegurar que nunca se guarde null, usar valores por defecto
        if ($value === null) {
            // Si es string, usar cadena vacía; si no, usar array vacío
            $value = [];
        }
        
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );
    }

    public static function getByGroup(string $group): array
    {
        return static::where('group', $group)
            ->pluck('value', 'key')
            ->toArray();
    }
}

