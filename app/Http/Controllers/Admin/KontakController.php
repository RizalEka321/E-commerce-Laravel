<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kontak_Perusahaan;
use App\Models\Profil_Perusahaan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class KontakController extends Controller
{
    public function index()
    {
        $profil = Profil_Perusahaan::where('id_profil_perusahaan', 'satu')->first();
        $kontak = Kontak_Perusahaan::where('id_kontak_perusahaan', 'satu')->first();
        return view('Admin.kontak', compact('profil', 'kontak'));
    }

    public function update_kontak(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'deskripsi' => 'required|string|min:2|max:500',
            'alamat' => 'required|string|min:2|max:100', // Mengubah tipe validasi dari numeric menjadi string
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
            'instagram' => 'required|string|min:2|max:100',
            'whatsapp' => 'required|numeric',
            'email' => 'required|email',
            'facebook' => 'required|string|min:2|max:100',
        ], [
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.min' => 'Deskripsi minimal harus terdiri dari 2 karakter.',
            'deskripsi.max' => 'Deskripsi maksimal hanya boleh 500 karakter.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'alamat.min' => 'Alamat minimal harus terdiri dari 2 karakter.',
            'alamat.max' => 'Alamat maksimal hanya boleh 100 karakter.',
            'foto.image' => 'File yang diunggah harus berupa gambar.',
            'foto.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'foto.max' => 'Ukuran gambar tidak boleh melebihi 2048 kilobita (2MB).',
            'instagram.required' => 'Instagram wajib diisi.',
            'instagram.string' => 'Instagram harus berupa teks.',
            'instagram.min' => 'Instagram minimal harus terdiri dari 2 karakter.',
            'instagram.max' => 'Instagram maksimal hanya boleh 100 karakter.',

            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'whatsapp.numeric' => 'Nomor WhatsApp harus berupa angka.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email harus dalam format yang benar.',

            'facebook.required' => 'Facebook wajib diisi.',
            'facebook.string' => 'Facebook harus berupa teks.',
            'facebook.min' => 'Facebook minimal harus terdiri dari 2 karakter.',
            'facebook.max' => 'Facebook maksimal hanya boleh 100 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $id = 'satu';
            $kontak = Kontak_Perusahaan::where('id_kontak_perusahaan', $id)->first();
            $profil = Profil_Perusahaan::where('id_profil_perusahaan', $id)->first();

            $kontak->instagram = Str::title($request->instagram);
            $kontak->whatsapp = Str::title($request->whatsapp);
            $kontak->email = Str::title($request->email);
            $kontak->facebook = Str::title($request->facebook);


            $profil->deskripsi = Str::title($request->deskripsi);
            $profil->alamat = Str::title($request->alamat);

            if ($request->hasFile('foto')) {
                if ($profil->foto) {
                    if (file_exists(public_path($profil->foto))) {
                        unlink(public_path($profil->foto));
                    }
                }

                $foto = $request->file('foto');
                $file_name = 'perusahaan' . '.' . $foto->extension();
                $path = 'data/Profil_Perusahaan/';
                $foto->move(public_path($path), $file_name);
                $profil->foto = "$path/$file_name";
            }
            $profil->save();
            $kontak->save();

            return response()->json(['status' => true]);
        }
    }
}
