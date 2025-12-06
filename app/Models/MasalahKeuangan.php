<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasalahKeuangan extends Model
{
    protected $table = 'masalah_keuangan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'performa_bisnis_id',
        'rugi_keseluruhan',
        'rugi_sebagian',
        'arus_kas',
        'piutang',
        'jatuh_tempo',
        'kredit',
        'penggelapan'
    ];
    protected $casts = [
        'rugi_keseluruhan'=>'boolean',
        'rugi_sebagian'=>'boolean',
        'arus_kas'=>'boolean',
        'piutang'=>'boolean',
        'jatuh_tempo'=>'boolean',
        'kredit'=>'boolean',
        'penggelapan'=>'boolean'
    ];

    public function performaBisnis()
    {
        return $this->belongsTo(PerformaBisnis::class, 'performa_bisnis_id', 'id');
    }
}
