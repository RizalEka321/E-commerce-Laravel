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
        $latestOrder = self::latest()->first();
        if (!$latestOrder) {
            $lastId = 'PRD-0000000001';
        } else {
            $lastId = $latestOrder->id_pesanan;
        }

        $lastIdNumber = (int) substr($lastId, -10) + 1;
        $newId = 'PRD-' . str_pad($lastIdNumber, 10, '0', STR_PAD_LEFT);

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
