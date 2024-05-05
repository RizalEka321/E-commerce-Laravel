<?php

namespace App\Http\Controllers\Pembeli;

use App\Models\Pesanan;
use App\Models\Profil_Perusahaan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PesananSayaController extends Controller
{
    public function page_pesanan_saya()
    {
        $profile = Profil_Perusahaan::where('id_profil_perusahaan', 'satu')->first();
        $pesanan = Pesanan::where('users_id', Auth::user()->id)->with('detail')->get();
        return view('Pembeli.page_pesanan_saya', compact('pesanan', 'profile'));
    }
}
