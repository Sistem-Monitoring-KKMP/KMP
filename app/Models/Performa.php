<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Performa extends Model
{
    protected $table = 'performa';
    protected $primaryKey = 'id';
    protected $fillable = ['koperasi_id','cdi','bdi','odi','kuadrant','periode'];
    protected $casts = [
        'cdi' => 'integer','bdi' => 'integer','odi' => 'integer','kuadrant' => 'integer','periode' => 'date'
    ];

    public function koperasi()
    {
        return $this->belongsTo(Koperasi::class, 'koperasi_id', 'id');
    }

    public function performaBisnis()
    {
        return $this->hasOne(PerformaBisnis::class, 'performa_id', 'id');
    }

    public function performaOrganisasi()
    {
        return $this->hasOne(PerformaOrganisasi::class, 'performa_id', 'id');
    }
}
