<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Koperasi;

class Pengurus extends Model
{
    use HasFactory;
    protected $table = 'pengurus';
    protected $primaryKey = 'id';
    protected $fillable = [
        'koperasi_id','nama',
        'jabatan',
        'jenis_kelamin',
        'usia',
        'pendidikan_koperasi',
        'pendidikan_ekonomi',
        'pelatihan_koperasi',
        'pelatihan_bisnis',
        'pelatihan_lainnya',
        'tingkat_pendidikan',
        'keaktifan_kkmp'
    ];
    protected $casts = [
        'usia' => 'integer',
        'pendidikan_koperasi' => 'boolean',
        'pendidikan_ekonomi' => 'boolean',
        'pelatihan_koperasi' => 'boolean',
        'pelatihan_bisnis' => 'boolean',
        'pelatihan_lainnya' => 'boolean',
    ];

    public function koperasi()
    {
        return $this->belongsTo(Koperasi::class, 'koperasi_id', 'id');
    }

    public function latarBelakang()
    {
        return $this->hasMany(LatarBelakang::class, 'pengurus_id', 'id');
    }
}
