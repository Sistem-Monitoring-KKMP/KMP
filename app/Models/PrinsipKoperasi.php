<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrinsipKoperasi extends Model
{
    protected $table = 'prinsip_koperasi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'performa_organisasi_id',
        'sukarela_terbuka',
        'demokratis',
        'ekonomi',
        'kemandirian',
        'pendidikan',
        'kerja_sama',
        'kepedulian'
    ];
    protected $casts = [
        'sukarela_terbuka'=>'integer',
        'demokratis'=>'integer',
        'ekonomi'=>'integer',
        'kemandirian'=>'integer',
        'pendidikan'=>'integer',
        'kerja_sama'=>'integer',
        'kepedulian'=>'integer'
    ];

    public function performaOrganisasi()
    {
        return $this->belongsTo(PerformaOrganisasi::class, 'performa_organisasi_id', 'id');
    }
}
