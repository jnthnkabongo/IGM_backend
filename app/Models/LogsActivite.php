<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogsActivite extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'table_concernee',
        'reference_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
