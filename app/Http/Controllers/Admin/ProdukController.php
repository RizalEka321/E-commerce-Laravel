<?php

namespace App\Http\Controllers\Admin;

use App\Models\Produk;
use App\Models\Ukuran;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Ukuran_Produk;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    public function index()
    {
        return view('Admin.produk');
    }

    public function get_produk()
    {
        $data = Produk::select('id_produk', 'judul', 'harga')->with('ukuran')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="btn-group">';
                if (Auth::user()->role == 'Pegawai') {
                    $actionBtn .= '<a href="javascript:void(0)" type="button" id="btn-edit" class="btn-edit" onClick="edit_data(' . "'" . $row->id_produk . "'" . ')"><i class="fa-solid fa-pen-to-square"></i></a>';
                    $actionBtn .= '<a href="javascript:void(0)" type="button" id="btn-del" class="btn-hapus" onClick="delete_data(' . "'" . $row->id_produk . "'" . ')"><i class="fa-solid fa-trash-can"></i></a>';
                } elseif (Auth::user()->role == 'Pemilik') {
                    $actionBtn .= '<a href="javascript:void(0)" type="button" id="btn-detail" class="btn-ubah" onClick="detail_data(' . "'" . $row->id_produk . "'" . ')" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-eye"></i> Detail</a>';
                }
                $actionBtn .= '</div>';
                return $actionBtn;
            })
            ->addColumn('stok', function ($row) {
                $totalStok = 0;
                foreach ($row->ukuran as $ukuran) {
                    $totalStok += $ukuran->stok;
                }
                return $totalStok;
            })
            ->rawColumns(['action', 'stok'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|min:12|max:18|unique:produk',
            'deskripsi' => 'required|min:75|string',
            'harga' => 'required|integer|min:50000|max:250000',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'jenis_ukuran' => 'required|array|min:1',
            'jenis_ukuran.*' => 'string|max:255',
            'stok' => 'required|array|min:1',
            'stok.*' => 'nullable|integer|min:0',
        ], [
            'judul.required' => 'Nama wajib diisi.',
            'judul.unique' => 'Nama ini sudah digunakan.',
            'judul.min' => 'Nama produk harus memiliki panjang minimal 12 karakter.',
            'judul.max' => 'Nama produk harus memiliki panjang maksimal 18 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.min' => 'Deskripsi produk harus memiliki panjang minimal 75 karakter.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.integer' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga produk tidak bisa kurang dari 50.000.',
            'harga.max' => 'Harga produk tidak bisa lebih dari 250.000.',
            'foto.required' => 'Foto wajib diunggah.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto yang anda masukan salah, mohon masukan dengan format jpeg, jpg atau png.',
            'foto.max' => 'Ukuran gambar maksimal adalah 2 MB.',
            'jenis_ukuran.required' => 'Jenis ukuran wajib diisi.',
            'jenis_ukuran.array' => 'Jenis ukuran harus berupa array.',
            'jenis_ukuran.min' => 'Minimal satu jenis ukuran harus dipilih.',
            'jenis_ukuran.*.string' => 'Setiap jenis ukuran harus berupa teks.',
            'jenis_ukuran.*.max' => 'Panjang jenis ukuran maksimal adalah 255 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'FALSE', 'errors' => $validator->errors()]);
        }

        $id_produk = Produk::generateID();

        // Simpan foto
        $foto = $request->file('foto');
        $file_name = $id_produk . '.' . $foto->getClientOriginalExtension();
        $path = 'data/Produk';
        $foto->move($path, $file_name);

        // Simpan produk
        Produk::create([
            'id_produk' => $id_produk,
            'judul' => Str::title($request->judul),
            'slug' => Str::slug($request->judul),
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'foto' => "$path/$file_name"
        ]);

        // Tambahkan ukuran-ukuran yang dimasukkan oleh pengguna
        foreach ($request->jenis_ukuran as $key => $jenisUkuran) {
            $ukuran = Ukuran::create([
                'jenis_ukuran' => $jenisUkuran,
                'stok' => $request->stok[$key],
            ]);

            // Menyimpan relasi antara produk dan ukuran di tabel pivot
            Ukuran_Produk::create([
                'produk_id' => $id_produk,
                'ukuran_id' => $ukuran->id_ukuran,
            ]);
        }
        return response()->json(['status' => 'TRUE']);
    }

    public function edit(Request $request)
    {
        $id = $request->input('q');
        $produk = Produk::with('ukuran')->find($id);

        return response()->json(['status' => 'TRUE', 'produk' => $produk]);
    }

    public function detail(Request $request)
    {
        $id = $request->input('q');
        $produk = Produk::with('ukuran')->find($id);

        return response()->json(['status' => 'TRUE', 'produk' => $produk]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|min:12|max:18|unique:produk,judul,' . $request->query('q') . ',id_produk',
            'deskripsi' => 'required|min:75|string',
            'harga' => 'required|integer|min:50000|max:250000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'jenis_ukuran' => 'required|array|min:1',
            'jenis_ukuran.*' => 'string|max:255',
            'id_ukuran' => 'nullable|array|min:1',
            'stok' => 'required|array|min:1',
            'stok.*' => 'nullable|integer|min:0',
        ], [
            'judul.required' => 'Nama wajib diisi.',
            'judul.unique' => 'Nama ini sudah digunakan.',
            'judul.min' => 'Nama produk harus memiliki panjang minimal 12 karakter.',
            'judul.max' => 'Nama produk harus memiliki panjang maksimal 18 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.min' => 'Deskripsi produk harus memiliki panjang minimal 75 karakter.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.integer' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga produk tidak bisa kurang dari 50.000.',
            'harga.max' => 'Harga produk tidak bisa lebih dari 250.000.',
            'foto.required' => 'Foto wajib diunggah.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto yang anda masukan salah, mohon masukan dengan format jpeg, jpg atau png.',
            'foto.max' => 'Ukuran gambar maksimal adalah 2 MB.',
            'jenis_ukuran.required' => 'Jenis ukuran wajib diisi.',
            'jenis_ukuran.array' => 'Jenis ukuran harus berupa array.',
            'jenis_ukuran.min' => 'Minimal satu jenis ukuran harus dipilih.',
            'jenis_ukuran.*.string' => 'Setiap jenis ukuran harus berupa teks.',
            'jenis_ukuran.*.max' => 'Panjang jenis ukuran maksimal adalah 255 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'FALSE', 'errors' => $validator->errors()]);
        }

        $id = $request->query('q');
        $produk = Produk::find($id);

        if (!$produk) {
            return response()->json(['status' => 'FALSE', 'errors' => ['Produk tidak ditemukan.']]);
        }

        $produk->judul = Str::title($request->judul);
        $produk->slug = Str::slug($request->judul);
        $produk->deskripsi = $request->deskripsi;
        $produk->harga = $request->harga;

        if ($request->hasFile('foto')) {
            if ($produk->foto && file_exists(public_path($produk->foto))) {
                unlink(public_path($produk->foto));
            }

            $foto = $request->file('foto');
            $file_name = $produk->id_produk . '.' . $foto->extension();
            $path = 'data/Produk';
            $foto->move(public_path($path), $file_name);
            $produk->foto = "$path/$file_name";
        }

        $produk->save();

        // Process ukuran data
        $existingUkuranIds = [];
        foreach ($request->jenis_ukuran as $key => $jenisUkuran) {
            $stok = $request->stok[$key] ?? null;

            if (empty($request->id_ukuran[$key])) {
                $ukuran = Ukuran::create([
                    'jenis_ukuran' => $jenisUkuran,
                    'stok' => $stok,
                ]);
            } else {
                $ukuran = Ukuran::find($request->id_ukuran[$key]);
                if ($ukuran) {
                    $ukuran->jenis_ukuran = $jenisUkuran;
                    $ukuran->stok = $stok;
                    $ukuran->save();
                } else {
                    $ukuran = Ukuran::create([
                        'jenis_ukuran' => $jenisUkuran,
                        'stok' => $stok,
                    ]);
                }
            }

            $existingUkuranIds[] = $ukuran->id_ukuran;

            $ukuranProduk = Ukuran_Produk::where('produk_id', $produk->id_produk)
                ->where('ukuran_id', $ukuran->id_ukuran)
                ->first();

            if ($ukuranProduk) {
                $ukuranProduk->update([
                    'produk_id' => $produk->id_produk,
                    'ukuran_id' => $ukuran->id_ukuran,
                ]);
            } else {
                Ukuran_Produk::create([
                    'produk_id' => $produk->id_produk,
                    'ukuran_id' => $ukuran->id_ukuran,
                ]);
            }
        }
        Ukuran_Produk::where('produk_id', $produk->id_produk)
            ->whereNotIn('ukuran_id', $existingUkuranIds)
            ->delete();

        $unusedUkuranIds = Ukuran::whereNotIn('id_ukuran', Ukuran_Produk::pluck('ukuran_id')->toArray())->pluck('id_ukuran')->toArray();
        Ukuran::whereIn('id_ukuran', $unusedUkuranIds)->delete();

        return response()->json(['status' => 'TRUE']);
    }

    public function destroy(Request $request)
    {
        $id = $request->input('q');
        $produk = Produk::find($id);
        $fotoPath = public_path($produk->foto);
        if (file_exists($fotoPath)) {
            unlink($fotoPath);
        }

        // Hapus entri produk dari database
        $produk->delete();

        return response()->json(['status' => 'TRUE']);
    }
}
