<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_Pesanan extends Model
{
    use HasFactory;
    protected $table = 'detail_pesanan';
    protected $primaryKey = 'id_detail';

    public function produk()
    {
        return $this->belongsTo(produk::class, 'produk_id');
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }
}
