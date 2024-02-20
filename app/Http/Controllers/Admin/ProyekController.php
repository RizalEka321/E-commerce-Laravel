<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Proyek;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProyekController extends Controller
{
    public function index()
    {
        return view('Admin.proyek');
    }
    public function get_proyek(Request $request)
    {
        $data = Proyek::select('id_proyeks', 'instansi', 'quantity', 'total', 'status_pembayaran', 'status_pengerjaan')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="btn-group"><a href="javascript:void(0)" type="button" id="btn-edit" class="btn-edit" onClick="edit_data(' . "'" . $row->id_proyeks . "'" . ')" data-bs-toggle="modal" data-bs-target="#form_modal"><i class="fa-solid fa-pen-to-square"></i></a><a href="javascript:void(0)" type="button" id="btn-del" class="btn-hapus" onClick="delete_data(' . "'" . $row->id_proyeks . "'" . ')"><i class="fa-solid fa-trash-can"></i></a>
                        </div>';
                return $actionBtn;
            })
            ->addColumn('status', function ($row) {
                $statusOptions = ['diproses', 'selesai'];
                $dropdown = '<select class="form-control status-dropdown" data-id="' . $row->id_proyeks . '">';
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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pemesan' => 'required|string|min:2|max:100',
            'instansi' => 'required|string',
            'no_hp' => 'required|string',
            'alamat' => 'required|string',
            'foto_logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_desain' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi_proyek' => 'required|string',
            'quantity' => 'required|numeric',
            'harga_satuan' => 'required|numeric',
            'dp_proyek' => 'numeric|nullable',
        ], [
            'nama_pemesan.required' => 'Nama wajib diisi.',
            'instansi.required' => 'Instansi wajib diisi.',
            'no_hp.required' => 'No HP wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'foto_logo.required' => 'Foto Logo wajib diisi.',
            'foto_desain.required' => 'Foto Desain wajib diisi.',
            'deskripsi_proyek.required' => 'Deskripsi wajib diisi.',
            'quantity.required' => 'Jumlah wajib diisi.',
            'harga_satuan.required' => 'Harga Satuan wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $proyekData = [
                'nama_pemesan' => Str::title($request->nama_pemesan),
                'instansi' => Str::title($request->instansi),
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'foto_logo' => $request->file('foto_logo')->store('logo'),
                'foto_desain' => $request->file('foto_desain')->store('desain'),
                'deskripsi_proyek' => $request->deskripsi_proyek,
                'quantity' => $request->quantity,
                'harga_satuan' => $request->harga_satuan,
                'status_pengerjaan' => 'diproses',
            ];

            $proyekData['total'] = $request->harga_satuan * $request->quantity;

            if ($request->dp_proyek == null) {
                $proyekData['status_pembayaran'] = 'belum';
            } else {
                $proyekData['dp_proyek'] = $request->dp_proyek;
                $proyekData['status_pembayaran'] = 'dp';
            }

            Proyek::create($proyekData);

            return response()->json(['status' => true]);
        }
    }


    public function edit(Request $request)
    {
        $id = $request->input('q');
        $ptoyek = Proyek::find($id);

        echo json_encode(['status' => TRUE, 'isi' => $ptoyek]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pemesan' => 'required|string|min:2|max:100',
            'instansi' => 'required|string',
            'no_hp' => 'required|string',
            'alamat' => 'required|string',
            'foto_logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_desain' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi_proyek' => 'required|string',
            'quantity' => 'required|numeric',
            'harga_satuan' => 'required|numeric',
            'dp_proyek' => 'numeric|nullable',
        ], [
            'nama_pemesan.required' => 'Nama wajib diisi.',
            'instansi.required' => 'Instansi wajib diisi.',
            'no_hp.required' => 'No HP wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'foto_logo.required' => 'Foto Logo wajib diisi.',
            'foto_desain.required' => 'Foto Desain wajib diisi.',
            'deskripsi_proyek.required' => 'Deskripsi wajib diisi.',
            'quantity.required' => 'Jumlah wajib diisi.',
            'harga_satuan.required' => 'Harga Satuan wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $id = $request->query('q');
            $ptoyek = Proyek::find($id);

            $ptoyek->nama_pemesan = Str::title($request->nama_pemesan);
            $ptoyek->instansi = Str::title($request->instansi);
            $ptoyek->no_hp = $request->no_hp;
            $ptoyek->alamat = $request->alamat;
            $ptoyek->foto_logo = $request->foto_logo;
            $ptoyek->foto_desain = $request->foto_desain;
            $ptoyek->deskripsi_proyek = $request->deskripsi_proyek;
            $ptoyek->quantity = $request->quantity;
            $ptoyek->harga_satuan = $request->harga_satuan;

            if ($request->hasFile('foto')) {
                if ($ptoyek->foto) {
                    if (file_exists(public_path($ptoyek->foto))) {
                        unlink(public_path($ptoyek->foto));
                    }
                }

                $foto = $request->file('foto');
                $file_name = time() . '.' . $foto->extension();
                $path = 'ptoyek/' . Str::title($request->merk);
                $foto->move(public_path($path), $file_name);
            }

            $ptoyek->save();


            echo json_encode(['status' => TRUE]);
        }
    }

    public function update_status(Request $request)
    {

        $id = $request->id;
        $status = $request->status;

        $data = Proyek::findOrFail($id);
        $data->status = $status;
        $data->save();

        return response()->json(['success' => true]);
    }

    public function update_status_pembayaran(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        $data = Proyek::findOrFail($id);
        $data->status = $status;
        $data->save();

        return response()->json(['success' => true]);
    }

    public function destroy(Request $request)
    {
        $id = $request->input('q');
        $ptoyek = Proyek::find($id);
        $ptoyek->delete();

        echo json_encode(['status' => TRUE]);
    }
}
