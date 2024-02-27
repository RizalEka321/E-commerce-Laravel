<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_Pesanan extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_details';
    protected $table = 'detail_pesanans';

    public function katalog()
    {
        return $this->belongsTo(Katalog::class, 'katalogs_id');
    }

    public function pesanan()
    {
        return $this->belongsTo(Katalog::class, 'pesanans_id');
    }
}
