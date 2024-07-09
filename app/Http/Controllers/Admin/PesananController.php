<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pesanan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\PesananDiproses;
use App\Http\Controllers\Controller;
use App\Mail\PesananDibatalkan;
use App\Mail\PesananSelesai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PesananController extends Controller
{
    public function index()
    {
        return view('Admin.pesanan');
    }

    public function get_pesanan()
    {
        $data = Pesanan::select('id_pesanan', 'users_id', 'metode_pengiriman', 'metode_pembayaran', 'status', 'total')->with('user')->get();
        return Datatables::of($data)
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="btn-group">';
                $actionBtn .= '<a href="javascript:void(0)" type="button" id="btn-edit" class="btn-edit" onClick="edit_data(' . "'" . $row->id_pesanan . "'" . ')"><i class="fa-solid fa-pen-to-square"></i></a>';
                $actionBtn .= '<a href="' . route('admin.pesanan.detail', $row->id_pesanan) . '" type="button" id="btn-ubah" class="btn-ubah"><i class="fa-solid fa-eye"></i></a>';
                $actionBtn .= '<a href="' . route('admin.pesanan.detail', $row->id_pesanan) . '" type="button" id="btn-ubah" class="btn-ubah"><i class="fa-solid fa-eye"></i> Detail</a>';
                $actionBtn .= '</div>';
                return $actionBtn;
            })
            ->addColumn('status', function ($row) {
                $dropdown = '<select class="form-control status-dropdown" data-id="' . $row->id_pesanan . '"';
                $statusOptions = [];
                switch ($row->status) {
                    case 'Menunggu Pembayaran':
                        $statusOptions = ['Menunggu Pembayaran', 'Diproses', 'Selesai', 'Dibatalkan'];
                        $dropdown .= ' style="background-color: #FFD700; color: white;"';
                        break;
                    case 'Diproses':
                        $statusOptions = ['Diproses', 'Selesai', 'Dibatalkan'];
                        $dropdown .= ' style="background-color: #0D1282; color: white;"';
                        break;
                    case 'Selesai':
                        $statusOptions = ['Selesai', 'Dibatalkan'];
                        $dropdown .= ' style="background-color: #009100; color: white;"';
                        break;
                    case 'Dibatalkan':
                        $statusOptions = ['Dibatalkan'];
                        $dropdown .= ' style="background-color: #C51605; color: white;"';
                        break;
                }

                $dropdown .= '>';

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

        return response()->json(['status' => true, 'pesanan' => $pesanan]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_hp' => 'required|regex:/^\+?[0-9]+$/|min:10|max:12',
            'alamat_pengiriman' => 'required|min:25|max:75',
            'metode_pembayaran' => 'required',
            'metode_pengiriman' => 'required',
        ], [
            'no_hp.required' => 'No Handphone wajib diisi.',
            'no_hp.regex' => 'No Handphone wajib diawali +62',
            'no_hp.min' => 'No Handphone harus memiliki panjang minimal 10 karakter.',
            'no_hp.max' => 'No Handphone harus memiliki panjang maksimal 12 karakter.',
            'alamat_pengiriman.required' => 'Alamat Pengiriman wajib diisi.',
            'alamat_pengiriman.min' => 'Alamat Pengiriman harus memiliki panjang minimal 25 karakter.',
            'alamat_pengiriman.max' => 'Alamat Pengiriman harus memiliki panjang maksimal 75 karakter.',
            'metode_pembayaran.required' => 'Metode Pembayaran wajib diisi.',
            'metode_pengiriman.required' => 'Metode Pengiriman wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {
            $id = $request->query('q');
            $pesanan = Pesanan::find($id);

            $pesanan->alamat_pengiriman = $request->alamat_pengiriman;
            $pesanan->no_hp = $request->no_hp;
            $pesanan->metode_pembayaran = $request->metode_pembayaran;
            $pesanan->metode_pengiriman = $request->metode_pengiriman;

            $pesanan->save();

            aktivitas('Mengupdate Data Pesanan Dengan ID ' . $pesanan->id_pesanan);

            return response()->json(['status' => true]);
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->input('q');
        $pesanan = Pesanan::find($id);
        $pesanan->delete();

        return response()->json(['status' => true]);
    }

    public function update_status(Request $request)
    {
        $id = $request->id;
        $status = $request->status;

        $data = Pesanan::findOrFail($id);
        $data->status = $status;
        $data->save();

        $pesanan = Pesanan::find($id);
        if ($status == 'Diproses') {
            Mail::to($pesanan->user->email)->send(new PesananDiproses($pesanan->id_pesanan));
            aktivitas('Mengupdate Status Pesanan Dengan ID ' . $pesanan->id_pesanan . 'Menjadi Diproses');
        } else if ($status == 'Selesai') {
            Mail::to($pesanan->user->email)->send(new PesananSelesai($pesanan->id_pesanan));
            aktivitas('Mengupdate Status Pesanan Dengan ID ' . $pesanan->id_pesanan . 'Menjadi Selesai');
        } else if ($status == 'Dibatalkan') {
            Mail::to($pesanan->user->email)->send(new PesananDibatalkan($pesanan->id_pesanan));
            aktivitas('Mengupdate Status Pesanan Dengan ID ' . $pesanan->id_pesanan . 'Menjadi Dibatalkan');
        }

        return response()->json(['status' => true]);
    }
}
