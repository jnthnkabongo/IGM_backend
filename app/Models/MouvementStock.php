<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MouvementStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'lot_id',
        'type_mouvement',
        'quantite',
        'reference_type',
        'reference_id',
    ];

    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }
}
