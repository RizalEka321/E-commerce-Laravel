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
        $pesanan1 = Pesanan::where('users_id', Auth::user()->id)
            ->where('status', 'Menunggu Pembayaran')
            ->with('detail')
            ->latest()
            ->get();

        $pesanan2 = Pesanan::where('users_id', Auth::user()->id)
            ->where('status', 'Diproses')
            ->with('detail')
            ->latest()
            ->get();

        $pesanan3 = Pesanan::where('users_id', Auth::user()->id)
            ->where('status', 'Selesai')
            ->with('detail')
            ->latest()
            ->get();

        $ongkir = 10000;
        $admin = 4000;

        return view('Pembeli.page_pesanan_saya', compact('pesanan1', 'pesanan2', 'pesanan3', 'ongkir', 'admin', 'profile'));
    }
}
