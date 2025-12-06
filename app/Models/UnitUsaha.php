<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitUsaha extends Model
{
    protected $table = 'unit_usaha';
    protected $primaryKey = 'id';
    protected $fillable = [
        'performa_bisnis_id',
        'unit',
        'volume_usaha',
        'investasi',
        'model_kerja',
        'surplus',
        'jumlah_sdm',
        'jumlah_anggota'
    ];
    protected $casts = [
        'volume_usaha'=>'integer',
        'investasi'=>'integer',
        'model_kerja'=>'integer',
        'surplus'=>'integer',
        'jumlah_sdm'=>'integer',
        'jumlah_anggota'=>'integer'
    ];

    public function performaBisnis()
    {
        return $this->belongsTo(PerformaBisnis::class, 'performa_bisnis_id', 'id');
    }
}
