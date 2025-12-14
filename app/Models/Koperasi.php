<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Koperasi extends Model
{
    protected $table = 'koperasi';
    protected $primaryKey = 'id';
    protected $fillable = ['nama', 'kontak', 'no_badan_hukum', 'tahun', 'responden_id'];

    public function pengurus()
    {
        return $this->hasMany(Pengurus::class, 'koperasi_id', 'id');
    }

    public function lokasi()
    {
        return $this->hasMany(Lokasi::class, 'koperasi_id', 'id');
    }

    public function performa()
    {
        return $this->hasMany(Performa::class, 'koperasi_id', 'id');
    }

    public function responden()
    {
        return $this->belongsTo(Responden::class, 'responden_id', 'id');
    }
}
