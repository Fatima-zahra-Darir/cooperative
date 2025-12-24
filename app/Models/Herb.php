<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Herb extends Model
{
    protected $fillable = ['name', 'source'];

    public function movements()
    {
        return $this->hasMany(HerbStockMovement::class);
    }

    /**
     * Calculate the global quantity based on movements
     */
    public function getGlobalQuantityAttribute()
    {
        // Use eager-loaded relationship if available, otherwise query
        if ($this->relationLoaded('movements')) {
            $entries = $this->movements->where('type', 'entry')->sum('quantity');
            $usages = $this->movements->where('type', 'usage')->sum('quantity');
        } else {
            $entries = $this->movements()->where('type', 'entry')->sum('quantity');
            $usages = $this->movements()->where('type', 'usage')->sum('quantity');
        }
        return $entries - $usages;
    }
}
