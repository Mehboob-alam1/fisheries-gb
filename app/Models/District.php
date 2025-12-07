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
