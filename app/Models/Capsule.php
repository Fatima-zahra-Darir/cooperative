<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Capsule extends Model
{
    protected $fillable = ['carton', 'quantity', 'notes'];

    public function movements()
    {
        return $this->hasMany(CapsuleStockMovement::class);
    }

    public function filledCapsules()
    {
        return $this->hasMany(FilledCapsule::class);
    }

    /**
     * Calculate the global quantity based on movements
     */
    public function getGlobalQuantityAttribute()
    {
        // Use eager-loaded relationship if available, otherwise query
        if ($this->relationLoaded('movements')) {
            $restocks = $this->movements->where('type', 'restock')->sum('quantity');
            $usages = $this->movements->where('type', 'usage')->sum('quantity');
        } else {
            $restocks = $this->movements()->where('type', 'restock')->sum('quantity');
            $usages = $this->movements()->where('type', 'usage')->sum('quantity');
        }
        return ($this->quantity ?? 0) + $restocks - $usages;
    }
}
