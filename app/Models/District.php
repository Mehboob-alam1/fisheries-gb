<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * Get the list of allowed district names from the seeder
     */
    public static function getAllowedDistricts(): array
    {
        return [
            'Gilgit',
            'Skardu',
            'Kharmang',
            'Ghanche',
            'Astore',
            'Diamer',
            'Ghizer',
            'Nagar',
            'Shigar',
        ];
    }

    /**
     * Scope to get only allowed districts
     */
    public function scopeAllowed($query)
    {
        return $query->whereIn('name', self::getAllowedDistricts());
    }

    /**
     * Get all farms in this district
     */
    public function farms(): HasMany
    {
        return $this->hasMany(Farm::class);
    }

    /**
     * Get all managers in this district
     */
    public function managers(): HasMany
    {
        return $this->hasMany(User::class)->where('role', 'manager');
    }
}
