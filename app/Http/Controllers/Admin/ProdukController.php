<?php

namespace App\Http\Controllers\Admin;

use App\Models\Produk;
use App\Models\Ukuran;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ukuran_Produk;
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
                $actionBtn = '<div class="btn-group"><a href="javascript:void(0)" type="button" id="btn-edit" class="btn-edit" onClick="edit_data(' . "'" . $row->id_produk . "'" . ')"><i class="fa-solid fa-pen-to-square"></i></a><a href="javascript:void(0)" type="button" id="btn-del" class="btn-hapus" onClick="delete_data(' . "'" . $row->id_produk . "'" . ')"><i class="fa-solid fa-trash-can"></i></a>
                        </div>';
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
            'judul' => 'required|string|min:2|max:100|unique:produk',
            'deskripsi' => 'required|string',
            'harga' => 'required|integer|min:0',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'jenis_ukuran' => 'required|array|min:1',
            'jenis_ukuran.*' => 'string|max:255',
            'stok' => 'required|array|min:1',
            'stok.*' => 'nullable|integer|min:0',
        ], [
            'judul.required' => 'Nama wajib diisi.',
            'judul.unique' => 'Nama ini sudah digunakan.',
            'judul.min' => 'Nama minimal harus terdiri dari 2 karakter.',
            'judul.max' => 'Nama maksimal hanya boleh 100 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.integer' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh kurang dari 0.',
            'foto.required' => 'Foto wajib diunggah.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar hanya boleh jpeg, png, atau jpg.',
            'foto.max' => 'Ukuran gambar maksimal adalah 2 MB.',
            'jenis_ukuran.required' => 'Jenis ukuran wajib diisi.',
            'jenis_ukuran.array' => 'Jenis ukuran harus berupa array.',
            'jenis_ukuran.min' => 'Minimal satu jenis ukuran harus dipilih.',
            'jenis_ukuran.*.string' => 'Setiap jenis ukuran harus berupa teks.',
            'jenis_ukuran.*.max' => 'Panjang jenis ukuran maksimal adalah 255 karakter.',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        // Simpan foto
        $foto = $request->file('foto');
        $file_name = $request->judul . '.' . $foto->getClientOriginalExtension();
        $path = 'data/Produk/';
        $foto->move($path, $file_name);

        // Simpan produk
        $produk = Produk::create([
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
                'produk_id' => $produk->id_produk,
                'ukuran_id' => $ukuran->id_ukuran,
            ]);
        }
        return response()->json(['status' => true]);
    }

    public function edit(Request $request)
    {
        $id = $request->input('q');
        $produk = Produk::with('ukuran')->find($id);

        return response()->json(['status' => true, 'produk' => $produk]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|min:2|max:100',
            'deskripsi' => 'required|string',
            'harga' => 'required|integer|min:0',
            'foto'     => 'image|mimes:jpeg,png,jpg|max:2048',
            'jenis_ukuran' => 'required|array|min:1',
            'jenis_ukuran.*' => 'string|max:255',
            'stok' => 'required|array|min:1',
            'stok.*' => 'nullable|integer|min:0',
        ], [
            'judul.required' => 'Nama wajib diisi.',
            'judul.min' => 'Nama minimal harus terdiri dari 2 karakter.',
            'judul.max' => 'Nama maksimal hanya boleh 100 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.integer' => 'Harga harus berupa bilangan bulat.',
            'harga.min' => 'Harga tidak boleh kurang dari 0.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format gambar hanya boleh jpeg, png, atau jpg.',
            'foto.max' => 'Ukuran gambar maksimal adalah 2 MB.',
            'jenis_ukuran.required' => 'Jenis ukuran wajib diisi.',
            'jenis_ukuran.array' => 'Jenis ukuran harus berupa array.',
            'jenis_ukuran.min' => 'Minimal satu jenis ukuran harus dipilih.',
            'jenis_ukuran.*.string' => 'Setiap jenis ukuran harus berupa teks.',
            'jenis_ukuran.*.max' => 'Panjang jenis ukuran maksimal adalah 255 karakter.',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $id = $request->query('q');
            $produk = Produk::find($id);

            $produk->judul = Str::title($request->judul);
            $produk->slug = Str::slug($request->judul);
            $produk->deskripsi = $request->deskripsi;
            $produk->harga = $request->harga;

            if ($request->hasFile('foto')) {
                if ($produk->foto) {
                    if (file_exists(public_path($produk->foto))) {
                        unlink(public_path($produk->foto));
                    }
                }

                $foto = $request->file('foto');
                $file_name = $request->judul . '.' . $foto->extension();
                $path = 'data/Produk/' . Str::title($request->judul);
                $foto->move(public_path($path), $file_name);
                $produk->foto = "$path/$file_name";
            }

            $produk->save();

            // Perbarui atau tambahkan ukuran-ukuran yang dimasukkan oleh pengguna
            foreach ($request->jenis_ukuran as $key => $jenisUkuran) {
                $ukuran = Ukuran::updateOrCreate(
                    ['jenis_ukuran' => $jenisUkuran],
                    ['stok' => $request->stok[$key]]
                );

                // Menyimpan relasi antara produk dan ukuran di tabel pivot
                Ukuran_Produk::updateOrCreate([
                    'produk_id' => $produk->id_produk,
                    'ukuran_id' => $ukuran->id_ukuran,
                ]);
            }

            // Hapus ukuran yang tidak terdapat dalam data yang dikirim
            Ukuran_Produk::where('produk_id', $produk->id_produk)
                ->whereNotIn('ukuran_id', collect($request->jenis_ukuran)->pluck('id_ukuran'))
                ->delete();

            return response()->json(['status' => true]);
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->input('q');
        $produk = Produk::find($id);
        $fotoPath = public_path($produk->foto);
        if (file_exists($fotoPath)) {
            unlink($fotoPath);
        }

        // Hapus folder jika masih ada
        $folderPath = dirname($fotoPath);
        if (is_dir($folderPath)) {
            rmdir($folderPath);
        }

        // Hapus entri produk dari database
        $produk->delete();

        return response()->json(['status' => true]);
    }
}
