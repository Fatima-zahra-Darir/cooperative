<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fornisseur extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone_number', 'ville', 'specialite'];

    public function herbStockMovements()
    {
        return $this->hasMany(HerbStockMovement::class);
    }

    public function capsuleStockMovements()
    {
        return $this->hasMany(CapsuleStockMovement::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}
