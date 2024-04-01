<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Proyek;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
    public function index()
    {
        return view('Admin.laporan');
    }

    public function cetak(Request $request)
    {
        // Validasi bulan dan tahun
        $request->validate([
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer|min:1900|max:' . date('Y'),
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $nama_bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        // Ubah format bulan menjadi huruf Indonesia
        $bulan_huruf = strtoupper($nama_bulan[$bulan]);

        // Lakukan pengambilan data Proyek berdasarkan bulan dan tahun dari kolom created_at
        $proyek = Proyek::where('status_pembayaran', 'Lunas')->whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->get();
        $pesanan = Pesanan::where('status', 'Selesai')->whereMonth('created_at', $bulan)->whereYear('created_at', $tahun)->with(['detail.produk', 'user'])->get();

        // Total Per Pesanan
        foreach ($pesanan as $pes) {
            $totalHarga = 0;
            foreach ($pes->detail as $detail) {
                $totalHarga += $detail->produk->harga * $detail->jumlah;
            }
            $pes->total_harga = $totalHarga;
        }

        // Total Omset Proyek
        $total_omset_proyek = Proyek::where('status_pembayaran', 'Lunas')
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->sum(DB::raw('jumlah * harga_satuan'));

        // Total Omset Pesanan
        $total_omset_pesanan = 0; // Inisialisasi total omset pesanan

        foreach ($pesanan as $pes) {
            $totalHarga = 0; // Inisialisasi total harga untuk setiap pesanan

            // Iterasi melalui setiap detail pesanan dan menambahkan harga produk yang telah dikalikan dengan jumlahnya
            foreach ($pes->detail as $detail) {
                $totalHarga += $detail->produk->harga * $detail->jumlah;
            }

            // Menambahkan total harga pesanan ke total omset pesanan
            $total_omset_pesanan += $totalHarga;

            // Menetapkan total harga pesanan ke atribut total_harga pada setiap pesanan
            $pes->total_harga = $totalHarga;
        }

        // Total Keseluruhan
        $total_keseluruhan = $total_omset_proyek + $total_omset_pesanan;

        $pdf = Pdf::loadView('admin.cetak_laporan', compact('bulan_huruf', 'tahun', 'proyek', 'pesanan', 'total_omset_proyek', 'total_omset_pesanan', 'total_keseluruhan'));
        return $pdf->stream('laporan.pdf');
    }
}
