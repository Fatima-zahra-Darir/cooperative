<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CapsuleStockMovement extends Model
{
    protected $fillable = ['capsule_id', 'type', 'quantity', 'movement_date', 'notes'];
    
    protected $casts = [
        'movement_date' => 'date',
    ];

    public function capsule()
    {
        return $this->belongsTo(Capsule::class);
    }
}
