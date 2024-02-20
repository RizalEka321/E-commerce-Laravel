<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PesananController extends Controller
{
    public function index()
    {
        return view('Admin.pesanan');
    }
    public function get_pesanan(Request $request)
    {
        $data = Pesanan::select('id_pesanans', 'katalogs_id', 'users_id', 'quantity', 'total', 'metode_pengiriman', 'metode_pembayaran', 'status')->with('katalog', 'user')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="btn-group"><a href="javascript:void(0)" type="button" id="btn-edit" class="btn-edit" onClick="edit_data(' . "'" . $row->id_pesanans . "'" . ')" data-bs-toggle="modal" data-bs-target="#form_modal"><i class="fa-solid fa-pen-to-square"></i></a><a href="javascript:void(0)" type="button" id="btn-del" class="btn-hapus" onClick="delete_data(' . "'" . $row->id_pesanans . "'" . ')"><i class="fa-solid fa-trash-can"></i></a>
                        </div>';
                return $actionBtn;
            })
            ->addColumn('status', function ($row) {
                $statusOptions = ['menunggu pembayaran', 'diproses', 'selesai', 'dibatalkan'];
                $dropdown = '<select class="form-control status-dropdown" data-id="' . $row->id_pesanans . '">';
                foreach ($statusOptions as $option) {
                    $selected = ($row->status == $option) ? 'selected' : '';
                    $dropdown .= '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
                }
                $dropdown .= '</select>';
                return $dropdown;
            })

            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function edit(Request $request)
    {
        $id = $request->input('q');
        $pesanan = Pesanan::find($id);

        echo json_encode(['status' => TRUE, 'isi' => $pesanan]);
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
            $pesanan = Pesanan::find($id);

            $pesanan->deskripsi = $request->deskripsi;
            $pesanan->stok = $request->stok;
            $pesanan->harga = $request->harga;

            if ($request->hasFile('foto')) {
                if ($pesanan->foto) {
                    if (file_exists(public_path($pesanan->foto))) {
                        unlink(public_path($pesanan->foto));
                    }
                }

                $foto = $request->file('foto');
                $file_name = time() . '.' . $foto->extension();
                $path = 'pesanan/' . Str::title($request->merk);
                $foto->move(public_path($path), $file_name);
            }

            $pesanan->save();


            echo json_encode(['status' => TRUE]);
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->input('q');
        $pesanan = Pesanan::find($id);
        $pesanan->delete();

        echo json_encode(['status' => TRUE]);
    }

    public function update_status(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        $data = Pesanan::findOrFail($id);
        $data->status = $status;
        $data->save();

        return response()->json(['success' => true]);
    }
}
