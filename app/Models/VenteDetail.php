<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenteDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'vente_id',
        'lot_id',
        'quantite',
        'prix_unitaire',
        'montant',
    ];

    public function vente()
    {
        return $this->belongsTo(Vente::class);
    }

    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }
}
