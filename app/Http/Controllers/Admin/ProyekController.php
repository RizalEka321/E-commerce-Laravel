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
        $data = Proyek::select('id_proyek', 'instansi', 'jumlah', 'harga_satuan', 'nominal_dp', 'status_pembayaran', 'status_pengerjaan')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="btn-group"><a href="javascript:void(0)" type="button" id="btn-edit" class="btn-edit" onClick="edit_data(' . "'" . $row->id_proyek . "'" . ')"><i class="fa-solid fa-pen-to-square"></i></a><a href="javascript:void(0)" type="button" id="btn-del" class="btn-hapus" onClick="delete_data(' . "'" . $row->id_proyek . "'" . ')"><i class="fa-solid fa-trash-can"></i></a>
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
                $pembayaranOptions = ['Belum', 'DP', 'Lunas'];
                $dropdown = '<select class="form-control pembayaran-dropdown" data-id="' . $row->id_proyek . '"';

                switch ($row->status_pembayaran) {
                    case 'Belum':
                        $dropdown .= ' style="background-color: #C51605; color: white;"';
                        break;
                    case 'DP':
                        $dropdown .= ' style="background-color: #0D1282; color: white;"';
                        break;
                    case 'Lunas':
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
                $pengerjaanOptions = ['Diproses', 'Selesai', 'Dibatalkan'];
                $dropdown = '<select class="form-control pengerjaan-dropdown" data-id="' . $row->id_proyek . '"';

                switch ($row->status_pengerjaan) {
                    case 'Diproses':
                        $dropdown .= ' style="background-color: #0D1282; color: white;"';
                        break;
                    case 'Selesai':
                        $dropdown .= ' style="background-color: #009100; color: white;"';
                        break;
                    case 'Dibatalkan':
                        $dropdown .= ' style="background-color: #C51605; color: white;"';
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
            'jumlah' => 'required|integer|min:0',
            'harga_satuan' => 'required|integer|min:0',
            'nominal_dp' => 'integer|nullable|min:0',
            'deadline' => 'required',
        ], [
            'nama_pemesan.required' => 'Nama wajib diisi.',
            'nama_pemesan.string' => 'Nama harus berupa teks.',
            'nama_pemesan.min' => 'Nama minimal harus memiliki :min karakter.',
            'nama_pemesan.max' => 'Nama maksimal harus memiliki :max karakter.',
            'instansi.required' => 'Instansi wajib diisi.',
            'instansi.string' => 'Instansi harus berupa teks.',
            'no_hp.required' => 'No HP wajib diisi.',
            'no_hp.string' => 'No HP harus berupa teks.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'item.required' => 'Item wajib diisi.',
            'item.string' => 'Item harus berupa teks.',
            'foto_logo.required' => 'Foto Logo wajib diisi.',
            'foto_logo.image' => 'Foto Logo harus berupa file gambar.',
            'foto_logo.mimes' => 'Foto Logo harus dalam format jpeg, png, atau jpg.',
            'foto_logo.max' => 'Foto Logo tidak boleh lebih dari 2048 KB.',
            'foto_desain.required' => 'Foto Desain wajib diisi.',
            'foto_desain.image' => 'Foto Desain harus berupa file gambar.',
            'foto_desain.mimes' => 'Foto Desain harus dalam format jpeg, png, atau jpg.',
            'foto_desain.max' => 'Foto Desain tidak boleh lebih dari 2048 KB.',
            'deskripsi_proyek.required' => 'Deskripsi wajib diisi.',
            'deskripsi_proyek.string' => 'Deskripsi harus berupa teks.',
            'jumlah.required' => 'Jumlah wajib diisi.',
            'jumlah.integer' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah tidak boleh kurang dari 0.',
            'harga_satuan.required' => 'Harga Satuan wajib diisi.',
            'harga_satuan.integer' => 'Harga Satuan harus berupa angka.',
            'harga_satuan.min' => 'Harga tidak boleh kurang dari 0.',
            'nominal_dp.integer' => 'Nominal DP harus berupa angka.',
            'nominal_dp.min' => 'Nominal DP tidak boleh kurang dari 0.',
            'deadline.required' => 'Deadline Proyek wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            // Folder
            $path = 'data/Proyek/' . Str::title($request->nama_pemesan);

            // Foto Logo
            $foto_logo = $request->foto_logo;
            $file_logo = 'logo' . '.' . $foto_logo->extension();
            $foto_logo->move(public_path($path), $file_logo);

            // Foto Desain
            $foto_desain = $request->foto_desain;
            $file_desain =  'desain' . '.' . $foto_desain->extension();
            $foto_desain->move(public_path($path), $file_desain);

            // Perhitungan total pembayaran
            $total_pembayaran = $request->jumlah * $request->harga_satuan;

            // Validasi nominal DP tidak boleh lebih besar dari total pembayaran
            if ($request->nominal_dp > $total_pembayaran) {
                return response()->json(['errors' => ['nominal_dp' => ['Nominal DP tidak boleh lebih besar dari total pembayaran.']]]);
            }

            $proyekData = [
                'nama_pemesan' => Str::title($request->nama_pemesan),
                'instansi' => Str::title($request->instansi),
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'item' => $request->item,
                'foto_logo' => "$path/$file_logo",
                'foto_desain' => "$path/$file_desain",
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
        $proyek = Proyek::find($id);

        return response()->json(['status' => true, 'proyek' => $proyek]);
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
            'jumlah' => 'required|integer|min:0',
            'harga_satuan' => 'required|integer|min:0',
            'nominal_dp' => 'integer|nullable|min:0',
            'deadline' => 'required',
        ], [
            'nama_pemesan.required' => 'Nama wajib diisi.',
            'nama_pemesan.string' => 'Nama harus berupa teks.',
            'nama_pemesan.min' => 'Nama minimal harus memiliki :min karakter.',
            'nama_pemesan.max' => 'Nama maksimal harus memiliki :max karakter.',
            'instansi.required' => 'Instansi wajib diisi.',
            'instansi.string' => 'Instansi harus berupa teks.',
            'no_hp.required' => 'No HP wajib diisi.',
            'no_hp.string' => 'No HP harus berupa teks.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'item.required' => 'Item wajib diisi.',
            'item.string' => 'Item harus berupa teks.',
            'foto_logo.required' => 'Foto Logo wajib diisi.',
            'foto_logo.image' => 'Foto Logo harus berupa file gambar.',
            'foto_logo.mimes' => 'Foto Logo harus dalam format jpeg, png, atau jpg.',
            'foto_logo.max' => 'Foto Logo tidak boleh lebih dari 2048 KB.',
            'foto_desain.required' => 'Foto Desain wajib diisi.',
            'foto_desain.image' => 'Foto Desain harus berupa file gambar.',
            'foto_desain.mimes' => 'Foto Desain harus dalam format jpeg, png, atau jpg.',
            'foto_desain.max' => 'Foto Desain tidak boleh lebih dari 2048 KB.',
            'deskripsi_proyek.required' => 'Deskripsi wajib diisi.',
            'deskripsi_proyek.string' => 'Deskripsi harus berupa teks.',
            'jumlah.required' => 'Jumlah wajib diisi.',
            'jumlah.integer' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah tidak boleh kurang dari 0.',
            'harga_satuan.required' => 'Harga Satuan wajib diisi.',
            'harga_satuan.integer' => 'Harga Satuan harus berupa angka.',
            'harga_satuan.min' => 'Harga tidak boleh kurang dari 0.',
            'nominal_dp.integer' => 'Nominal DP harus berupa angka.',
            'nominal_dp.min' => 'Nominal DP tidak boleh kurang dari 0.',
            'deadline.required' => 'Deadline Proyek wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $id = $request->query('q');
            $proyek = Proyek::find($id);

            $proyek->nama_pemesan = Str::title($request->nama_pemesan);
            $proyek->instansi = Str::title($request->instansi);
            $proyek->no_hp = $request->no_hp;
            $proyek->alamat = $request->alamat;
            $proyek->item = $request->item;
            $proyek->deskripsi_proyek = $request->deskripsi_proyek;
            $proyek->jumlah = $request->jumlah;
            $proyek->harga_satuan = $request->harga_satuan;
            $proyek->deadline = $request->deadline;

            // Folder
            $path = 'data/Proyek/' . Str::title($request->nama_pemesan);

            // Foto Logo
            if ($request->hasFile('foto_logo')) {
                if ($proyek->foto_logo) {
                    if (file_exists(public_path($proyek->foto_logo))) {
                        unlink(public_path($proyek->foto_logo));
                    }
                }

                $foto_logo = $request->file('foto_logo');
                $file_logo = 'logo' . '.' . $foto_logo->extension();
                $foto_logo->move(public_path($path), $file_logo);
                $proyek->foto_logo = "$path/$file_logo";
            }

            // Foto Desain
            if ($request->hasFile('foto_desain')) {
                if ($proyek->foto_desain) {
                    if (file_exists(public_path($proyek->foto_desain))) {
                        unlink(public_path($proyek->foto_desain));
                    }
                }

                $foto_desain = $request->file('foto_desain');
                $file_desain = 'logo' . '.' . $foto_desain->extension();
                $foto_desain->move(public_path($path), $file_desain);
                $proyek->foto_desain = "$path/$file_desain";
            }

            $proyek->save();


            return response()->json(['status' => true]);
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
        $proyek = Proyek::find($id);
        $proyek->delete();

        echo json_encode(['status' => TRUE]);
    }
}
