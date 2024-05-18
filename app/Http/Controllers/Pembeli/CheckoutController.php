<?php

namespace App\Http\Controllers\Pembeli;

use App\Models\Ukuran;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use App\Models\Profil_Perusahaan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class CheckoutController extends Controller
{
    public function checkout()
    {
        $checkout = Keranjang::where('users_id', Auth::user()->id)
            ->where('status', 'Ya')
            ->with('produk')
            ->get();

        // $stokItem = DB::table('ukuran_produk')
        //     ->join('ukuran', 'ukuran_produk.ukuran_id', '=', 'ukuran.id_ukuran')
        //     ->where('ukuran_produk.produk_id', 1)
        //     ->where('ukuran.id_ukuran', 3)
        //     ->select('ukuran.*')
        //     ->first();

        // @dd($stokItem);

        // Memeriksa apakah ada data checkout
        if ($checkout->count() > 0) {
            // Menghitung total barang checkout
            $total_barang = $checkout->sum(function ($item) {
                return $item->jumlah;
            });

            // total cash
            $total_harga = $checkout->sum(function ($item) {
                return $item->produk->harga * $item->jumlah;
            });

            $ongkir = 10000;
            $admin = 4000;

            // total online delivery
            $total_with_OD = $total_harga + $ongkir + $admin;
            // total online pickup
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
        foreach ($keranjang as $item) {
            $item->status = 'Ya';
            $item->save();
        }
        return response()->json(['status' => 'TRUE']);
    }

    public function checkout_langsung(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'produk_id' => 'required',
            'jumlah' => 'required|numeric|min:1',
            'id_ukuran' => 'required',
        ], [
            'produk_id.required' => 'Produk ID wajib diisi.',
            'jumlah.required' => 'Jumlah wajib diisi.',
            'jumlah.numeric' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah tidak boleh kurang dari 1.',
            'id_ukuran.required' => 'Ukuran wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'FALSE', 'errors' => $validator->errors()]);
        } else {
            $ukuran = Ukuran::where('id_ukuran', $request->id_ukuran)->select('jenis_ukuran')->first();
            Keranjang::create([
                'users_id' => Auth::user()->id,
                'produk_id' => $request->produk_id,
                'ukuran_id' => $request->id_ukuran,
                'jumlah' => $request->jumlah,
                'ukuran' => $ukuran->jenis_ukuran,
                'status' => 'Ya'
            ]);
        }

        return response()->json(['status' => 'TRUE']);
    }
}
