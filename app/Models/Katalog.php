<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Katalog extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_katalogs';
    protected $fillable = [
        'id_katalogs',
        'judul',
        'slug',
        'stok',
        'deskripsi',
        'harga',
        'foto'
    ];

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }
}
