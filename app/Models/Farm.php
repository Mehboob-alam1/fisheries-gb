<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Farm extends Model
{
    protected $fillable = [
        'district_id',
        'name',
        'manager_id',
        'location',
    ];

    /**
     * Get the district that owns the farm
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    /**
     * Get the manager of the farm
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Get all entries for this farm
     */
    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class);
    }
}
