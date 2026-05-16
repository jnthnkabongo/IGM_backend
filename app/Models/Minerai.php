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
    ];

    public function productions()
    {
        return $this->hasMany(Production::class);
    }
}
