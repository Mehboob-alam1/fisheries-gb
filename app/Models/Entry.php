<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Entry extends Model
{
    protected $fillable = [
        'farm_id',
        'date',
        'fish_stock',
        'mortality',
        'shifting_in',
        'shifting_out',
        'sale',
        'feed_quantity',
        'feed_in_stock',
        'feed_consumption',
        'medication',
        'water_temp',
        'water_ph',
        'water_do',
        'offence_cases',
        'additional_notes',
        'editable_until',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'editable_until' => 'datetime',
            'feed_quantity' => 'decimal:2',
            'feed_in_stock' => 'decimal:2',
            'feed_consumption' => 'decimal:2',
            'water_temp' => 'decimal:2',
            'water_ph' => 'decimal:2',
            'water_do' => 'decimal:2',
        ];
    }

    /**
     * Get the farm that owns the entry
     */
    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }

    /**
     * Get all staff attendance records for this entry
     */
    public function staffAttendance(): HasMany
    {
        return $this->hasMany(StaffAttendance::class);
    }

    /**
     * Check if entry is still editable (within 3 hours)
     */
    public function isEditable(): bool
    {
        return Carbon::now()->lessThan($this->editable_until);
    }

    /**
     * Boot method to set editable_until automatically
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($entry) {
            if (empty($entry->editable_until)) {
                $entry->editable_until = Carbon::now()->addHours(3);
            }
        });
    }
}
