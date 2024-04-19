<?php

namespace App\Http\Controllers\Pembeli;

use App\Models\Pesanan;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Detail_Pesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PemesananController extends Controller
{
    public function pemesanan_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'alamat_pengiriman' => 'required',
            'no_hp' => 'required',
            'metode_pengiriman' => 'required',
            'metode_pembayaran' => 'required',
        ], [
            'alamat_pengiriman.required' => 'Alamat pengiriman wajib diisi.',
            'no_hp.required' => 'Nomor telepon wajib diisi.',
            'metode_pengiriman.required' => 'Metode pengiriman wajib dipilih.',
            'metode_pembayaran.required' => 'Metode pembayaran wajib dipilih.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $keranjang = Keranjang::where('users_id', Auth::user()->id)->where('status', 'Ya')->with('produk')->get();

        $totalHarga = 0;

        // Menghitung total harga
        foreach ($keranjang as $item) {
            $totalHarga += $item->jumlah * $item->produk->harga;
        }

        $pesanan = [
            'users_id' => Auth::user()->id,
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'no_hp' => $request->no_hp,
            'metode_pengiriman' => $request->metode_pengiriman,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status' => 'Menunggu Pembayaran',
            'total' => $totalHarga
        ];

        if ($request->metode_pembayaran == 'Transfer') {
            // Set your Midtrans configuration here
            \Midtrans\Config::$serverKey = 'SB-Mid-server-hP9DFpt7GvdZqHypfZ0lxc0_';
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => rand(),
                    'gross_amount' => 10000,
                ],
                'customer_details' => [
                    'first_name' => 'budi',
                    'last_name' => 'pratama',
                    'email' => 'budi.pra@example.com',
                    'phone' => '08111222333',
                ],
            ];
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $pesanan['snaptoken'] = $snapToken;
            $akhir = Pesanan::create($pesanan);
            // Memasukkan pada detail pesanan
            foreach ($keranjang as $item) {
                Detail_Pesanan::create([
                    'pesanan_id' => $akhir->id_pesanan,
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
            $akhir = Pesanan::create($pesanan);
            // Memasukkan pada detail pesanan
            foreach ($keranjang as $item) {
                Detail_Pesanan::create([
                    'pesanan_id' => $akhir->id_pesanan,
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
