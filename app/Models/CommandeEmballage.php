<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommandeEmballage extends Model
{
    use HasFactory;

    protected $table = 'commande_emballages';
    protected $fillable = ['commande_id', 'product_stock_id', 'quantity'];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function productStock()
    {
        return $this->belongsTo(ProductStock::class);
    }
}
