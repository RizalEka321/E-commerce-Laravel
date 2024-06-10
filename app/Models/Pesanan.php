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
        'users_id',
        'alamat_pengiriman',
        'no_hp',
        'metode_pengiriman',
        'metode_pembayaran',
        'status',
        'total',
        'snaptoken'
    ];
    protected $keyType = 'string';

    public static function generateId()
    {
        $lastPesanan = Pesanan::orderBy('id_pesanan', 'desc')->first();

        if (!$lastPesanan) {
            $lastId = 'PSN-000000000001';
        } else {
            $lastId = (int) substr($lastPesanan->id_pesanan, 4) + 1;
        }

        $lastId = (int) substr($lastId, -12) + 1;
        $newId = 'PSN-' . str_pad($lastId, 12, '0', STR_PAD_LEFT);

        return $newId;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    public function detail()
    {
        return $this->hasMany(Detail_Pesanan::class, 'pesanan_id');
    }
}
