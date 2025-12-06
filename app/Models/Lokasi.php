<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    protected $table = 'lokasi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'koperasi_id','kelurahan_id','kecamatan_id','alamat','longitude','latitude'
    ];
    protected $casts = [
        'longitude' => 'decimal:6',
        'latitude' => 'decimal:6'
    ];

    public function koperasi()
    {
        return $this->belongsTo(Koperasi::class, 'koperasi_id', 'id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id', 'id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'id');
    }
}
