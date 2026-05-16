<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'zone_id',
        'minerai_id',
        'date_production',
        'quantite',
        'observations',
        'responsable_id',
    ];

    public function site()
    {
        return $this->belongsTo(SiteMinier::class, 'site_id');
    }

    public function zone()
    {
        return $this->belongsTo(ZoneExtraction::class, 'zone_id');
    }

    public function minerai()
    {
        return $this->belongsTo(Minerai::class);
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function lots()
    {
        return $this->hasMany(Lot::class);
    }
}
