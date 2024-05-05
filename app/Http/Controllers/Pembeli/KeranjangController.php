<?php

namespace App\Http\Controllers\Pembeli;

use App\Models\Produk;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use App\Models\Profil_Perusahaan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class KeranjangController extends Controller
{
    public function page_keranjang()
    {
        $produk = Produk::select('slug', 'judul', 'foto', 'harga')->get();
        $profile = Profil_Perusahaan::where('id_profil_perusahaan', 'satu')->first();
        return view('Pembeli.page_keranjang', compact('produk', 'profile'));
    }
    public function add_keranjang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'produk_id' => 'required',
            'jumlah' => 'required|numeric|min:1',
            'ukuran' => 'required',
        ], [
            'produk_id.required' => 'Produk ID wajib diisi.',
            'jumlah.required' => 'Jumlah wajib diisi.',
            'jumlah.numeric' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah tidak boleh kurang dari 1.',
            'ukuran.required' => 'Ukuran wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        // Cek apakah produk sudah ada di keranjang pengguna
        $keranjang = Keranjang::where('users_id', Auth::user()->id)
            ->where('produk_id', $request->produk_id)
            ->where('ukuran', $request->ukuran)
            ->where('status', 'Tidak')
            ->first();

        // tambah keranjang
        if ($keranjang) {
            // Jika produk sudah ada, tingkatkan jumlahnya
            $keranjang->jumlah += $request->jumlah;
            $keranjang->save();
        } else {
            // Jika produk belum ada, tambahkan ke keranjang
            $keranjang = Keranjang::create([
                'users_id' => Auth::user()->id,
                'produk_id' => $request->produk_id,
                'jumlah' => $request->jumlah,
                'ukuran' => $request->ukuran,
                'status' => 'Tidak'
            ]);
        }

        return response()->json(['status' => true]);
    }


    public function get_keranjang()
    {
        $data = Keranjang::where('users_id', Auth::user()->id)->where('status', 'Tidak')->with('produk')->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('produk', function ($row) {
                $produk = '<td data-th="Product">
                <div class="row">
                    <div class="col-sm-3 hidden-xs"><img src="' . asset($row->produk->foto) . '" width="100" height="100" class="img-responsive" /></div>
                    <div class="col-sm-9">
                        <h5 class="nomargin">' . $row->produk->judul . '</h5>
                        <h6 class="nomargin">Ukuran ' . $row->ukuran . '</h6>
                    </div>
                </div>
            </td>';
                return $produk;
            })
            ->addColumn('harga', function ($row) {
                $harga = 'Rp ' . number_format($row->produk->harga, 0, ',', '.');
                return $harga;
            })
            ->addColumn('jumlah', function ($row) {
                $jumlah = '
                <div class="qty-container">
                    <button class="qty-btn-minus btn-light" type="button"><i class="fa fa-minus"></i></button>
                    <input type="text" name="jumlah" value="' . $row->jumlah . '" class="update-keranjang input-qty" data-id="' . $row->id_keranjang . '" name="jumlah" />
                    <button class="qty-btn-plus btn-light" type="button"><i class="fa fa-plus"></i></button>
                </div>';
                return $jumlah;
            })
            ->addColumn('total_harga', function ($row) {
                $total_harga = 'Rp ' . number_format($row->produk->harga * $row->jumlah, 0, ',', '.');
                return $total_harga;
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="btn-group"><a href="javascript:void(0)" type="button" id="btn-del" class="btn-hapus" onClick="delete_data(' . "'" . $row->id_keranjang . "'" . ')">Hapus</a></div>';
                return $actionBtn;
            })
            ->rawColumns(['produk', 'harga', 'jumlah', 'total_harga', 'action'])
            ->make(true);
    }

    public function update_keranjang(Request $request)
    {
        $keranjang = Keranjang::find($request->id_keranjang);

        if (!$keranjang) {
            return response()->json(['error' => 'Keranjang tidak ditemukan'], 404);
        }

        // Perbarui jumlah produk di keranjang
        $keranjang->jumlah = $request->jumlah;

        // Jika jumlah barang menjadi 0, hapus barang dari keranjang
        if ($keranjang->jumlah == 0) {
            $keranjang->delete();
            return response()->json(['status' => true, 'message' => 'Barang dihapus dari keranjang']);
        }

        $keranjang->save();

        // Kembalikan respons AJAX
        return response()->json(['status' => true, 'message' => 'Jumlah barang diperbarui']);
    }


    public function delete_keranjang(Request $request)
    {
        $id = $request->input('q');
        $keranjang = Keranjang::find($id);
        $keranjang->delete();

        return response()->json(['status' => true]);
    }

    public function delete_all_keranjang(Request $request)
    {
        $id = $request->input('q');
        $keranjang = Keranjang::where('users_id', $id)->where('status', 'Tidak')->get();
        foreach ($keranjang as $item) {
            $item->delete();
        }

        return response()->json(['status' => true]);
    }
}
