<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformaBisnis extends Model
{
    use HasFactory;

    protected $fillable = [
        'performa_id',
        'net_savings',
        'member_participation',
        'total_sales',
        'growth_sales',
    ];

    protected $casts = [
        'member_participation' => 'float',
        'growth_sales' => 'float',
    ];

    public function performa()
    {
        return $this->belongsTo(Performa::class);
    }

    public function hubunganLembaga()
    {
        return $this->hasOne(HubunganLembaga::class);
    }
}
