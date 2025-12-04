<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformaOrganisasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'performa_id',
        'jumlah_anggota',
        'jumlah_karwayan',
        'chairmen_activeness',
        'control_effectiveness',
        'external_visit',
    ];

    protected $casts = [
        'chairmen_activeness' => 'float',
        'control_effectiveness' => 'float',
    ];

    public function performa()
    {
        return $this->belongsTo(Performa::class);
    }

    public function rencanaStrategis()
    {
        return $this->hasOne(RencanaStrategis::class);
    }

    public function prinsipKoperasi()
    {
        return $this->hasOne(PrinsipKoperasi::class);
    }
}
