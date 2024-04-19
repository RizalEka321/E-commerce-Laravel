<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;
    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';
    protected $fillable = [
        'id_keranjang',
        'users_id',
        'produk_id',
        'jumlah',
        'ukuran',
        'status'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
