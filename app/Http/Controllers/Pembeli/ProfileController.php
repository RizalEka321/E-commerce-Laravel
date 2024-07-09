<?php

namespace App\Http\Controllers\Pembeli;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Profil_Perusahaan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function page_profile()
    {
        $profile = Profil_Perusahaan::where('id_profil_perusahaan', 'satu')->first();
        return view('Pembeli.page_profile', compact('profile'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string',
            'alamat' => 'required|min:25|max:75',
            'no_hp' => 'required|regex:/^\+?[0-9]+$/|min:10|max:12',
        ], [
            'nama_lengkap.required' => 'Nama Panjang wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.min' => 'Alamat harus memiliki panjang minimal 25 karakter.',
            'alamat.max' => 'Alamat harus memiliki panjang maksimal 75 karakter.',
            'no_hp.required' => 'No Handphone wajib diisi.',
            'no_hp.regex' => 'No Handphone wajib diawali +62',
            'no_hp.min' => 'No Handphone harus memiliki panjang minimal 10 karakter.',
            'no_hp.max' => 'No Handphone harus memiliki panjang maksimal 12 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $id = Auth::user()->id;
            $user = User::find($id);

            $user->nama_lengkap = $request->nama_lengkap;
            $user->alamat = $request->alamat;
            $user->no_hp = $request->no_hp;

            $user->save();

            echo json_encode(['status' => TRUE]);
        }
    }

    public function update_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|max:16|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'password_confirmation' => 'required|same:password',
        ], [
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Panjang password minimal harus 8 karakter',
            'password.max' => 'Panjang password maksimal harus 16 karakter',
            'password.regex' => 'Password harus mengandung setidaknya satu huruf kapital, satu huruf kecil, dan satu angka',
            'password_confirmation.required' => 'Konfirmasi Password wajib diisi.',
            'password_confirmation.same' => 'Konfirmasi Password tidak sesuai dengan Password.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {
            $id = Auth::user()->id;
            $user = User::find($id);

            $user->password = Hash::make($request->password);

            $user->save();

            echo json_encode(['status' => true]);
        }
    }

    public function update_foto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto yang anda masukan salah, mohon masukan dengan format jpeg, jpg, atau png.',
            'foto.max' => 'Ukuran gambar maksimal yang dapat anda masukan adalah 2MB.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {
            $id = Auth::user()->id;
            $user = User::find($id);

            if ($request->hasFile('foto')) {
                if ($user->foto) {
                    if (public_path($user->foto)) {
                        unlink($user->foto);
                    }
                }

                $foto = $request->file('foto');
                $file_name = $user->username . '.' . $foto->getClientOriginalExtension();
                $path = 'data/User';
                $foto->move($path, $file_name);
                $user->foto = "$path/$file_name";
            }

            $user->save();

            $foto_baru = $user->foto;

            echo json_encode(['status' => true, 'foto' => $foto_baru]);
        }
    }
}
