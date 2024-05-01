<?php

namespace App\Http\Controllers\Pembeli;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function page_profile()
    {
        return view('Pembeli.page_profile');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string',
            'alamat' => 'required',
            'no_hp' => 'required',
        ], [
            'nama_lengkap.required' => 'Nama Panjang wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'no_hp.required' => 'No HP wajib diisi.',
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
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $id = Auth::user()->id;
            $user = User::find($id);

            $user->password = Hash::make($request->password);

            $user->save();

            echo json_encode(['status' => TRUE]);
        }
    }
}
