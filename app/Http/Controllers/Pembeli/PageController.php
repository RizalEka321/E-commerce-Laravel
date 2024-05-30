<?php

namespace App\Http\Controllers\Pembeli;

use App\Models\Produk;
use App\Models\Kontak_Perusahaan;
use App\Models\Profil_Perusahaan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


class PageController extends Controller
{
    public function page_home()
    {
        $produk = Produk::select('slug', 'judul', 'foto', 'harga')->get();
        $profile = Profil_Perusahaan::where('id_profil_perusahaan', 'satu')->first();
        $kontak = Kontak_Perusahaan::where('id_kontak_perusahaan', 'satu')->first();
        $nomor_wa = $kontak->whatsapp;
        $nomor_wa = '+62' . substr($nomor_wa, 1);
        Session::forget('slug_produk');
        return view('Pembeli.page_home', compact('profile', 'produk', 'kontak', 'nomor_wa'));
    }

    public function page_detail_produk($slug)
    {
        $produk = Produk::select('slug', 'judul', 'foto', 'harga')->get();
        $profile = Profil_Perusahaan::where('id_profil_perusahaan', 'satu')->first();
        $produk_detail = Produk::where('slug', $slug)->with('ukuran')->first();
        Session::put('slug_produk', $produk_detail->slug);
        return view('Pembeli.page_produk_detail', compact('produk', 'profile', 'produk_detail'));
    }
}
