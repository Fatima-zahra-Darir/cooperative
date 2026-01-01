<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FornisseurSpecialite extends Model
{
    use HasFactory;

    protected $table = 'fornisseur_specialite';

    protected $fillable = ['fornisseur_id', 'specialite'];

    public function fornisseur()
    {
        return $this->belongsTo(Fornisseur::class);
    }
}
