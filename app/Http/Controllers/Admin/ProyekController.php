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
    public function get_proyek()
    {
        $data = Proyek::select('id_proyeks', 'instansi', 'jumlah', 'harga_satuan', 'nominal_dp', 'status_pembayaran', 'status_pengerjaan')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="btn-group"><a href="javascript:void(0)" type="button" id="btn-edit" class="btn-edit" onClick="edit_data(' . "'" . $row->id_proyeks . "'" . ')" data-bs-toggle="modal" data-bs-target="#form_modal"><i class="fa-solid fa-pen-to-square"></i></a><a href="javascript:void(0)" type="button" id="btn-del" class="btn-hapus" onClick="delete_data(' . "'" . $row->id_proyeks . "'" . ')"><i class="fa-solid fa-trash-can"></i></a>
                        </div>';
                return $actionBtn;
            })
            ->addColumn('total', function ($row) {
                if ($row->nominal_dp == null) {
                    $total = $row->jumlah * $row->harga_satuan;
                } else {
                    $total = ($row->jumlah * $row->harga_satuan) - $row->nominal_dp;
                }
                return $total;
            })
            ->addColumn('pembayaran', function ($row) {
                $pembayaranOptions = ['belum', 'dp', 'lunas'];
                $dropdown = '<select class="form-control pembayaran-dropdown" data-id="' . $row->id_proyeks . '"';

                switch ($row->status_pembayaran) {
                    case 'belum':
                        $dropdown .= ' style="background-color: #C51605; color: white;"';
                        break;
                    case 'dp':
                        $dropdown .= ' style="background-color: #0D1282; color: white;"';
                        break;
                    case 'lunas':
                        $dropdown .= ' style="background-color: #009100; color: white;"';
                        break;
                    default:
                        break;
                }

                $dropdown .= '>';

                foreach ($pembayaranOptions as $option) {
                    $selected = ($row->status_pembayaran == $option) ? 'selected' : '';
                    $dropdown .= '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
                }
                $dropdown .= '</select>';
                return $dropdown;
            })

            ->addColumn('pengerjaan', function ($row) {
                $pengerjaanOptions = ['diproses', 'selesai'];
                $dropdown = '<select class="form-control pengerjaan-dropdown" data-id="' . $row->id_proyeks . '"';

                switch ($row->status_pengerjaan) {
                    case 'diproses':
                        $dropdown .= ' style="background-color: #0D1282; color: white;"';
                        break;
                    case 'selesai':
                        $dropdown .= ' style="background-color: #009100; color: white;"';
                        break;
                    default:
                        break;
                }

                $dropdown .= '>';

                foreach ($pengerjaanOptions as $option) {
                    $selected = ($row->status_pengerjaan == $option) ? 'selected' : '';
                    $dropdown .= '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
                }
                $dropdown .= '</select>';
                return $dropdown;
            })

            ->rawColumns(['action', 'total', 'pengerjaan', 'pembayaran'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pemesan' => 'required|string|min:2|max:100',
            'instansi' => 'required|string',
            'no_hp' => 'required|string',
            'alamat' => 'required|string',
            'item' => 'required|string',
            'foto_logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_desain' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi_proyek' => 'required|string',
            'jumlah' => 'required|numeric',
            'harga_satuan' => 'required|numeric',
            'nominal_dp' => 'numeric|nullable',
            'deadline' => 'required',
        ], [
            'nama_pemesan.required' => 'Nama wajib diisi.',
            'instansi.required' => 'Instansi wajib diisi.',
            'no_hp.required' => 'No HP wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'foto_logo.required' => 'Foto Logo wajib diisi.',
            'foto_desain.required' => 'Foto Desain wajib diisi.',
            'deskripsi_proyek.required' => 'Deskripsi wajib diisi.',
            'jumlah.required' => 'Jumlah wajib diisi.',
            'harga_satuan.required' => 'Harga Satuan wajib diisi.',
            'deadline.required' => 'Deadline Proyek wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $proyekData = [
                'nama_pemesan' => Str::title($request->nama_pemesan),
                'instansi' => Str::title($request->instansi),
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'item' => $request->item,
                'foto_logo' => $request->file('foto_logo')->store('logo'),
                'foto_desain' => $request->file('foto_desain')->store('desain'),
                'deskripsi_proyek' => $request->deskripsi_proyek,
                'jumlah' => $request->jumlah,
                'harga_satuan' => $request->harga_satuan,
                'deadline' => $request->deadline,
                'status_pengerjaan' => 'diproses',
            ];

            if ($request->nominal_dp == null) {
                $proyekData['status_pembayaran'] = 'belum';
            } else {
                $proyekData['nominal_dp'] = $request->nominal_dp;
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
            'item' => 'required|string',
            'foto_logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_desain' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi_proyek' => 'required|string',
            'jumlah' => 'required|numeric',
            'harga_satuan' => 'required|numeric',
            'nominal_dp' => 'numeric|nullable',
            'deadline' => 'required',
        ], [
            'nama_pemesan.required' => 'Nama wajib diisi.',
            'instansi.required' => 'Instansi wajib diisi.',
            'no_hp.required' => 'No HP wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'foto_logo.required' => 'Foto Logo wajib diisi.',
            'foto_desain.required' => 'Foto Desain wajib diisi.',
            'deskripsi_proyek.required' => 'Deskripsi wajib diisi.',
            'jumlah.required' => 'Jumlah wajib diisi.',
            'harga_satuan.required' => 'Harga Satuan wajib diisi.',
            'deadline.required' => 'Deadline Proyek wajib diisi.',
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
            $ptoyek->item = $request->item;
            $ptoyek->foto_logo = $request->foto_logo;
            $ptoyek->foto_desain = $request->foto_desain;
            $ptoyek->deskripsi_proyek = $request->deskripsi_proyek;
            $ptoyek->jumlah = $request->jumlah;
            $ptoyek->harga_satuan = $request->harga_satuan;
            $ptoyek->deadline = $request->deadline;

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

    public function update_pengerjaan(Request $request)
    {

        $id = $request->id;
        $status_pengerjaan = $request->status_pengerjaan;

        $data = Proyek::findOrFail($id);
        $data->status_pengerjaan = $status_pengerjaan;
        $data->save();

        return response()->json(['success' => true]);
    }

    public function update_pembayaran(Request $request)
    {
        $id = $request->id;
        $status_pembayaran = $request->status_pembayaran;

        $data = Proyek::findOrFail($id);
        $data->status_pembayaran = $status_pembayaran;
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
