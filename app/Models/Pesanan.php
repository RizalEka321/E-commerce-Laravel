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
        $latestOrder = self::latest()->first();
        if (!$latestOrder) {
            $lastId = 'PSN-0000000001';
        } else {
            $lastId = $latestOrder->id_pesanan;
        }

        $lastIdNumber = (int) substr($lastId, -10) + 1;
        $newId = 'PSN-' . str_pad($lastIdNumber, 10, '0', STR_PAD_LEFT);

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
