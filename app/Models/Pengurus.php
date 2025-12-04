<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengurus extends Model
{
    /** @use HasFactory<\Database\Factories\PengurusFactory> */
    use HasFactory;

    protected $fillable = [
        'koperasi_id',
        'ketua',
        'wakil_bu',
        'wakil_ba',
        'sekretaris',
        'bendahara',
    ];

    public function koperasi()
    {
        return $this->belongsTo(Koperasi::class);
    }
}
