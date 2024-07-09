@extends('Pembeli.layout.app')
@section('title', 'Detail Produk')
@section('content')
    <section class="pembayaran-cash">
        <div class="container">
            <div class="card">
                <div class="card-image">
                    <img src="{{ asset('assets/pembeli/img/logo_auth.png') }}" alt="logo lokal industri">
                </div>
                <div class="card-body mb-4">
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
                        <style>
                            .invoice-table {
                                width: 100%;
                                border-collapse: collapse;
                            }

                            .invoice-table th {
                                padding: 8px;
                                background-color: #AAAAAA;
                            }

                            .invoice-table td {
                                border-bottom: 1px solid #000000;
                                padding: 8px;
                                text-align: left;
                            }

                            .invoice-table tr {
                                font-weight: 600;
                            }

                            .invoice-summary {
                                margin-top: 5px;
                                display: flex;
                                justify-content: flex-end;
                            }

                            .summary-table {
                                width: 380px;
                                border-collapse: collapse;
                            }

                            .summary-table td {
                                padding: 2px;
                            }

                            .summary-table .description {
                                text-align: left;
                                width: 65%;
                            }

                            .summary-table .amount {
                                text-align: left;
                                width: 35%;
                                font-weight: 700;
                            }

                            .summary-table .total {
                                font-weight: bold;
                                background-color: #D9D9D9;
                                padding: 2px;
                            }
                        </style>
                        <div class="invoice-details">
                            <table class="invoice-table">
                                <thead>
                                    <tr>
                                        <th width="28%">Produk</th>
                                        <th width="24%">Size</th>
                                        <th width="14%">Jumlah</th>
                                        <th width="11%">Harga</th>
                                        <th width="13%">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detail as $d)
                                        <tr>
                                            <td>{{ $d->produk }}</td>
                                            <td>{{ $d->ukuran }}</td>
                                            <td>{{ $d->jumlah }}</td>
                                            <td>Rp. {{ number_format($d->harga, 0, '.', '.') }}</td>
                                            <td>Rp. {{ number_format($d->jumlah * $d->harga, 0, '.', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="invoice-summary">
                            <table class="summary-table">
                                <tbody>
                                    <tr>
                                        <td class="description">Total Harga ({{ $jml_barang }} Barang)</td>
                                        <td class="amount">Rp. {{ number_format($pesanan->total, 0, '.', '.') }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <td class="description">Biaya Admin</td>
                                        <td class="amount">Rp. 4.000</td>
                                    </tr>
                                    <tr>
                                        <td class="description">Ongkos Kirim</td>
                                        <td class="amount">Rp. 4.000</td>
                                    </tr> --}}
                                    <tr>
                                        <td class="description total">Total Belanja:</td>
                                        <td class="amount total">Rp. {{ number_format($pesanan->total, 0, '.', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
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
