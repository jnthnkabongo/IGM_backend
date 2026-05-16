<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analyse extends Model
{
    use HasFactory;

    protected $fillable = [
        'lot_id',
        'laboratoire',
        'taux_purete',
        'observations',
    ];

    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }
}
