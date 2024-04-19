<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontak_Perusahaan extends Model
{
    use HasFactory;
    protected $table = 'kontak_perusahaan';
    protected $primaryKey = 'id_kontak_perusahaan';
    protected $fillable = [
        'id_kontak_perusahaan',
        'instagram',
        'whastapp',
        'email',
        'facebook',
    ];
}
