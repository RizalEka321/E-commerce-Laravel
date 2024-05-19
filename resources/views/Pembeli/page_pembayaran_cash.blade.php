@extends('Pembeli.layout.app')
@section('title', 'Detail Produk')
@section('content')
    <section class="pembayaran-cash">
        <div class="container">
            <div class="card">
                <div class="card-image">
                    <img src="{{ asset('assets/pembeli/img/logo_auth.png') }}" alt="logo lokal industri">
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 header-kiri">
                            <h5>Nota Untuk:</h5>
                            <h5>{{ Auth::user()->nama_lengkap }}</h5>
                            <h5>{{ Auth::user()->email }}</h5>
                            <p>{{ Auth::user()->alamat }}</p>
                        </div>
                        <div class="col-lg-6 header-kanan">
                            <h5>{{ $pesanan->created_at }}</h5>
                            <h5>ID Pesanan: {{ $pesanan->id_pesanan }}</h5>
                        </div>
                    </div>
                    <div class="produk">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Produk</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detail as $d)
                                    <tr>
                                        <td>{{ $d->produk->judul }}</td>
                                        <td>{{ $d->ukuran }}</td>
                                        <td>{{ $d->jumlah }}</td>
                                        <td>Rp. {{ number_format($d->produk->harga, 0, ',', '.') }}</td>
                                        <td>Rp. {{ number_format($d->produk->harga * $d->jumlah, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="jumlah">
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h6>Total Belanja</h6>
                                    </div>
                                    <div class="col-lg-6text-end">
                                        <h6>Rp. {{ number_format($pesanan->total, 0, ',', '.') }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <p>Silahkan datang ke tempat konveksi untuk melakukan pembayaran.</p>
                    <p>Jika Anda membutuhkan bantuan atau memiliki pertanyaan lebih lanjut seputar pembayaran, jangan
                        ragu
                        untuk
                        menghubungi kami melalui nomor telepon atau email yang tercantum di halaman kontak.</p>
                    <p>Setelah pembayaran berhasil dilakukan, tim kami akan segera memproses pesanan Anda. Kami akan
                        memberikan
                        konfirmasi melalui email ketika pesanan Anda telah siap untuk pengiriman atau penjemputan.</p>
                    <p>Terima kasih atas pembelian Anda dan dukungan Anda terhadap produk kami. Kami berharap Anda
                        menikmati
                        produk yang Anda beli!</p>
                </div>
            </div>
    </section>
@endsection
@section('script')
@endsection
