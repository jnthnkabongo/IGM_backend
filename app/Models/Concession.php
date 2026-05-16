<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concession extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'nom',
        'numero_cadastre',
        'superficie',
        'proprietaire',
    ];

    public function sitesMiniers()
    {
        return $this->hasMany(SiteMinier::class);
    }
}
