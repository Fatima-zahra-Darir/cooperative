<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommandeFilledCapsule extends Model
{
    use HasFactory;

    protected $table = 'commande_filled_capsules';
    protected $fillable = ['commande_id', 'filled_capsule_id', 'quantity'];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function filledCapsule()
    {
        return $this->belongsTo(FilledCapsule::class);
    }
}
