<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'devise_id',
        'numero',
        'date_vente',
        'montant_total',
        'statut',
        'user_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function devise()
    {
        return $this->belongsTo(Devise::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function venteDetails()
    {
        return $this->hasMany(VenteDetail::class);
    }
}
