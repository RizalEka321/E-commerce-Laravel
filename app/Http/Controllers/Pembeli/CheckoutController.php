<?php

namespace App\Http\Controllers\Pembeli;

use App\Models\Produk;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class CheckoutController extends Controller
{
    public function checkout()
    {
        $checkout = Keranjang::where('users_id', Auth::user()->id)
            ->where('status', 'Ya')
            ->with('produk')
            ->get();

        // Menghitung total harga checkout
        $total_harga = $checkout->sum(function ($item) {
            return $item->produk->harga * $item->jumlah;
        });

        return view('Pembeli.page_checkout', compact('checkout', 'total_harga'));
    }

    public function checkout_keranjang(Request $request)
    {
        $id = $request->input('q');
        $keranjang = Keranjang::where('users_id', $id)->where('status', 'Tidak')->get();
        foreach ($keranjang as $item) {
            $item->status = 'Ya';
            $item->save();
        }
        return response()->json(['status' => true]);
    }
    public function checkout_langsung(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'produk_id' => 'required',
            'jumlah' => 'required',
            'ukuran' => 'required',
        ], [
            'judul.required' => 'Nama wajib diisi.',
            'judul.unique' => 'Nama ini sudah digunakan.',
            'judul.min' => 'Nama minimal harus terdiri dari 2 karakter.',
            'judul.max' => 'Nama maksimal hanya boleh 100 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            Keranjang::create([
                'users_id' => Auth::user()->id,
                'produk_id' => $request->produk_id,
                'jumlah' => $request->jumlah,
                'ukuran' => $request->ukuran,
                'status' => 'Ya'
            ]);
        }

        return response()->json(['status' => true]);
    }
}
