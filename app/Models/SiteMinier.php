<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteMinier extends Model
{
    use HasFactory;

    protected $fillable = [
        'concession_id',
        'code',
        'nom',
        'province',
        'territoire',
        'latitude',
        'longitude',
        'responsable_id',
    ];

    public function concession()
    {
        return $this->belongsTo(Concession::class);
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function zonesExtraction()
    {
        return $this->hasMany(ZoneExtraction::class);
    }

    public function permis()
    {
        return $this->hasMany(Permi::class);
    }

    public function productions()
    {
        return $this->hasMany(Production::class);
    }
}
