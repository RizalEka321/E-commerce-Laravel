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
        $pesanan = self::latest()->first();
        if (!$pesanan) {
            $last_id = 'PSN-0000000';
        } else {
            $last_id = $pesanan->id_pesanan;
        }

        $new_number = (int) substr($last_id, -7) + 1;
        $new_id = 'PSN-' . str_pad($new_number, 7, '0', STR_PAD_LEFT);

        return $new_id;
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
