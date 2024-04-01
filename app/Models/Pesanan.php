<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    protected $fillable = [
        'id_pesanan',
        'user_id',
        'alamat_pengiriman',
        'no_hp',
        'metode_pengiriman',
        'metode_pembayaran',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    public function detail()
    {
        return $this->hasMany(Detail_Pesanan::class, 'pesanan_id');
    }
}
