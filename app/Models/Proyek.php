<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    use HasFactory;
    protected $table = 'proyek';
    protected $primaryKey = 'id_proyek';
    protected $fillable = [
        'id_proyek',
        'nama_pemesan',
        'instansi',
        'no_hp',
        'alamat',
        'item',
        'foto_logo',
        'foto_desain',
        'deskripsi_proyek',
        'jumlah',
        'harga_satuan',
        'nominal_dp',
        'deadline',
        'status_pengerjaan',
        'status_pembayaran'
    ];

    public static function generateId()
    {
        $latestOrder = self::latest()->first();
        if (!$latestOrder) {
            $lastId = 'PRY-0000000001';
        } else {
            $lastId = $latestOrder->id_pesanan;
        }

        $lastIdNumber = (int) substr($lastId, -10) + 1;
        $newId = 'PRY-' . str_pad($lastIdNumber, 10, '0', STR_PAD_LEFT);

        return $newId;
    }
}
