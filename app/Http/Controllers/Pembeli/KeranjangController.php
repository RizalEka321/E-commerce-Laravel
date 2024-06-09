<?php

namespace App\Http\Controllers\Pembeli;

use App\Models\Ukuran;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use App\Models\Profil_Perusahaan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KeranjangController extends Controller
{
    public function page_keranjang()
    {
        $profile = Profil_Perusahaan::where('id_profil_perusahaan', 'satu')->first();
        return view('Pembeli.page_keranjang', compact('profile'));
    }

    public function add_keranjang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'produk_id' => 'required',
            'jumlah' => 'required|numeric|min:1',
            'id_ukuran' => 'required',
        ], [
            'produk_id.required' => 'Produk ID wajib diisi.',
            'jumlah.required' => 'Jumlah wajib diisi.',
            'jumlah.numeric' => 'Jumlah yang anda masukan tidak valid, harus berupa angka.',
            'jumlah.min' => 'Jumlah yang anda masukan tidak bisa kurang dari sama dengan 0.',
            'id_ukuran.required' => 'Ukuran wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'FALSE', 'errors' => $validator->errors()]);
        } else {
            $ukuran = Ukuran::where('id_ukuran', $request->id_ukuran)->select('jenis_ukuran', 'stok')->first();
            if ($ukuran->stok == 0) {
                return response()->json(['status' => 'FALSE', 'error' => 'Stok Ukuran' + $ukuran->stok + 'Habis']);
            } elseif ($request->jumlah > $ukuran->stok) {
                return response()->json(['status' => 'FALSE', 'error' => 'Jumlah yang anda masukkan melebihi stok tersedia untuk ukuran ' . $ukuran->jenis_ukuran]);
            } else {
                $keranjang = Keranjang::where('users_id', Auth::user()->id)
                    ->where('produk_id', $request->produk_id)
                    ->where('ukuran', $request->ukuran)
                    ->where('status', 'Tidak')
                    ->first();

                if ($keranjang) {
                    $keranjang->jumlah += $request->jumlah;
                    $keranjang->save();
                } else {
                    $keranjang = Keranjang::create([
                        'users_id' => Auth::user()->id,
                        'produk_id' => $request->produk_id,
                        'ukuran_id' => $request->id_ukuran,
                        'jumlah' => $request->jumlah,
                        'ukuran' => $ukuran->jenis_ukuran,
                        'status' => 'Tidak'
                    ]);
                }

                return response()->json(['status' => 'TRUE']);
            }
        }
    }

    public function get_keranjang()
    {
        $keranjang = Keranjang::where('users_id', Auth::user()->id)
            ->where('status', 'Tidak')
            ->with('produk')
            ->get();

        $formattedKeranjang = [];

        foreach ($keranjang as $item) {
            $formattedKeranjang[] = [
                'produk' => '<div class="tabel-isi">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-4 foto">
                                    <div class="d-flex justify-content-between">
                                        <img src="' . asset($item->produk->foto) . '"/>
                                    </div>
                                </div>
                                <div class="col-lg-8 foto-detail"> <!-- Corrected typo here -->
                                    <h5>' . $item->produk->judul . '</h5>
                                    <h6>Size, ' . $item->ukuran . '</h6>
                                    <h6>Rp. ' . number_format($item->produk->harga, 0, ',', '.') . '</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex justify-content-end align-items-center">
                                <div>
                                <div class="qty-container-keranjang">
                                    <button class="qty-btn-minus" type="button"><i class="fa fa-minus"></i></button>
                                    <input type="text" name="jumlah" value="' . $item->jumlah . '" class="update-keranjang input-qty" data-id="' . $item->id_keranjang . '" readonly/>
                                    <button class="qty-btn-plus" type="button"><i class="fa fa-plus"></i></button>
                                </div>
                                <div class="text-end">
                                <h5>Rp. ' . number_format($item->produk->harga * $item->jumlah, 0, ',', '.') . '</h5>
                                <a href="javascript:void(0)" type="button" id="btn-del" class="btn-hapus-keranjang" onClick="delete_data(' . "'" . $item->id_keranjang . "'" . ')"><i class="fa-regular fa-trash-can"></i></a>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>',
                'sub_total' => $item->produk->harga * $item->jumlah
            ];
        }

        return response()->json(['data' => $formattedKeranjang]);
    }

    public function update_keranjang(Request $request)
    {
        $keranjang = Keranjang::find($request->id_keranjang);

        if (!$keranjang) {
            return response()->json(['status' => true, 'error' => 'Keranjang tidak ditemukan']);
        }

        $keranjang->jumlah = $request->jumlah;

        if ($keranjang->jumlah > 100) {
            return response()->json(['status' => true, 'error' => 'Jumlah yang anda masukan lebih dari ketentuan maksimal.']);
        }

        $ukuran = Ukuran::find($keranjang->ukuran_id);
        if ($keranjang->jumlah > $ukuran->stok) {
            return response()->json(['status' => true, 'error' => 'Jumlah yang anda masukkan lebih dari stok yang tersedia.']);
        }

        if ($keranjang->jumlah == 0) {
            return response()->json(['status' => true, 'hapus' => 'Barang dihapus dari keranjang']);
        }

        $keranjang->save();

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
