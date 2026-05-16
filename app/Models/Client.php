<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_client_id',
        'nom',
        'telephone',
        'email',
        'adresse',
    ];

    public function typeClient()
    {
        return $this->belongsTo(TypeClient::class);
    }

    public function ventes()
    {
        return $this->hasMany(Vente::class);
    }
}
