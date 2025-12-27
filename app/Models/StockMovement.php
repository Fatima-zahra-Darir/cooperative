<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $fillable = ['product_stock_id', 'fornisseur_id', 'type', 'quantity', 'movement_date', 'notes'];
    
    protected $casts = [
        'movement_date' => 'date',
    ];

    public function productStock()
    {
        return $this->belongsTo(ProductStock::class);
    }

    public function fornisseur()
    {
        return $this->belongsTo(Fornisseur::class);
    }
}
