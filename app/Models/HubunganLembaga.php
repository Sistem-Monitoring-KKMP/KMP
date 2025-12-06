<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HubunganLembaga extends Model
{
    protected $table = 'hubungan_lembaga';
    protected $primaryKey = 'id';
    protected $fillable = ['performa_bisnis_id','lembaga','kemudahan','intensitas','dampak'];
    protected $casts = [
        'kemudahan' => 'integer',
        'intensitas' => 'integer',
        'dampak' => 'integer'
    ];

    public function performaBisnis()
    {
        return $this->belongsTo(PerformaBisnis::class, 'performa_bisnis_id', 'id');
    }
}
