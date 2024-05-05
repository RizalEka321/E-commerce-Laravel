<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class AuthController extends Controller
{
    public function login()
    {
        return view('Auth.login');
    }
    public function register()
    {
        return view('Auth.register');
    }
    public function dologin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:8|max:16|regex:/^[a-zA-Z0-9]+$/',
            'password' => 'required|min:8|max:16|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        ], [
            'username.required' => 'Username tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
            'username.min' => 'Panjang username minimal harus 8 karakter',
            'username.max' => 'Panjang username maksimal harus 16 karakter',
            'password.min' => 'Panjang password minimal harus 8 karakter',
            'password.max' => 'Panjang password maksimal harus 16 karakter',
            'password.regex' => 'Password yang masukkan tidak valid',
            'username.regex' => 'Username tidak valid ',
        ]);


        $slug_produk = Session::get('slug_produk');

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {
            $user = User::where('username', $request->username)->first();

            if ($user) {
                if (Auth::attempt([
                    'username' => $request->username,
                    'password' => $request->password
                ])) {
                    if ($slug_produk) {
                        // Jika ada slug produk yang disimpan dalam session, arahkan kembali ke halaman produk yang dipilih
                        return response()->json(['redirect' => '/produk/' . $slug_produk]);
                    } else {
                        // Jika tidak ada, arahkan sesuai peran pengguna
                        $role = Auth::user()->role;

                        if ($role === 'Pembeli') {
                            return response()->json(['redirect' => '/']);
                        } else {
                            return response()->json(['redirect' => '/admin']);
                        }
                    }
                } else {
                    // Jika autentikasi gagal (kombinasi username dan password tidak cocok)
                    return response()->json(['error' => 'Password yang anda masukkan salah']);
                }
            } else {
                // Jika username tidak ditemukan dalam basis data
                return response()->json(['error' => 'Username atau password yang anda masukkan tidak ditemukan']);
            }
        }
        // Notifikasi jika username dan password salah secara bersamaan
        return response()->json(['error' => 'Username dan password salah.']);
    }

    public function doregister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|min:8|max:25',
            'username' => 'required|min:8|max:16|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|max:16|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'password_confirmation' => 'required|same:password'
        ], [
            'nama_lengkap.required' => 'Nama lengkap tidak boleh kosong',
            'nama_lengkap.min' => 'Panjang nama lengkap minimal harus 8 karakter',
            'nama_lengkap.max' => 'Panjang nama lengkap maksimal adalah 25 karakter',
            'username.required' => 'Username tidak boleh kosong',
            'username.min' => 'Panjang username minimal harus 8 karakter',
            'username.max' => 'Panjang username maksimal harus 16 karakter',
            'username.unique' => 'Username sudah digunakan',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah digunakan',
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
            $user = User::create([
                'nama_lengkap' => $request->nama_lengkap,
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'Pembeli',
            ]);

            event(new Registered($user));

            Auth::login($user);

            return response()->json(['redirect' => '/email/verify']);
        }
    }

    public function notice(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('home');
        } else {
            return view('Auth.verifikasi_email');
        }
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect()->route('home');
    }

    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()
            ->withSuccess('A fresh verification link has been sent to your email address.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
