<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'lot_id',
        'quantite_disponible',
    ];

    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }
}
