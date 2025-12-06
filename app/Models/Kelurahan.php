<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $table = 'kelurahan';
    protected $primaryKey = 'id';
    protected $fillable = ['nama'];

    public function lokasi()
    {
        return $this->hasMany(Lokasi::class, 'kelurahan_id', 'id');
    }
}
