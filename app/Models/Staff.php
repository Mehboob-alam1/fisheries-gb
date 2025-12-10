<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    protected $fillable = [
        'farm_id',
        'name',
        'position',
        'contact_number',
        'cnic',
        'joining_date',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'joining_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the farm that owns the staff
     */
    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }

    /**
     * Get all attendance records for this staff
     */
    public function attendance(): HasMany
    {
        return $this->hasMany(StaffAttendance::class);
    }
}
