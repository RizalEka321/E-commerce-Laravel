<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $fillable = [
        'id_produk',
        'judul',
        'slug',
        'ukuran',
        'deskripsi',
        'harga',
        'foto'
    ];

    protected $keyType = 'string';

    public static function generateId()
    {
        $lastProduk = Produk::orderBy('id_produk', 'desc')->first();

        if (!$lastProduk) {
            $lastId = 1;
        } else {
            $lastId = (int) substr($lastProduk->id_produk, 4) + 1;
        }
        $newId = 'PRD-' . str_pad($lastId, 10, '0', STR_PAD_LEFT);

        return $newId;
    }

    public function detail_pesanan()
    {
        return $this->hasMany(Detail_Pesanan::class);
    }
    public function keranjang()
    {
        return $this->hasMany(Keranjang::class);
    }
    public function ukuran()
    {
        return $this->belongsToMany(Ukuran::class, 'ukuran_produk', 'produk_id', 'ukuran_id')->withTimestamps();
    }
}
