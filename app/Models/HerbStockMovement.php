<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HerbStockMovement extends Model
{
    protected $fillable = ['herb_id', 'type', 'quantity', 'movement_date', 'notes'];
    
    protected $casts = [
        'movement_date' => 'date',
    ];

    public function herb()
    {
        return $this->belongsTo(Herb::class);
    }
}

