<?php

namespace App\Http\Controllers\Pembeli;

use App\Models\Produk;
use Illuminate\Http\Request;
use App\Models\Kontak_Perusahaan;
use App\Models\Profil_Perusahaan;
use App\Http\Controllers\Controller;
use App\Mail\Saranemail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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

    public function saran(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'email' => 'required|email|regex:/^[A-Za-z0-9._%+-]{8,16}@gmail\.com$/',
            'pesan' => 'required'
        ], [
            'nama.required' => 'Input Nama tidak boleh kosong',
            'email.required' => 'Input Email tidak boleh kosong.',
            'email.email' => 'Email yang anda masukan tidak valid.',
            'email.regex' => 'Email harus memiliki panjang antara 8 dan 16 karakter.',
            'pesan.required' => 'Input Saran tidak boleh kosong.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'FALSE', 'errors' => $validator->errors()]);
        } else {
            $nama = $request->nama;
            $email = $request->email;
            $pesan = $request->pesan;
            Mail::to('hahaharizal6@gmail.com')->send(new Saranemail($nama, $email, $pesan));
            return response()->json(['status' => TRUE]);
        }
    }
}
