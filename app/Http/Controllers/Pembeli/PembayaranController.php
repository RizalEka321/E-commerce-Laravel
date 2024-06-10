<?php

namespace App\Http\Controllers\Pembeli;

use App\Models\Pesanan;
use App\Mail\PesananDipesan;
use Illuminate\Http\Request;
use App\Models\Detail_Pesanan;
use App\Mail\PesananDibatalkan;
use App\Models\Profil_Perusahaan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

class PembayaranController extends Controller
{
    public function pembayaran_cash($id)
    {
        $id_pesanan = Crypt::decrypt($id);
        $pesanan = Pesanan::where('id_pesanan', $id_pesanan)->with('detail')->first();
        $detail = Detail_Pesanan::where('pesanan_id', $id_pesanan)->with('produk')->get();
        $profile = Profil_Perusahaan::where('id_profil_perusahaan', 'satu')->first();
        return view('Pembeli.page_pembayaran_cash', compact('pesanan', 'detail', 'profile'));
    }

    public function pembayaran_transfer($id)
    {
        $id_pesanan = Crypt::decrypt($id);
        $profile = Profil_Perusahaan::where('id_profil_perusahaan', 'satu')->first();
        $pesanan = Pesanan::where('id_pesanan', $id_pesanan)->first();
        return view('Pembeli.page_pembayaran_transfer', compact('pesanan', 'profile'));
    }


    public function pembayaran(Request $request)
    {
        $serverKey = config('services.midtrans.serverKey');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        $signature_key = $request->signature_key;
        $transaction_status = $request->transaction_status;

        if ($hashed === $signature_key) {
            $pesanan = Pesanan::where('id_pesanan', $request->order_id)->first();
            if ($transaction_status == 'capture' || $transaction_status == 'settlement') {
                $pesanan->update([
                    'status' => 'Diproses',
                ]);
                Mail::to($pesanan->user->email)->send(new PesananDipesan($pesanan->id_pesanan));
            } else if ($transaction_status === 'cancel' || $transaction_status == 'deny' || $transaction_status === 'expire') {
                $pesanan->update([
                    'status' => 'Dibatalkan',
                ]);
                Mail::to($pesanan->user->email)->send(new PesananDibatalkan($pesanan->id_pesanan));
            }
            return response()->json(['status' => 'TRUE']);
        } else {
            return response()->json(['status' => 'FALSE']);
        }
    }
}
