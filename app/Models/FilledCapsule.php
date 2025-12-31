<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilledCapsule extends Model
{
    protected $fillable = [
        'capsule_id',
        'herb_id',
        'quantity',
        'herb_quantity',
        'filled_date',
        'capsule_movement_id',
        'notes',
    ];

    protected $casts = [
        'filled_date' => 'date',
        'herb_quantity' => 'decimal:2',
    ];

    /**
     * Get the number of capsules used (rangées × 420)
     */
    public function getCapsulesUsedAttribute()
    {
        return $this->quantity * 420;
    }

    public function capsule()
    {
        return $this->belongsTo(Capsule::class);
    }

    public function herb()
    {
        return $this->belongsTo(Herb::class);
    }

    public function capsuleMovement()
    {
        return $this->belongsTo(CapsuleStockMovement::class, 'capsule_movement_id');
    }
}
