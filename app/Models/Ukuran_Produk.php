<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ukuran_Produk extends Model
{
    use HasFactory;

    protected $table = 'ukuran_produk';
    protected $primaryKey = 'id_ukuran_produk';
    protected $fillable = [
        'id_ukuran_produk',
        'produk_id',
        'ukuran_id',
    ];
}
