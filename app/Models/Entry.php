<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Entry extends Model
{
    protected $fillable = [
        'farm_id',
        'date',
        'fish_stock',
        'feed_quantity',
        'mortality',
        'water_temp',
        'remarks',
        'editable_until',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'editable_until' => 'datetime',
            'feed_quantity' => 'decimal:2',
            'water_temp' => 'decimal:2',
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
