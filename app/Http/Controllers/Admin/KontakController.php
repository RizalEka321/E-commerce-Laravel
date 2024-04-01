<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class KontakController extends Controller
{
    public function index()
    {
        $kontak = Kontak::where('id_kontak', 'kontak')->first();
        return view('Admin.kontak', compact('kontak'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'instagram' => 'required|string|min:2|max:100',
            'whatsapp' => 'required|numeric',
            'email' => 'required|email',
            'facebook' => 'required|string|min:2|max:100',
        ], [
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
            $id = 'kontak';
            $kontak = Kontak::where('id_kontak', $id)->first();

            $kontak->instagram = Str::title($request->instagram);
            $kontak->whatsapp = Str::title($request->whatsapp);
            $kontak->email = Str::title($request->email);
            $kontak->facebook = Str::title($request->facebook);

            $kontak->save();

            return response()->json(['status' => true]);
        }
    }
}
