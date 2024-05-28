<?php

namespace App\Http\Controllers\Admin;

use App\Models\Produk;
use App\Models\Proyek;
use App\Models\Pesanan;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $produk = Produk::count();
        $pesanan = Pesanan::count();
        $proyek = Proyek::count();
        return view('Admin.dashboard', compact('produk', 'pesanan', 'proyek'));
    }
}
