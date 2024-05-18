<?php

namespace App\Http\Controllers\Pembeli;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Produk;
use App\Models\Ukuran;
use App\Models\Pesanan;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use App\Models\Detail_Pesanan;
use App\Models\Profil_Perusahaan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PembayaranController extends Controller
{
    public function pembayaran_cash()
    {
        $profile = Profil_Perusahaan::where('id_profil_perusahaan', 'satu')->first();
        return view('Pembeli.page_pembayaran_cash', compact('profile'));
    }
    public function pembayaran_online($id)
    {
        $profile = Profil_Perusahaan::where('id_profil_perusahaan', 'satu')->first();
        $pesanan = Pesanan::where('id_pesanan', $id)->with('detail')->first();
        return view('Pembeli.page_pembayaran_online', compact('pesanan', 'profile'));
    }

    public function pembayaran_store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'metode_pembayaran' => 'required',
        ], [
            'metode_pembayaran.required' => 'Metode pembayaran wajib dipilih.',
        ]);

        // Kondisi untuk memvalidasi 'metode_pengiriman' hanya jika 'metode_pembayaran' adalah 'Transfer'
        $validator->sometimes('metode_pengiriman', 'required', function ($input) {
            return $input->metode_pembayaran == 'Transfer';
        });

        $validator->setCustomMessages([
            'metode_pengiriman.required' => 'Metode pengiriman wajib dipilih.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        // Ambil keranjang pengguna
        $keranjang = Keranjang::where('users_id', Auth::user()->id)
            ->where('status', 'Ya')
            ->with('produk')
            ->get();

        // Hitung total harga
        $total_harga = $keranjang->sum(function ($item) {
            return $item->jumlah * $item->produk->harga;
        });

        // ID pesanan unik
        $id_pesanan = Pesanan::generateID();
        $biaya_admin = 4000;
        $biaya_ongkir = 10000;

        // Inisialisasi pesanan
        $pesanan = [
            'id_pesanan' => $id_pesanan,
            'users_id' => Auth::user()->id,
            'metode_pembayaran' => $request->metode_pembayaran,
            'alamat_pengiriman' => Auth::user()->alamat,
            'no_hp' => Auth::user()->no_hp,
            'status' => 'Menunggu Pembayaran',
        ];

        if ($request->metode_pembayaran == 'Transfer') {
            // Konfigurasi Midtrans
            Config::$serverKey    = config('services.midtrans.serverKey');
            Config::$isProduction = config('services.midtrans.isProduction');
            Config::$isSanitized  = config('services.midtrans.isSanitized');
            Config::$is3ds        = config('services.midtrans.is3ds');

            // Hitung total keseluruhan
            $total_keseluruhan = $total_harga;
            if ($request->metode_pembayaran == 'Transfer' && $request->metode_pengiriman == 'Pickup') {
                $total_keseluruhan += $biaya_admin;
            } else {
                $total_keseluruhan += $biaya_ongkir + $biaya_admin;
            }

            // Set total dan metode pengiriman di pesanan
            $pesanan['metode_pengiriman'] = $request->metode_pengiriman;
            $pesanan['total'] = $total_keseluruhan;

            // Buat transaksi di Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $id_pesanan,
                    'gross_amount' => $total_keseluruhan
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->nama_lengkap,
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->no_hp,
                ],
            ];
            $snapToken = Snap::getSnapToken($params);
            $pesanan['snaptoken'] = $snapToken;

            // Simpan pesanan dan detail pesanan
            Pesanan::create($pesanan);
        } else {
            // Set total dan metode pengiriman untuk pembayaran non-transfer
            $pesanan['metode_pengiriman'] = 'Pickup';
            $pesanan['total'] = $total_harga;

            // Simpan pesanan
            Pesanan::create($pesanan);
        }

        // Simpan detail pesanan
        foreach ($keranjang as $item) {
            Detail_Pesanan::create([
                'pesanan_id' => $id_pesanan,
                'produk_id' => $item->produk->id_produk,
                'jumlah' => $item->jumlah,
                'ukuran' => $item->ukuran,
            ]);

            // Kurangi stok di tabel pivot
            $stokItem = DB::table('ukuran_produk')
                ->join('ukuran', 'ukuran_produk.ukuran_id', '=', 'ukuran.id_ukuran')
                ->where('ukuran_produk.produk_id', $item->produk->id_produk)
                ->where('ukuran.id_ukuran', $item->ukuran_id)
                ->select('ukuran.*')
                ->first();

            if ($stokItem->stok > $item->jumlah) {
                $newStok = $stokItem->stok - $item->jumlah;
                $ukuran = Ukuran::where('id_ukuran', $stokItem->id_ukuran)->first();
                $ukuran->stok = $newStok;
                $ukuran->save();
            }
        }

        // Hapus data keranjang
        Keranjang::where('users_id', Auth::user()->id)->where('status', 'Ya')->delete();

        // Redirect berdasarkan metode pembayaran
        if ($request->metode_pembayaran == 'Transfer') {
            return response()->json(['status' => TRUE, 'redirect' => '/pembayaran-online/' . $id_pesanan]);
        } else {
            return response()->json(['status' => TRUE, 'redirect' => '/pembayaran-cash']);
        }
    }

    public function pembayaran_out()
    {
        $keranjang = Keranjang::where('users_id', Auth::user()->id)->where('status', 'Ya')->with('produk')->get();

        // Menghapus data keranjang
        foreach ($keranjang as $item) {
            $item->delete();
        }
        return response()->json(['status' => true]);
    }

    public function pembayaran(Request $request)
    {
        $serverKey = config('services.midtrans.serverKey');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture') {
                $pesanan = Pesanan::where('id_pesanan', $request->order_id)->first();
                $pesanan->update([
                    'status' => 'Diproses',
                ]);
            }
        }
    }
}
