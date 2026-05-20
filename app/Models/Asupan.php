<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asupan extends Model
{
    protected $table = 'asupan';

    protected $fillable = [
        'user_id',
        'nama',
        'kadar_gula',
        'kadar_kalori',
        'tanggal_konsumsi',
        'waktu_konsumsi',
        'catatan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
