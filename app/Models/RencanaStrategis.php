<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaStrategis extends Model
{
    use HasFactory;

    protected $fillable = [
        'performa_organisasi_id',
        'visi',
        'misi',
        'rencana_strategis',
        'sasaran_operasional',
        'art',
    ];

    public function performaOrganisasi()
    {
        return $this->belongsTo(PerformaOrganisasi::class);
    }
}
