<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permi extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'numero',
        'date_debut',
        'date_fin',
        'titulaire',
        'document',
    ];

    public function site()
    {
        return $this->belongsTo(SiteMinier::class, 'site_id');
    }
}
