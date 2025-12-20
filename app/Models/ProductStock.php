<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    protected $table = 'product_stock';
    
    protected $fillable = ['product_id', 'category_id', 'color_id', 'size_id', 'quantity', 'notes'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function movements()
    {
        return $this->hasMany(StockMovement::class);
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
