<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NeracaAktiva extends Model
{
    protected $table = 'neraca_aktiva';
    protected $primaryKey = 'id';
    protected $fillable = [
        'performa_bisnis_id',
        'kas',
        'piutang',
        'aktiva_lancar',
        'tanah',
        'bangunan',
        'kendaraan',
        'aktiva_tetap',
        'total_aktiva'
    ];
    protected $casts = [
        'kas'=>'integer',
        'piutang'=>'integer',
        'aktiva_lancar'=>'integer',
        'tanah'=>'integer',
        'bangunan'=>'integer',
        'kendaraan'=>'integer',
        'aktiva_tetap'=>'integer',
        'total_aktiva'=>'integer'
    ];

    public function performaBisnis()
    {
        return $this->belongsTo(PerformaBisnis::class, 'performa_bisnis_id', 'id');
    }
}
