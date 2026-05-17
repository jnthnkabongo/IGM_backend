<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Minerai extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'nom',
        'unite',
        'prix_reference',
        'site_minier_id',
    ];

    public function siteMinier()
    {
        return $this->belongsTo(SiteMinier::class, 'site_minier_id');
    }

    public function productions()
    {
        return $this->hasMany(Production::class);
    }
}
