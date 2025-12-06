<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koperasi extends Model
{
    /** @use HasFactory<\Database\Factories\KoperasiFactory> */
    use HasFactory;

    protected $table = 'koperasi';

    protected $fillable = [
        'nama',
        'kontak',
        'no_badan_hukum',
        'tahun',
        'status',
    ];

    public function pengurus()
    {
        return $this->hasMany(Pengurus::class);
    }

    public function lokasi()
    {
        return $this->hasMany(Lokasi::class);
    }

    public function pengawas()
    {
        return $this->hasMany(Pengawas::class);
    }

    public function performa()
    {
        return $this->hasMany(Performa::class);
    }
}
