<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    /** @use HasFactory<\Database\Factories\KelurahanFactory> */
    use HasFactory;

    protected $fillable = ['nama'];

    public function lokasi()
    {
        return $this->hasMany(Lokasi::class);
    }
}
