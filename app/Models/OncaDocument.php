<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OncaDocument extends Model
{
    protected $fillable = [
        'type',
        'reference',
        'title',
        'version',
        'date',
        'responsible',
        'content',
    ];

    protected $casts = [
        'content' => 'array',
        'date' => 'date',
    ];
}
