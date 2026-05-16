<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_id',
        'numero',
        'qr_code',
        'verification_token',
        'hash_signature',
        'quantite',
        'quantite_restante',
        'statut',
    ];

    protected $casts = [
        'statut' => 'string',
    ];

    public function production()
    {
        return $this->belongsTo(Production::class);
    }

    public function analyses()
    {
        return $this->hasMany(Analyse::class);
    }

    public function mouvementsStock()
    {
        return $this->hasMany(MouvementStock::class);
    }

    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    public function venteDetails()
    {
        return $this->hasMany(VenteDetail::class);
    }
}
