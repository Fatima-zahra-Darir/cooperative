<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Capsule extends Model
{
    protected $fillable = ['carton', 'quantity', 'nombre_capsules', 'notes'];

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

    /**
     * Calculate remaining cartons based on nombre_capsules
     * 1 carton = 125,000 capsules
     */
    public function getRemainingCartonsAttribute()
    {
        return intval(floor($this->nombre_capsules / 125000));
    }

    /**
     * Get carton status
     * If nombre_capsules < 125000 → "Carton ouvert"
     * Otherwise → number of full cartons
     */
    public function getCartonStatusAttribute()
    {
        if ($this->nombre_capsules < 125000 && $this->nombre_capsules > 0) {
            return 'Carton ouvert';
        }
        return $this->remaining_cartons;
    }

    /**
     * Calculate nombre_capsules from quantity (cartons)
     * nombre_capsules = quantity * 125000
     */
    public static function calculateNombreCapsules($quantity)
    {
        return $quantity * 125000;
    }

    /**
     * Boot the model to set nombre_capsules when creating
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->nombre_capsules && $model->quantity) {
                $model->nombre_capsules = self::calculateNombreCapsules($model->quantity);
            }
        });
    }
}
