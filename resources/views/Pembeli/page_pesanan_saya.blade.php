@extends('Pembeli.layout.app')
@section('title', 'Pesanan Saya')
@section('content')
    <section class="pesanan">
        <h1 class="title">Pesanan Saya</h1>
        <div class="container">
            <div class="tab">
                <button class="btn-tab" id="M" onclick="buka_tab(event, 'Menunggu','M')">Menunggu Pembayaran</button>
                <button class="btn-tab" id="D" onclick="buka_tab(event, 'Diproses','D')">Diproses</button>
                <button class="btn-tab" id="S" onclick="buka_tab(event, 'Selesai','S')">Selesai</button>
            </div>

            <div id="Menunggu" class="tabcontent">
                @if ($pesanan1->Isempty())
                    <div class="card kosong">
                        <div class="card-body">
                            <div class="konten">
                                <i class="fa-regular fa-hourglass"></i>
                                <h6>Belum Terdapat Pesanan</h6>
                            </div>
                        </div>
                    </div>
                @else
                    @foreach ($pesanan1 as $item)
                        <div class="card">
                            <div class="card-body">
                                @if ($item->detail)
                                    @foreach ($item->detail as $key => $d)
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-4 foto">
                                                        <div class="d-flex justify-content-between">
                                                            <img src="{{ asset($d->produk->foto) }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 foto-detail">
                                                        <h5>{{ $d->produk->judul }}</h5>
                                                        <h6>Ukuran {{ $d->ukuran }}</h6>
                                                        <h6>Rp. {{ number_format($d->produk->harga, 0, ',', '.') }} x
                                                            {{ $d->jumlah }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="sub-harga">
                                                    @if ($key === 0)
                                                        <div>
                                                            <h6 class="metode">{{ $d->pesanan->metode_pembayaran }}</h6>
                                                            <h6 class="metode">{{ $d->pesanan->metode_pengiriman }}</h6>
                                                        </div>
                                                    @endif
                                                    <h6 class="jumlah-harga">Rp.
                                                        {{ number_format($d->produk->harga * $d->jumlah, 0, ',', '.') }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                @endif
                                <div class="row total">
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-6 kiri">
                                                @if ($item->metode_pembayaran == 'Transfer')
                                                    <h6>Total Harga</h6>
                                                    @if ($item->metode_pengiriman == 'Delivery')
                                                        <h6>Biaya Ongkir</h6>
                                                    @endif
                                                    <h6>Biaya Admin</h6>
                                                    <br>
                                                @endif
                                                <h6>Total Belanja</h6>
                                            </div>
                                            <div class="col-lg-6 kanan text-end">
                                                @if ($item->metode_pembayaran == 'Transfer')
                                                    <h6>Rp. {{ number_format($item->total, 0, ',', '.') }}</h6>
                                                    @if ($item->metode_pengiriman == 'Pickup')
                                                        <h6>Rp. {{ number_format($admin, 0, ',', '.') }}</h6>
                                                        <hr>
                                                        <h6>Rp. {{ number_format($item->total, 0, ',', '.') }}
                                                        </h6>
                                                    @elseif ($item->metode_pengiriman == 'Delivery')
                                                        <h6>Rp. {{ number_format($ongkir, 0, ',', '.') }}</h6>
                                                        <h6>Rp. {{ number_format($admin, 0, ',', '.') }}</h6>
                                                        <hr>
                                                        <h6>Rp.
                                                            {{ number_format($item->total, 0, ',', '.') }}
                                                        </h6>
                                                    @endif
                                                @else
                                                    <h6>Rp. {{ number_format($item->total, 0, ',', '.') }}</h6>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div id="Diproses" class="tabcontent">
                @if ($pesanan2->Isempty())
                    <div class="card kosong">
                        <div class="card-body">
                            <div class="konten">
                                <i class="fa-regular fa-hourglass"></i>
                                <h6>Belum Terdapat Pesanan</h6>
                            </div>
                        </div>
                    </div>
                @else
                    @foreach ($pesanan2 as $item)
                        <div class="card">
                            <div class="card-body">
                                @if ($item->detail)
                                    @foreach ($item->detail as $key => $d)
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-4 foto">
                                                        <div class="d-flex justify-content-between">
                                                            <img src="{{ asset($d->produk->foto) }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 foto-detail">
                                                        <h5>{{ $d->produk->judul }}</h5>
                                                        <h6>Ukuran {{ $d->ukuran }}</h6>
                                                        <h6>Rp. {{ number_format($d->produk->harga, 0, ',', '.') }} x
                                                            {{ $d->jumlah }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="sub-harga">
                                                    @if ($key === 0)
                                                        <div>
                                                            <h6 class="metode">{{ $d->pesanan->metode_pembayaran }}</h6>
                                                            <h6 class="metode">{{ $d->pesanan->metode_pengiriman }}</h6>
                                                        </div>
                                                    @endif
                                                    <h6 class="jumlah-harga">Rp.
                                                        {{ number_format($d->produk->harga * $d->jumlah, 0, ',', '.') }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                @endif
                                <div class="row total">
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-6 kiri">
                                                @if ($item->metode_pembayaran == 'Transfer')
                                                    <h6>Total Harga</h6>
                                                    @if ($item->metode_pengiriman == 'Delivery')
                                                        <h6>Biaya Ongkir</h6>
                                                    @endif
                                                    <h6>Biaya Admin</h6>
                                                    <br>
                                                @endif
                                                <h6>Total Belanja</h6>
                                            </div>
                                            <div class="col-lg-6 kanan text-end">
                                                @if ($item->metode_pembayaran == 'Transfer')
                                                    <h6>Rp. {{ number_format($item->total, 0, ',', '.') }}</h6>
                                                    @if ($item->metode_pengiriman == 'Pickup')
                                                        <h6>Rp. {{ number_format($admin, 0, ',', '.') }}</h6>
                                                        <hr>
                                                        <h6>Rp. {{ number_format($item->total, 0, ',', '.') }}
                                                        </h6>
                                                    @elseif ($item->metode_pengiriman == 'Delivery')
                                                        <h6>Rp. {{ number_format($ongkir, 0, ',', '.') }}</h6>
                                                        <h6>Rp. {{ number_format($admin, 0, ',', '.') }}</h6>
                                                        <hr>
                                                        <h6>Rp.
                                                            {{ number_format($item->total, 0, ',', '.') }}
                                                        </h6>
                                                    @endif
                                                @else
                                                    <h6>Rp. {{ number_format($item->total, 0, ',', '.') }}</h6>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div id="Selesai" class="tabcontent">
                @if ($pesanan3->Isempty())
                    <div class="card kosong">
                        <div class="card-body">
                            <div class="konten">
                                <i class="fa-regular fa-hourglass"></i>
                                <h6>Belum Terdapat Pesanan</h6>
                            </div>
                        </div>
                    </div>
                @else
                    @foreach ($pesanan3 as $item)
                        <div class="card">
                            <div class="card-body">
                                @if ($item->detail)
                                    @foreach ($item->detail as $key => $d)
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-4 foto">
                                                        <div class="d-flex justify-content-between">
                                                            <img src="{{ asset($d->produk->foto) }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-8 foto-detail">
                                                        <h5>{{ $d->produk->judul }}</h5>
                                                        <h6>Ukuran {{ $d->ukuran }}</h6>
                                                        <h6>Rp. {{ number_format($d->produk->harga, 0, ',', '.') }} x
                                                            {{ $d->jumlah }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="sub-harga">
                                                    @if ($key === 0)
                                                        <div>
                                                            <h6 class="metode">{{ $d->pesanan->metode_pembayaran }}</h6>
                                                            <h6 class="metode">{{ $d->pesanan->metode_pengiriman }}</h6>
                                                        </div>
                                                    @endif
                                                    <h6 class="jumlah-harga">Rp.
                                                        {{ number_format($d->produk->harga * $d->jumlah, 0, ',', '.') }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                @endif
                                <div class="row total">
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-lg-6 kiri">
                                                @if ($item->metode_pembayaran == 'Transfer')
                                                    <h6>Total Harga</h6>
                                                    @if ($item->metode_pengiriman == 'Delivery')
                                                        <h6>Biaya Ongkir</h6>
                                                    @endif
                                                    <h6>Biaya Admin</h6>
                                                    <br>
                                                @endif
                                                <h6>Total Belanja</h6>
                                            </div>
                                            <div class="col-lg-6 kanan text-end">
                                                @if ($item->metode_pembayaran == 'Transfer')
                                                    <h6>Rp. {{ number_format($item->total, 0, ',', '.') }}</h6>
                                                    @if ($item->metode_pengiriman == 'Pickup')
                                                        <h6>Rp. {{ number_format($admin, 0, ',', '.') }}</h6>
                                                        <hr>
                                                        <h6>Rp. {{ number_format($item->total, 0, ',', '.') }}
                                                        </h6>
                                                    @elseif ($item->metode_pengiriman == 'Delivery')
                                                        <h6>Rp. {{ number_format($ongkir, 0, ',', '.') }}</h6>
                                                        <h6>Rp. {{ number_format($admin, 0, ',', '.') }}</h6>
                                                        <hr>
                                                        <h6>Rp.
                                                            {{ number_format($item->total, 0, ',', '.') }}
                                                        </h6>
                                                    @endif
                                                @else
                                                    <h6>Rp. {{ number_format($item->total, 0, ',', '.') }}</h6>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            buka_tab(event, 'Menunggu', 'M');
        });

        function buka_tab(evt, nama_tab, id) {
            var i, tabcontent, btntab;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            btntab = document.querySelectorAll('.btn-tab');
            for (i = 0; i < btntab.length; i++) {
                btntab[i].classList.remove("active");
            }
            document.getElementById(nama_tab).style.display = "block";
            document.getElementById(id).classList.add("active");
        }
    </script>
@endsection
