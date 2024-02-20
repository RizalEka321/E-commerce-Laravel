<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_proyeks';
    protected $fillable = [
        'id_proyek',
        'nama_pemesan',
        'instansi',
        'no_hp',
        'alamat',
        'foto_logo',
        'foto_desain',
        'deskripsi_proyek',
        'quantity',
        'harga_satuan',
        'dp_proyek',
        'total',
        'status_pengerjaan',
        'status_pembayaran'
    ];
}
