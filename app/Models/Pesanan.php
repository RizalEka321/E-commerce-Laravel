<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_pesanans';
    protected $fillable = [
        'id_proyek',
        'status'
    ];

    public function katalog()
    {
        return $this->belongsTo(Katalog::class, 'katalogs_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
