<?php

namespace App\Http\Controllers\Pembeli;

use Midtrans\Snap;
use App\Models\User;
use Midtrans\Config;
use App\Models\Ukuran;
use App\Models\Pesanan;
use App\Models\Keranjang;
use App\Mail\PesananDipesan;
use Illuminate\Http\Request;
use App\Mail\Adminpesananmail;
use App\Models\Detail_Pesanan;
use App\Models\Kontak_Perusahaan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;


class CheckoutController extends Controller
{
    public function checkout()
    {
        $checkout = Keranjang::where('users_id', Auth::user()->id)
            ->where('status', 'Ya')
            ->with('produk')
            ->get();

        if ($checkout->count() > 0) {
            $total_barang = $checkout->sum(function ($item) {
                return $item->jumlah;
            });

            $total_harga = $checkout->sum(function ($item) {
                return $item->produk->harga * $item->jumlah;
            });

            $ongkir = 10000;
            $admin = 4000;

            $total_with_OD = $total_harga + $ongkir + $admin;
            $total_with_OP = $total_harga + $admin;

            return view('Pembeli.page_checkout', compact('checkout', 'total_barang', 'total_harga', 'ongkir', 'admin', 'total_with_OD', 'total_with_OP'));
        } else {
            return back();
        }
    }

    public function checkout_keranjang(Request $request)
    {
        $id = $request->input('q');
        $keranjang = Keranjang::where('users_id', $id)->where('status', 'Tidak')->get();

        if ($keranjang->isEmpty()) {
            return response()->json(['status' => false, 'error' => 'Keranjang kosong atau tidak ditemukan']);
        } else {
            foreach ($keranjang as $item) {
                $ukuran = Ukuran::find($item->ukuran_id);
                if ($item->jumlah > $ukuran->stok) {
                    return response()->json(['status' => false, 'error' => 'Stok tidak cukup untuk produk ' . $item->produk->judul]);
                } else {
                    $item->status = 'Ya';
                    $item->save();
                }
            }
            return response()->json(['status' => 'TRUE']);
        }
    }

    public function checkout_langsung(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'produk_id' => 'required',
            'jumlah' => 'required|numeric|min:1|max:100',
            'id_ukuran' => 'required',
        ], [
            'produk_id.required' => 'Produk ID wajib diisi.',
            'jumlah.required' => 'Jumlah wajib diisi.',
            'jumlah.numeric' => 'Jumlah yang anda masukan tidak valid, harus berupa angka.',
            'jumlah.max' => 'Jumlah yang anda masukan lebih dari ketentuan maksimal. Hubungi admin melalui kontak tertera.',
            'jumlah.min' => 'Jumlah yang anda masukan tidak bisa kurang dari sama dengan 0.',
            'id_ukuran.required' => 'Ukuran wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {
            $ukuran = Ukuran::where('id_ukuran', $request->id_ukuran)->select('jenis_ukuran', 'stok')->first();
            if ($ukuran->stok == 0) {
                return response()->json(['status' => false, 'error' => 'Stok Ukuran' + $ukuran->stok + 'Habis']);
            } elseif ($request->jumlah > $ukuran->stok) {
                return response()->json(['status' => false, 'error' => 'Jumlah yang anda masukkan melebihi stok tersedia untuk ukuran ' . $ukuran->jenis_ukuran]);
            } else {
                Keranjang::create([
                    'users_id' => Auth::user()->id,
                    'produk_id' => $request->produk_id,
                    'ukuran_id' => $request->id_ukuran,
                    'jumlah' => $request->jumlah,
                    'ukuran' => $ukuran->jenis_ukuran,
                    'status' => 'Ya'
                ]);
            }
            return response()->json(['status' => true]);
        }
    }

    public function checkout_batalkan()
    {
        $keranjang = Keranjang::where('users_id', Auth::user()->id)->where('status', 'Ya')->with('produk')->get();

        foreach ($keranjang as $item) {
            $item->delete();
        }

        return response()->json(['status' => true]);
    }

    public function checkout_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'metode_pembayaran' => 'required',
        ], [
            'metode_pembayaran.required' => 'Metode pembayaran wajib dipilih.',
        ]);

        $validator->sometimes('metode_pengiriman', 'required', function ($input) {
            return $input->metode_pembayaran == 'Transfer';
        });

        $validator->setCustomMessages([
            'metode_pengiriman.required' => 'Metode pengiriman wajib dipilih.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {
            $keranjang = Keranjang::where('users_id', Auth::user()->id)
                ->where('status', 'Ya')
                ->with('produk')
                ->get();

            $total_harga = $keranjang->sum(function ($item) {
                return $item->jumlah * $item->produk->harga;
            });

            $id_pesanan = Pesanan::generateID();
            $biaya_admin = 4000;
            $biaya_ongkir = 10000;
            $id = Crypt::encrypt($id_pesanan);

            $pesanan = [
                'id_pesanan' => $id_pesanan,
                'users_id' => Auth::user()->id,
                'metode_pembayaran' => $request->metode_pembayaran,
                'alamat_pengiriman' => Auth::user()->alamat,
                'no_hp' => Auth::user()->no_hp,
                'status' => 'Menunggu Pembayaran',
            ];

            if ($request->metode_pembayaran == 'Transfer') {
                Config::$serverKey    = config('services.midtrans.serverKey');
                Config::$isProduction = config('services.midtrans.isProduction');
                Config::$isSanitized  = config('services.midtrans.isSanitized');
                Config::$is3ds        = config('services.midtrans.is3ds');

                $total_keseluruhan = $total_harga;
                if ($request->metode_pembayaran == 'Transfer' && $request->metode_pengiriman == 'Pickup') {
                    $total_keseluruhan += $biaya_admin;
                } else {
                    $total_keseluruhan += $biaya_ongkir + $biaya_admin;
                }

                $pesanan['metode_pengiriman'] = $request->metode_pengiriman;
                $pesanan['total'] = $total_keseluruhan;

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

                Pesanan::create($pesanan);

                foreach ($keranjang as $item) {
                    Detail_Pesanan::create([
                        'pesanan_id' => $id_pesanan,
                        'produk_id' => $item->produk->id_produk,
                        'foto' => $item->produk->foto,
                        'produk' => $item->produk->judul,
                        'harga' => $item->produk->harga,
                        'jumlah' => $item->jumlah,
                        'ukuran' => $item->ukuran,
                    ]);
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

                Keranjang::where('users_id', Auth::user()->id)->where('status', 'Ya')->delete();
                return response()->json(['status' => true, 'redirect' => '/pembayaran-transfer/' . $id]);
            } else {
                $pesanan['metode_pengiriman'] = 'Pickup';
                $pesanan['total'] = $total_harga;

                Pesanan::create($pesanan);

                foreach ($keranjang as $item) {
                    Detail_Pesanan::create([
                        'pesanan_id' => $id_pesanan,
                        'produk_id' => $item->produk->id_produk,
                        'foto' => $item->produk->foto,
                        'produk' => $item->produk->judul,
                        'harga' => $item->produk->harga,
                        'jumlah' => $item->jumlah,
                        'ukuran' => $item->ukuran,
                    ]);

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

                Keranjang::where('users_id', Auth::user()->id)->where('status', 'Ya')->delete();

                $perusahaan = Kontak_Perusahaan::where('id_kontak_perusahaan', 'satu')->select('email')->first();
                Mail::to(Auth::user()->email)->send(new PesananDipesan($id_pesanan));
                Mail::to($perusahaan->email)->send(new Adminpesananmail($id_pesanan));
                return response()->json(['status' => true, 'redirect' => '/pembayaran-cash/' . $id]);
            }
        }
    }
    public function update_alamat(Request $request)
    {
        $id = $request->query('q');
        $user = User::find($id);

        $validator = Validator::make($request->all(), [
            'alamat' => 'required',
        ], [
            'alamat.required' => 'Alamat wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {
            $user->alamat = $request->alamat;
            $user->save();

            return response()->json(['status' => true, 'alamat' => $user->alamat]);
        }
    }
    public function update_nohp(Request $request)
    {
        $id = $request->query('q');
        $user = User::find($id);

        $validator = Validator::make($request->all(), [
            'no_hp' => 'required',
        ], [
            'no_hp.required' => 'Nomor HP wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {
            $user->no_hp = $request->no_hp;
            $user->save();

            return response()->json(['status' => true, 'nohp' => $user->no_hp]);
        }
    }
}
