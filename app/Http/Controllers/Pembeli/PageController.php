<?php

namespace App\Http\Controllers\Pembeli;

use App\Models\Produk;
use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use Illuminate\Http\Request;


class PageController extends Controller
{
    public function page_home()
    {
        $banner = Produk::all();
        $produk = Produk::all();
        return view('Pembeli.page_home', compact('banner', 'produk'));
    }

    public function page_detail_produk($slug)
    {
        $produk = Produk::where('slug', $slug)->first();
        return view('Pembeli.page_produk_detail', compact('produk'));
    }

    public function page_keranjang()
    {
        $keranjang = Keranjang::with('produk')->get();
        return view('Pembeli.page_keranjang', compact('keranjang'));
    }

    public function update_keranjang(Request $request)
    {
        $keranjang = Keranjang::findOrFail($request->id);
        $keranjang->update(['jumlah' => $request->quantity]);
        return response()->json(['success' => true]);
    }

    public function remove_keranjang(Request $request)
    {
        $id = $request->input('q');
        $keranjang = Keranjang::find($id);
        $keranjang->delete();

        return response()->json(['status' => true]);
    }

    public function total_keranjang()
    {
        $total = '20000';
        return response()->json(['total' => $total]);
    }
}
