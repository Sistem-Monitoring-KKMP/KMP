<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    protected $table = 'pelatihan';
    protected $primaryKey = 'id';
    protected $fillable = ['performa_organisasi_id','pelatihan','akumulasi'];
    protected $casts = ['akumulasi'=>'integer'];

    public function performaOrganisasi()
    {
        return $this->belongsTo(PerformaOrganisasi::class, 'performa_organisasi_id', 'id');
    }
}
