<?php

namespace App\Http\Controllers\Pembeli;

use App\Models\Pesanan;
use App\Models\Profil_Perusahaan;
use App\Http\Controllers\Controller;
use App\Models\Detail_Pesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PesananSayaController extends Controller
{
    public function page_pesanan_saya()
    {
        $profile = Profil_Perusahaan::where('id_profil_perusahaan', 'satu')->first();
        $pesanan1 = Pesanan::where('users_id', Auth::user()->id)
            ->where('status', 'Menunggu Pembayaran')
            ->with('detail')
            ->latest()
            ->get()
            ->map(function ($pesanan) {
                $total_barang = $pesanan->detail->sum('jumlah');
                $pesanan->total_barang = $total_barang;
                return $pesanan;
            });

        $pesanan2 = Pesanan::where('users_id', Auth::user()->id)
            ->where('status', 'Diproses')
            ->with('detail')
            ->latest()
            ->get()
            ->map(function ($pesanan) {
                $total_barang = $pesanan->detail->sum('jumlah');
                $pesanan->total_barang = $total_barang;
                return $pesanan;
            });

        $pesanan3 = Pesanan::where('users_id', Auth::user()->id)
            ->where('status', 'Selesai')
            ->with('detail')
            ->latest()
            ->get()
            ->map(function ($pesanan) {
                $total_barang = $pesanan->detail->sum('jumlah');
                $pesanan->total_barang = $total_barang;
                return $pesanan;
            });

        $pesanan4 = Pesanan::where('users_id', Auth::user()->id)
            ->where('status', 'Dibatalkan')
            ->with('detail')
            ->latest()
            ->get()
            ->map(function ($pesanan) {
                $total_barang = $pesanan->detail->sum('jumlah');
                $pesanan->total_barang = $total_barang;
                return $pesanan;
            });

        return view('Pembeli.page_pesanan_saya', compact('pesanan1', 'pesanan2', 'pesanan3', 'pesanan4', 'profile'));
    }

    public function detail_pesanan(Request $request)
    {
        $id = $request->input('q');
        $pesanan = Pesanan::where('id_pesanan', $id)->first();
        $detail = Detail_Pesanan::where('pesanan_id', $id)->get();
        $ongkir = 10000;
        $admin = 4000;

        return response()->json(['pesanan' => $pesanan, 'detail' => $detail, 'ongkir' => $ongkir, 'admin' => $admin]);
    }

    public function cetak(Request $request)
    {
        $id_pesanan = $request->input('id_pesanan');
        $pesanan = Pesanan::where('id_pesanan', $id_pesanan)->with('user')->first();
        $detail = Detail_Pesanan::where('pesanan_id', $id_pesanan)->get();
        $jml_barang = Detail_Pesanan::where('pesanan_id', $id_pesanan)->count();
        $ongkir = 10000;
        $admin = 4000;
        $pdf = Pdf::loadView('Pembeli.cetak_invoice', compact('pesanan', 'detail', 'jml_barang', 'ongkir', 'admin'));
        return $pdf->stream('invoice.pdf');
    }
}
