<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Katalog;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class KatalogController extends Controller
{
    public function index()
    {
        return view('Admin.katalog');
    }

    public function get_katalog(Request $request)
    {
        $data = Katalog::select('id_katalogs', 'judul', 'stok', 'harga')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="btn-group"><a href="javascript:void(0)" type="button" id="btn-edit" class="btn-edit" onClick="edit_data(' . "'" . $row->id_katalogs . "'" . ')" data-bs-toggle="modal" data-bs-target="#form_modal"><i class="fa-solid fa-pen-to-square"></i></a><a href="javascript:void(0)" type="button" id="btn-del" class="btn-hapus" onClick="delete_data(' . "'" . $row->id_katalogs . "'" . ')"><i class="fa-solid fa-trash-can"></i></a>
                        </div>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|min:2|max:100|unique:' . Katalog::class,
            'deskripsi' => 'required|string',
            'stok' => 'required|numeric',
            'harga' => 'required|numeric',
            'foto'     => 'image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'judul.required' => 'Nama wajib diisi.',
            'judul.unique' => 'Nama ini sudah digunakan.',
            'stok.required' => 'Tahun wajib diisi.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'harga.required' => 'Harga wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $foto = $request->foto;
            $file_name = time() . '.' . $foto->extension();
            $path = 'katalog/' . Str::title($request->merk);
            $foto->move(public_path($path), $file_name);

            Katalog::create([
                'judul' => Str::title($request->judul),
                'slug' => Str::slug($request->judul),
                'deskripsi' => $request->deskripsi,
                'stok' => $request->stok,
                'harga' => $request->harga,
                'foto' => "$path/$file_name"
            ]);

            echo json_encode(['status' => TRUE]);
        }
    }

    public function edit(Request $request)
    {
        $id = $request->input('q');
        $katalog = Katalog::find($id);

        echo json_encode(['status' => TRUE, 'isi' => $katalog]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|min:2|max:100',
            'deskripsi' => 'required|string',
            'stok' => 'required|numeric',
            'harga' => 'required|numeric',
            'foto'     => 'image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'judul.required' => 'Nama wajib diisi.',
            'judul.unique' => 'Nama ini sudah digunakan.',
            'stok.required' => 'Tahun wajib diisi.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'harga.required' => 'Harga wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $id = $request->query('q');
            $katalog = Katalog::find($id);

            $katalog->judul = Str::title($request->judul);
            $katalog->slug = Str::slug($request->judul);
            $katalog->deskripsi = $request->deskripsi;
            $katalog->stok = $request->stok;
            $katalog->harga = $request->harga;

            if ($request->hasFile('foto')) {
                if ($katalog->foto) {
                    if (file_exists(public_path($katalog->foto))) {
                        unlink(public_path($katalog->foto));
                    }
                }

                $foto = $request->file('foto');
                $file_name = time() . '.' . $foto->extension();
                $path = 'katalog/' . Str::title($request->merk);
                $foto->move(public_path($path), $file_name);
            }

            $katalog->save();


            echo json_encode(['status' => TRUE]);
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->input('q');
        $katalog = Katalog::find($id);
        $katalog->delete();

        echo json_encode(['status' => TRUE]);
    }
}
