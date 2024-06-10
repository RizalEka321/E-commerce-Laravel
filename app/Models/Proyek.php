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

    protected $keyType = 'string';

    public static function generateId()
    {
        $lastProyek = Proyek::orderBy('id_proyek', 'desc')->first();

        if (!$lastProyek) {
            $lastId = 'PRY-0000000001';;
        } else {
            $lastId = (int) substr($lastProyek->id_proyek, 4) + 1;
        }

        $newId = 'PRY-' . str_pad($lastId, 10, '0', STR_PAD_LEFT);

        return $newId;
    }
}
