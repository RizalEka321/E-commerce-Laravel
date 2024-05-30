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
                    <h3>Panduan Pembayaran dengan Cara Tunai (Cash)</h3>
                    <p>Untuk memudahkan proses pembayaran, kami menyediakan opsi pembayaran dengan cara tunai. Berikut
                        langkah-langkah yang perlu Anda ikuti:</p>
                    <ul>
                        <li><strong>Persiapkan Pembayaran Tunai:</strong> Pastikan Anda telah menyiapkan jumlah yang
                            tepat
                            sesuai dengan total pembayaran yang tercantum dalam invoice yang telah kami tampilkan
                            diatas.</li>
                        <li><strong>Kunjungi Lokasi Pembayaran:</strong> Anda dapat melakukan pembayaran langsung di
                            kantor kami
                            yang berlokasi di:
                            <address>
                                CV. Lokal Industri<br>
                                Jl. Kebangkitan No. 123 Kota Industri, Provinsi Kreatif 12345
                            </address>
                        </li>
                        <li><strong>Waktu Operasional:</strong> Kami melayani pembayaran tunai pada hari kerja:
                            <ul>
                                <li>Senin - Jumat: 08.00 - 17.00</li>
                                <li>Sabtu: 08.00 - 12.00</li>
                                <li>Minggu dan Hari Libur Nasional: Tutup</li>
                            </ul>
                        </li>
                        <li><strong>Konfirmasi Pembayaran:</strong> Setelah melakukan pembayaran, tim kami akan
                            memberikan bukti
                            pembayaran resmi. Simpan bukti ini sebagai referensi Anda.</li>
                    </ul>
                    <p>Jika Anda memerlukan bantuan lebih lanjut atau memiliki pertanyaan mengenai pembayaran, jangan
                        ragu untuk
                        menghubungi tim customer service kami atau melalui email.</p>
                    <p>Sekali lagi, terima kasih atas kepercayaan Anda berbelanja di CV. Lokal Industri. Kami berharap
                        produk
                        kami dapat memberikan manfaat dan kepuasan maksimal bagi Anda. Kami siap melayani kebutuhan Anda
                        di masa
                        mendatang.</p>
                    <p>Salam hangat,</p>
                    <p><strong>Tim CV. Lokal Industri</strong></p>
                    <p>Apabila Anda memiliki masukan atau saran, kami sangat terbuka untuk mendengarnya. Kritik dan
                        saran Anda
                        membantu kami untuk terus meningkatkan pelayanan dan kualitas produk kami. Terima kasih dan
                        sampai jumpa
                        lagi di pembelian selanjutnya!</p>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
@endsection
