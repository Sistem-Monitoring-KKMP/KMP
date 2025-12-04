<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Performa extends Model
{
    use HasFactory;

    protected $fillable = [
        'koperasi_id',
        'cdi',
        'bdi',
        'odi',
        'kuadrant',
        'periode',
    ];

    protected $casts = [
        'periode' => 'date',
    ];

    public function koperasi()
    {
        return $this->belongsTo(Koperasi::class);
    }

    public function performaBisnis()
    {
        return $this->hasOne(PerformaBisnis::class);
    }

    public function performaOrganisasi()
    {
        return $this->hasOne(PerformaOrganisasi::class);
    }
}
