<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrinsipKoperasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'performa_organisasi_id',
        'sukarela_terbuka',
        'demokratis',
        'ekonomi',
        'kemandirian',
        'pendidikan',
        'kerja_sama',
        'kepedulian',
    ];

    public function performaOrganisasi()
    {
        return $this->belongsTo(PerformaOrganisasi::class);
    }
}
