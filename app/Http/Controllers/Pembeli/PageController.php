<?php

namespace App\Http\Controllers\Pembeli;

use App\Models\Produk;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


class PageController extends Controller
{
    public function page_home()
    {
        $banner = Produk::all();
        $produk = Produk::all();
        Session::forget('slug_produk');
        return view('Pembeli.page_home', compact('banner', 'produk'));
    }

    public function page_detail_produk($slug)
    {
        $produk = Produk::all();
        $produk_detail = Produk::where('slug', $slug)->with('ukuran')->first();
        Session::put('slug_produk', $produk_detail->slug);
        return view('Pembeli.page_produk_detail', compact('produk', 'produk_detail'));
    }
}
