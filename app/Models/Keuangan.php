<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    protected $table = 'keuangan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'performa_bisnis_id',
        'pinjaman_bank',
        'investasi',
        'modal_kerja',
        'simpanan_anggota',
        'hibah',
        'omset',
        'operasional',
        'surplus'
    ];
    protected $casts = [
        'pinjaman_bank'=>'integer',
        'investasi'=>'integer',
        'modal_kerja'=>'integer',
        'simpanan_anggota'=>'integer',
        'hibah'=>'integer',
        'omset'=>'integer',
        'operasional'=>'integer',
        'surplus'=>'integer'
    ];

    public function performaBisnis()
    {
        return $this->belongsTo(PerformaBisnis::class, 'performa_bisnis_id', 'id');
    }
}
