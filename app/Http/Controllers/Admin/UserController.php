<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        return view('Admin.user');
    }

    public function get_user(Request $request)
    {
        $data = User::select('id', 'username', 'email', 'role')->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<div class="btn-group"><a href="javascript:void(0)" type="button" id="btn-edit" class="btn-edit" onClick="edit_data(' . "'" . $row->id . "'" . ')" data-bs-toggle="modal" data-bs-target="#form_modal"><i class="fa-solid fa-pen-to-square"></i></a><a href="javascript:void(0)" type="button" id="btn-del" class="btn-hapus" onClick="delete_data(' . "'" . $row->id . "'" . ')"><i class="fa-solid fa-trash-can"></i></a>
                        </div>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string',
            'username' => 'required|string|max:255|unique:' . User::class,
            'role' => 'required',
            'email' => 'required|string|email|unique:' . User::class . '|max:100',
            'alamat' => 'required',
            'no_hp' => 'required',
            'foto'     => 'image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'required|min:8|unique:' . User::class,
        ], [
            'nama_lengkap.required' => 'Nama Panjang wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username ini sudah digunakan.',
            'role.required' => 'Role Panjang wajib diisi.',
            'email.required' => 'Plat Nomor wajib diisi.',
            'email.unique' => 'Plat Nomor ini sudah digunakan.',
            'email.email' => 'Email tidak valid.',
            'alamat.required' => 'Alamat wajib diisi.',
            'no_hp.required' => 'No HP wajib diisi.',
            'foto.required' => 'Foto wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.unique' => 'Password sudah digunakan.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {

            $foto = $request->foto;
            $file_name = $request->username . '.' . $foto->extension();
            $path = 'data/user/' . Str::title($request->username);
            $foto->move(public_path($path), $file_name);

            User::create([
                'nama_lengkap' => $request->nama_lengkap,
                'username' => $request->username,
                'role' => $request->role,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'password' => Hash::make($request->password),
                'foto' => "$path/$file_name"
            ]);
            echo json_encode(['status' => TRUE]);
        }
    }

    public function edit(Request $request)
    {
        $id = $request->input('q');
        $user = User::find($id);

        echo json_encode(['status' => TRUE, 'isi' => $user]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string',
            'username' => 'required|string|max:255',
            'role' => 'required',
            'email' => 'required|string|email',
            'alamat' => 'required',
            'no_hp' => 'required',
            'foto'     => 'image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|min:8',
        ], [
            'nama_lengkap.required' => 'Nama Panjang wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username ini sudah digunakan.',
            'role.required' => 'Role Panjang wajib diisi.',
            'email.required' => 'Plat Nomor wajib diisi.',
            'email.unique' => 'Plat Nomor ini sudah digunakan.',
            'email.email' => 'Email tidak valid.',
            'alamat.required' => 'Alamat wajib diisi.',
            'no_hp.required' => 'No HP wajib diisi.',
            'foto.required' => 'Foto wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.unique' => 'Password sudah digunakan.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $id = $request->query('q');
            $user = User::find($id);

            $user->nama_lengkap = $request->nama_lengkap;
            $user->username = $request->username;
            $user->role = $request->role;
            $user->email = $request->email;
            $user->alamat = $request->alamat;
            $user->no_hp = $request->no_hp;
            $user->password = $request->password;

            $user->save();

            echo json_encode(['status' => TRUE]);
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->input('q');
        $katalog = User::find($id);
        $katalog->delete();

        echo json_encode(['status' => TRUE]);
    }
}
