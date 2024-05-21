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
                                @foreach ($item->detail as $d)
                                    <div class="atas">
                                        <h5 class="id-pesanan">ID Pesanan : {{ $item->id_pesanan }}</h5>
                                        <h5 class="metode">
                                            {{ $d->pesanan->metode_pembayaran }} /
                                            {{ $d->pesanan->metode_pengiriman }}
                                        </h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-4 foto">
                                                    <div class="d-flex justify-content-between">
                                                        <img src="{{ asset($d->produk->foto) }}" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 foto-detail">
                                                    <h5>{{ $d->produk->judul }}. Size, {{ $d->ukuran }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="total-harga">
                                                <h6>Total Belanja</h6>
                                                <h5>Rp.
                                                    {{ number_format($item->total, 0, ',', '.') }}
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                @break
                            @endforeach
                            <div class="row bawah">
                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="col-lg-7 kiri text-end">
                                            <button type="button" class="btn-detail" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">Lihat Detail Pesanan</button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Detail
                                                                Pesanan</h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @foreach ($pesanan2 as $item)
                                                                <div class="atas">
                                                                    <div>
                                                                        <h5 class="id-pesanan">ID Pesanan :
                                                                            {{ $item->id_pesanan }}</h5>
                                                                        <h5 class="text-start">Tanggal:
                                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                                                        </h5>
                                                                    </div>
                                                                    <h5 class="metode">
                                                                        {{ $d->pesanan->metode_pembayaran }} /
                                                                        {{ $d->pesanan->metode_pengiriman }}
                                                                    </h5>
                                                                </div>
                                                                @foreach ($item->detail as $d)
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <div class="row gx-0">
                                                                                <div class="col-lg-4 foto">
                                                                                    <div
                                                                                        class="d-flex justify-content-between">
                                                                                        <img
                                                                                            src="{{ asset($d->produk->foto) }}" />
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="col-lg-8 foto-detail text-start">
                                                                                    <h5>{{ $d->produk->judul }}</h5>
                                                                                    <h6>Ukuran {{ $d->ukuran }}</h6>
                                                                                    <h6>{{ $d->jumlah }} X Rp.
                                                                                        {{ number_format($d->produk->harga, 0, ',', '.') }}
                                                                                    </h6>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="sub-harga">
                                                                                <h6>Rp.
                                                                                    {{ number_format($d->produk->harga * $d->jumlah, 0, ',', '.') }}
                                                                                </h6>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <hr>
                                                                @endforeach
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
                                                                                    <h6>Rp.
                                                                                        {{ number_format($item->total, 0, ',', '.') }}
                                                                                    </h6>
                                                                                    @if ($item->metode_pengiriman == 'Pickup')
                                                                                        <h6>Rp.
                                                                                            {{ number_format($admin, 0, ',', '.') }}
                                                                                        </h6>
                                                                                        <h6>Rp.
                                                                                            {{ number_format($item->total, 0, ',', '.') }}
                                                                                        </h6>
                                                                                    @elseif($item->metode_pengiriman == 'Delivery')
                                                                                        <h6>Rp.
                                                                                            {{ number_format($ongkir, 0, ',', '.') }}
                                                                                        </h6>
                                                                                        <h6>Rp.
                                                                                            {{ number_format($admin, 0, ',', '.') }}
                                                                                        </h6>
                                                                                        <h6>Rp.
                                                                                            {{ number_format($item->total, 0, ',', '.') }}
                                                                                        </h6>
                                                                                    @endif
                                                                                @else
                                                                                    <h6>Rp.
                                                                                        {{ number_format($item->total, 0, ',', '.') }}
                                                                                    </h6>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-5 kanan text-end">
                                            @if ($item->metode_pembayaran == 'Transfer')
                                                <a href="{{ route('pembayaran.online', Crypt::encrypt($item->id_pesanan)) }}"
                                                    type="button" class="btn-bayar">Bayar</a>
                                            @else
                                                <a href="{{ route('pembayaran.cash', Crypt::encrypt($item->id_pesanan)) }}"
                                                    type="button" class="btn-bayar">Bukti</a>
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
                @foreach ($pesanan1 as $item)
                    <div class="card">
                        <div class="card-body">
                            @foreach ($item->detail as $d)
                                <div class="atas">
                                    <h5 class="id-pesanan">ID Pesanan : {{ $item->id_pesanan }}</h5>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-4 foto">
                                                <div class="d-flex justify-content-between">
                                                    <img src="{{ asset($d->produk->foto) }}" />
                                                </div>
                                            </div>
                                            <div class="col-lg-8 foto-detail">
                                                <h5>{{ $d->produk->judul }}. Size, {{ $d->ukuran }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="total-harga">
                                            <h6>Total Belanja</h6>
                                            <h5>Rp.
                                                {{ number_format($item->total, 0, ',', '.') }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            @break
                        @endforeach
                        <div class="row bawah">
                            <div class="col-lg-4 text-end">
                                <a href="" type="button" class="btn-detail">Lihat Detail
                                    Pesanan</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <div id="Selesai" class="tabcontent">
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
                        @foreach ($item->detail as $d)
                            <div class="atas">
                                <h5 class="id-pesanan">ID Pesanan : {{ $item->id_pesanan }}</h5>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-4 foto">
                                            <div class="d-flex justify-content-between">
                                                <img src="{{ asset($d->produk->foto) }}" />
                                            </div>
                                        </div>
                                        <div class="col-lg-8 foto-detail">
                                            <h5>{{ $d->produk->judul }}. Size, {{ $d->ukuran }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="total-harga">
                                        <h6>Total Belanja</h6>
                                        <h5>Rp.
                                            {{ number_format($item->total, 0, ',', '.') }}
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        @break
                    @endforeach
                    <div class="row bawah">
                        <div class="col-lg-4 text-end">
                            <a href="" type="button" class="btn-detail">Lihat Detail
                                Pesanan</a>
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
