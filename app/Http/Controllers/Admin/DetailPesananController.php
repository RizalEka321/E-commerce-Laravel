<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Detail_Pesanan;
use Yajra\DataTables\Facades\DataTables;

class DetailPesananController extends Controller
{
    public function detail($id)
    {
        $detail = Detail_Pesanan::where('pesanan_id', $id)->with(['pesanan', 'produk'])->first();
        return view('Admin.detail_pesanan', compact('detail'));
    }
    public function get_detailpesanan($id)
    {
        $data = Detail_Pesanan::where('pesanan_id', $id)->select('id_detail', 'produk_id', 'pesanan_id', 'produk', 'harga', 'jumlah', 'ukuran')->with('pesanan')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('total', function ($row) {
                $total = $row->jumlah * $row->harga;
                return $total;
            })

            ->rawColumns(['total'])
            ->make(true);
    }
}
