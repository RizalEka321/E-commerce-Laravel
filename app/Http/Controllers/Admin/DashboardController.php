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
        $pesanan = Pesanan::whereNotIn('status', ['Dibatalkan', 'Selesai'])->count();
        $proyek = Proyek::whereNotIn('status_pengerjaan', ['Selesai'])->count();
        return view('Admin.dashboard', compact('produk', 'pesanan', 'proyek'));
    }
}
