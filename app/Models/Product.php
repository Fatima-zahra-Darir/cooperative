<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'type_emballage'];

    protected $casts = [
        'type_emballage' => 'string',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class);
    }

    public function stock()
    {
        return $this->hasMany(ProductStock::class);
    }

    // Check if this is packaging (has type_emballage)
    public function isEmballage()
    {
        return !is_null($this->type_emballage);
    }

    // Get type of emballage
    public function getTypeEmballageLabel()
    {
        $types = [
            'PILULIER' => '📦 Pilulier',
            'BOUCHON' => '🔓 Bouchon',
        ];
        
        return $types[$this->type_emballage] ?? $this->type_emballage;
    }
}

