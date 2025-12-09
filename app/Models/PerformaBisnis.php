<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PerformaBisnis extends Model
{
    use HasFactory;
    protected $table = 'performa_bisnis';
    protected $primaryKey = 'id';
    protected $fillable = ['performa_id','proyeksi_rugi_laba','proyeksi_arus_kas','responden_id'];
    protected $casts = [
        'proyeksi_rugi_laba' => 'boolean',
        'proyeksi_arus_kas' => 'boolean'
    ];

    public function performa()
    {
        return $this->belongsTo(Performa::class, 'performa_id', 'id');
    }

    public function hubunganLembaga()
    {
        return $this->hasMany(HubunganLembaga::class, 'performa_bisnis_id', 'id');
    }

    public function unitUsaha()
    {
        return $this->hasMany(UnitUsaha::class, 'performa_bisnis_id', 'id');
    }

    public function keuangan()
    {
        return $this->hasOne(Keuangan::class, 'performa_bisnis_id', 'id');
    }

    public function neracaAktiva()
    {
        return $this->hasOne(NeracaAktiva::class, 'performa_bisnis_id', 'id');
    }

    public function neracaPassiva()
    {
        return $this->hasOne(NeracaPassiva::class, 'performa_bisnis_id', 'id');
    }

    public function masalahKeuangan()
    {
        return $this->hasOne(MasalahKeuangan::class, 'performa_bisnis_id', 'id');
    }

    public function responden()
    {
        return $this->belongsTo(Responden::class, 'responden_id', 'id');
    }
}
