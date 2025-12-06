<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';
    protected $primaryKey = 'id';
    protected $fillable = ['nama'];

    public function lokasi()
    {
        return $this->hasMany(Lokasi::class, 'kecamatan_id', 'id');
    }
}
