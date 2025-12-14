<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformaOrganisasi extends Model
{
    use HasFactory;
    protected $table = 'performa_organisasi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'performa_id',
        'responden_id',
        'jumlah_pengurus',
        'jumlah_pengawas',
        'jumlah_karyawan',
        'status',
        'total_anggota',
        'anggota_aktif',
        'anggota_tidak_aktif',
        'general_manager',
        'rapat_tepat_waktu',
        'rapat_luar_biasa',
        'pergantian_pengurus',
        'pergantian_pengawas'
    ];
    protected $casts = [
        'jumlah_pengurus'=>'integer',
        'jumlah_pengawas'=>'integer',
        'jumlah_karyawan'=>'integer',
        'total_anggota'=>'integer',
        'anggota_aktif'=>'integer',
        'anggota_tidak_aktif'=>'integer',
        'general_manager'=>'boolean',
        'rapat_tepat_waktu'=>'boolean',
        'rapat_luar_biasa'=>'boolean',
        'pergantian_pengurus'=>'boolean',
        'pergantian_pengawas'=>'boolean'
    ];

    public function performa()
    {
        return $this->belongsTo(Performa::class, 'performa_id', 'id');
    }

    public function rencanaStrategis()
    {
        return $this->hasOne(RencanaStrategis::class, 'performa_organisasi_id', 'id');
    }

    public function prinsipKoperasi()
    {
        return $this->hasOne(PrinsipKoperasi::class, 'performa_organisasi_id', 'id');
    }

    public function pelatihan()
    {
        return $this->hasMany(Pelatihan::class, 'performa_organisasi_id', 'id');
    }

    public function rapatKoordinasi()
    {
        return $this->hasOne(RapatKoordinasi::class, 'performa_organisasi_id', 'id');
    }
}
