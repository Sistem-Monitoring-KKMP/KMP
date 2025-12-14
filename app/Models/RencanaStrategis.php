<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RencanaStrategis extends Model
{
    protected $table = 'rencana_strategis';
    protected $primaryKey = 'id';
    protected $fillable = [
        'performa_organisasi_id',
        'visi',
        'misi',
        'rencana_strategis',
        'sasaran_operasional',
        'art'
    ];
    protected $casts = [
        'visi'=>'boolean',
        'misi'=>'boolean',
        'rencana_strategis'=>'boolean',
        'sasaran_operasional'=>'boolean',
        'art'=>'boolean'
    ];

    public function performaOrganisasi()
    {
        return $this->belongsTo(PerformaOrganisasi::class, 'performa_organisasi_id', 'id');
    }
}
