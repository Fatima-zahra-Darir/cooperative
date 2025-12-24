<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CapsuleStockMovement extends Model
{
    protected $fillable = ['capsule_id', 'herb_id', 'herb_quantity', 'type', 'quantity', 'movement_date', 'notes'];
    
    protected $casts = [
        'movement_date' => 'date',
        'herb_quantity' => 'decimal:2',
    ];

    public function capsule()
    {
        return $this->belongsTo(Capsule::class);
    }

    public function herb()
    {
        return $this->belongsTo(Herb::class);
    }
}
