<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil_Perusahaan extends Model
{
    use HasFactory;
    protected $table = 'profil_perusahaan';
    protected $primaryKey = 'id_profil_perusahaan';
    protected $fillable = [
        'id_profil_perusahaan',
        'deskripsi',
        'alamat',
        'foto',
    ];
}
