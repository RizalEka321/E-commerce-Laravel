<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class PesananSayaController extends Controller
{
    public function page_pesanan_saya()
    {
        $pesanan = Pesanan::where('users_id', Auth::user()->id)->with('detail')->get();
        return view('Pembeli.page_pesanan_saya', compact('pesanan'));
    }
}
