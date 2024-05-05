<?php

namespace App\Http\Controllers\Pembeli;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Pesanan;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use App\Models\Detail_Pesanan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PemesananController extends Controller
{
    public function pemesanan_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'metode_pengiriman' => 'required',
            'metode_pembayaran' => 'required',
        ], [
            'metode_pengiriman.required' => 'Metode pengiriman wajib dipilih.',
            'metode_pembayaran.required' => 'Metode pembayaran wajib dipilih.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {

            $keranjang = Keranjang::where('users_id', Auth::user()->id)->where('status', 'Ya')->with('produk')->get();

            $totalHarga = 0;

            // Menghitung total harga
            foreach ($keranjang as $item) {
                $totalHarga += $item->jumlah * $item->produk->harga;
            }

            $idPesanan = Pesanan::generateID();

            $pesanan = [
                'id_pesanan' => $idPesanan,
                'users_id' => Auth::user()->id,
                'metode_pengiriman' => $request->metode_pengiriman,
                'metode_pembayaran' => $request->metode_pembayaran,
                'alamat_pengiriman' => Auth::user()->alamat,
                'no_hp' => Auth::user()->no_hp,
                'status' => 'Menunggu Pembayaran',
                'total' => $totalHarga
            ];

            if ($request->metode_pembayaran == 'Transfer') {
                // Set your Midtrans configuration here
                Config::$serverKey    = config('services.midtrans.serverKey');
                Config::$isProduction = config('services.midtrans.isProduction');
                Config::$isSanitized  = config('services.midtrans.isSanitized');
                Config::$is3ds        = config('services.midtrans.is3ds');

                $params = [
                    'transaction_details' => [
                        'order_id' => $idPesanan,
                        'gross_amount' => $totalHarga
                    ],
                    'customer_details' => [
                        'first_name' => Auth::user()->nama_lengkap,
                        'email' => Auth::user()->email,
                        'phone' => Auth::user()->no_hp,
                    ],
                ];
                $snapToken = Snap::getSnapToken($params);
                $pesanan['snaptoken'] = $snapToken;
                Pesanan::create($pesanan);
                // Memasukkan pada detail pesanan
                foreach ($keranjang as $item) {
                    Detail_Pesanan::create([
                        'pesanan_id' => $idPesanan,
                        'produk_id' => $item->produk->id_produk,
                        'jumlah' => $item->jumlah,
                        'ukuran' => $item->ukuran,
                    ]);
                }
                // Menghapus data keranjang
                foreach ($keranjang as $item) {
                    $item->delete();
                }
                return view('Pembeli.page_pemesanan_transfer', compact('snapToken'));
            } else {
                Pesanan::create($pesanan);
                // Memasukkan pada detail pesanan
                foreach ($keranjang as $item) {
                    Detail_Pesanan::create([
                        'pesanan_id' => $idPesanan,
                        'produk_id' => $item->produk->id_produk,
                        'jumlah' => $item->jumlah,
                        'ukuran' => $item->ukuran,
                    ]);
                }
                // Menghapus data keranjang
                foreach ($keranjang as $item) {
                    $item->delete();
                }
                return view('Pembeli.page_pemesanan_cash');
            }
        }
    }

    public function pemesanan_out()
    {
        $keranjang = Keranjang::where('users_id', Auth::user()->id)->where('status', 'Ya')->with('produk')->get();

        // Menghapus data keranjang
        foreach ($keranjang as $item) {
            $item->delete();
        }
        return response()->json(['status' => true]);
    }
}
