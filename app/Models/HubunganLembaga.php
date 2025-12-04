<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HubunganLembaga extends Model
{
    use HasFactory;

    protected $fillable = [
        'performa_bisnis_id',
        'kemudahan',
        'intensitas',
        'dampak',
    ];

    public function performaBisnis()
    {
        return $this->belongsTo(PerformaBisnis::class);
    }
}
