<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LatarBelakang extends Model
{
    protected $table = 'latar_belakang';
    protected $primaryKey = 'id';
    protected $fillable = ['pengurus_id','latarbelakang'];

    public function pengurus()
    {
        return $this->belongsTo(Pengurus::class, 'pengurus_id', 'id');
    }
}
