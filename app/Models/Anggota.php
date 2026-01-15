<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'kode',
        'nama',
        'nik',
        'telp',
        'alamat',
        'tempat_lahir',
        'tanggal_lahir',
        'kelurahan',
        'kecamatan',
        'kota_kab',
        'keterangan',
        'jenis_kelamin',
        'pekerjaan',
        'foto_anggota',
        'ktp',
        'npwp',
        'nib',
        'pas_foto',
        'status',
        'koperasi_id',
    ];

    /** Relation: Anggota memiliki 1 User */
    public function user()
    {
        return $this->hasOne(User::class, 'anggota_id', 'id');
    }
}
