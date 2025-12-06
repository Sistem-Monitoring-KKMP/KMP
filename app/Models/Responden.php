<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Responden extends Model
{
    protected $table = 'responden';
    protected $primaryKey = 'id';
    protected $fillable = ['responden','kontak_responden','enumerator','kontak_enumerator'];

    public function performaBisnis()
    {
        return $this->hasMany(PerformaBisnis::class, 'responden_id', 'id');
    }

    public function performaOrganisasi()
    {
        return $this->hasMany(PerformaOrganisasi::class, 'responden_id', 'id');
    }
}
