<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RapatKoordinasi extends Model
{
    protected $table = 'rapat_koordinasi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'performa_organisasi_id',
        'rapat_pengurus',
        'rapat_pengawas',
        'rapat_gabungan',
        'rapat_pengurus_karyawan',
        'rapat_pengurus_anggota'
    ];

    public function performaOrganisasi()
    {
        return $this->belongsTo(PerformaOrganisasi::class, 'performa_organisasi_id', 'id');
    }
}
