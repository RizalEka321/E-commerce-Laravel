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
}
