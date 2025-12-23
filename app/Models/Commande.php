<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'product_stock_id', 'quantity', 'status', 'notes'];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function productStock()
    {
        return $this->belongsTo(ProductStock::class);
    }

    public static function getStatuses()
    {
        return ['en attente', 'en cours', 'livré', 'annulé'];
    }
}
