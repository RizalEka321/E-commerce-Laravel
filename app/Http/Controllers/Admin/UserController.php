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
            'nama_lengkap' => 'required|min:8|max:25',
            'username' => 'required|min:8|max:16|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|max:16|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'password_confirmation' => 'required|same:password',
            'role' => 'required',
            'alamat' => 'nullable',
            'no_hp' => 'nullable',
            'foto'     => 'image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama_lengkap.required' => 'Nama lengkap tidak boleh kosong',
            'nama_lengkap.min' => 'Panjang nama lengkap minimal harus 8 karakter',
            'nama_lengkap.max' => 'Panjang nama lengkap maksimal adalah 25 karakter',
            'username.required' => 'Username tidak boleh kosong',
            'username.min' => 'Panjang username minimal harus 8 karakter',
            'username.max' => 'Panjang username maksimal harus 16 karakter',
            'username.unique' => 'Username sudah digunakan',
            'role.required' => 'Role wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah digunakan.',
            'email.email' => 'Email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Panjang password minimal harus 8 karakter',
            'password.max' => 'Panjang password maksimal harus 16 karakter',
            'password.regex' => 'Password harus mengandung setidaknya satu huruf kapital, satu huruf kecil, dan satu angka',
            'password_confirmation.required' => 'Konfirmasi Password wajib diisi.',
            'password_confirmation.same' => 'Konfirmasi Password tidak sesuai dengan Password.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format file harus jpeg, png, atau jpg.',
            'foto.max' => 'Ukuran file tidak boleh lebih dari 2 MB.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $file_name = $request->username . '.' . $foto->getClientOriginalExtension();
                $path = 'data/User/';
                $foto->move($path, $file_name);
            } else {
                $file_name = null;
                $path = null;
            }

            User::create([
                'nama_lengkap' => $request->nama_lengkap,
                'username' => $request->username,
                'role' => $request->role,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'password' => Hash::make($request->password),
                'foto' => "$path/$file_name",
                'email_verified_at' => now()
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
            'nama_lengkap' => 'required|min:8|max:25',
            'username' => 'required|min:8|max:16',
            'email' => 'required|email',
            'password' => 'nullable|min:8|max:16|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'password_confirmation' => 'nullable|same:password',
            'role' => 'required',
            'alamat' => 'nullable',
            'no_hp' => 'nullable',
            'foto'     => 'image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama_lengkap.required' => 'Nama lengkap tidak boleh kosong',
            'nama_lengkap.min' => 'Panjang nama lengkap minimal harus 8 karakter',
            'nama_lengkap.max' => 'Panjang nama lengkap maksimal adalah 25 karakter',
            'username.required' => 'Username tidak boleh kosong',
            'username.min' => 'Panjang username minimal harus 8 karakter',
            'username.max' => 'Panjang username maksimal harus 16 karakter',
            'username.unique' => 'Username sudah digunakan',
            'role.required' => 'Role wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah digunakan.',
            'email.email' => 'Email tidak valid.',
            'password.min' => 'Panjang password minimal harus 8 karakter',
            'password.max' => 'Panjang password maksimal harus 16 karakter',
            'password.regex' => 'Password harus mengandung setidaknya satu huruf kapital, satu huruf kecil, dan satu angka',
            'password_confirmation.same' => 'Konfirmasi Password tidak sesuai dengan Password.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format file harus jpeg, png, atau jpg.',
            'foto.max' => 'Ukuran file tidak boleh lebih dari 2 MB.',
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
            if ($request->has('password') && $request->password != null) {
                $user->password = $request->password;
            }

            if ($request->hasFile('foto')) {
                if ($user->foto) {
                    if (file_exists(public_path($user->foto))) {
                        unlink(public_path($user->foto));
                    }
                }

                $foto = $request->file('foto');
                $file_name = $request->username . '.' . $foto->getClientOriginalExtension();
                $path = 'data/User/';
                $foto->move($path, $file_name);
                $user->foto = "$path/$file_name";
            }

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
