<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoneExtraction extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'nom',
        'description',
    ];

    public function site()
    {
        return $this->belongsTo(SiteMinier::class, 'site_id');
    }

    public function productions()
    {
        return $this->hasMany(Production::class);
    }
}
