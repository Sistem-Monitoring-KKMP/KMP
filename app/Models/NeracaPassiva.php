<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NeracaPassiva extends Model
{
    protected $table = 'neraca_passiva';
    protected $primaryKey = 'id';
    protected $fillable = [
        'performa_bisnis_id',
        'hutang_lancar',
        'hutang_jangka_panjang',
        'total_hutang',
        'modal',
        'total_passiva'
    ];
    protected $casts = [
        'hutang_lancar'=>'integer',
        'hutang_jangka_panjang'=>'integer',
        'total_hutang'=>'integer',
        'modal'=>'integer',
        'total_passiva'=>'integer'
    ];

    public function performaBisnis()
    {
        return $this->belongsTo(PerformaBisnis::class, 'performa_bisnis_id', 'id');
    }
}
