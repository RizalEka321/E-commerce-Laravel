<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Proyek;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF as Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LaporanController extends Controller
{
    public function index()
    {
        return view('Admin.laporan');
    }

    public function cetak(Request $request)
    {
        // Validasi bulan dan tahun menggunakan Validator
        $validator = Validator::make($request->all(), [
            'bulan_tahun' => 'required|date_format:Y-m'
        ], [
            'bulan_tahun.required' => 'Pilih periode waktu yang Anda inginkan'
        ]);

        // Jika validasi gagal, kembalikan dengan pesan kesalahan
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $bulan_tahun = $request->input('bulan_tahun');
            $date = Carbon::createFromFormat('Y-m', $bulan_tahun);
            $bulan = $date->format('m');
            $tahun = $date->format('Y');

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
            $bulan_huruf = strtoupper($nama_bulan[intval($bulan)]);

            // Lakukan pengambilan data Proyek berdasarkan bulan dan tahun dari kolom created_at
            $proyek = Proyek::where('status_pembayaran', 'Lunas')
                ->whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun)
                ->get();

            $pesanan = Pesanan::where('status', 'Selesai')
                ->whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun)
                ->with(['detail.produk', 'user'])
                ->get();

            // Total Omset Proyek
            $total_omset_proyek = Proyek::where('status_pembayaran', 'Lunas')
                ->whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun)
                ->sum(DB::raw('jumlah * harga_satuan'));

            // Total Omset Pesanan
            $total_omset_pesanan = Pesanan::where('status', 'Selesai')
                ->whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun)
                ->sum('total');

            // Total Keseluruhan
            $total_keseluruhan = $total_omset_proyek + $total_omset_pesanan;

            // Periksa apakah ada laporan yang ditemukan
            if ($proyek->isEmpty() && $pesanan->isEmpty()) {
                if ($request->expectsJson()) {
                    return response()->json(['status' => 'FALSE', 'error' => 'Periode waktu yang Anda pilih belum memiliki data penjualan untuk dilaporkan.']);
                }
            } else {
                if ($request->expectsJson()) {
                    return response()->json([
                        'status' => 'TRUE',
                        'bulan_huruf' => $bulan_huruf,
                        'tahun' => $tahun,
                        'proyek' => $proyek,
                        'pesanan' => $pesanan,
                        'total_omset_proyek' => $total_omset_proyek,
                        'total_omset_pesanan' => $total_omset_pesanan,
                        'total_keseluruhan' => $total_keseluruhan,
                    ]);
                } else {
                    // Return JSON response
                    $pdf = Pdf::loadView('admin.cetak_laporan', compact('bulan_huruf', 'tahun', 'proyek', 'pesanan', 'total_omset_proyek', 'total_omset_pesanan', 'total_keseluruhan'));
                    return $pdf->stream('laporan.pdf');
                }
            }
        }
    }
}
