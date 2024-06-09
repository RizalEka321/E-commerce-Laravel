@extends('Pembeli.layout.app')
@section('title', 'Pesanan Saya')
@section('content')
    <section class="pesanan">
        <h1 class="title">Pesanan Saya</h1>
        <div class="container">
            <div class="tab">
                <button class="btn-tab" id="M" onclick="buka_tab(event, 'Menunggu','M')">Menunggu Pembayaran</button>
                <button class="btn-tab" id="P" onclick="buka_tab(event, 'Proses','P')">Diproses</button>
                <button class="btn-tab" id="S" onclick="buka_tab(event, 'Selesai','S')">Selesai</button>
                <button class="btn-tab" id="B" onclick="buka_tab(event, 'Batal','B')">Dibatalkan</button>
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
                                                    <h6>{{ $item->total_barang }} Barang</h6>
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
                                            <a type="button" class="btn-detail" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal"
                                                onclick="detail('{{ $item->id_pesanan }}')">Lihat Detail
                                                Pesanan</a>
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
        <div id="Proses" class="tabcontent">
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
                                                <h6>{{ $item->total_barang }} Barang</h6>
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
                                <a type="button" class="btn-detail" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"
                                    onclick="detail('{{ $item->id_pesanan }}')">Lihat Detail
                                    Pesanan</a>
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
                                            <h6>{{ $item->total_barang }} Barang</h6>
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
                            <a type="button" class="btn-detail" data-bs-toggle="modal"
                                data-bs-target="#exampleModal"
                                onclick="detail('{{ $item->id_pesanan }}')">Lihat Detail
                                Pesanan</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
<div id="Batal" class="tabcontent">
    @if ($pesanan4->Isempty())
        <div class="card kosong">
            <div class="card-body">
                <div class="konten">
                    <i class="fa-regular fa-hourglass"></i>
                    <h6>Belum Terdapat Pesanan</h6>
                </div>
            </div>
        </div>
    @else
        @foreach ($pesanan4 as $item)
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
                                        <h6>{{ $item->total_barang }} Barang</h6>
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
                        <a type="button" class="btn-detail" data-bs-toggle="modal"
                            data-bs-target="#exampleModal"
                            onclick="detail('{{ $item->id_pesanan }}')">Lihat Detail
                            Pesanan</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Detail
                Pesanan</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal"
                aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="modal-konten">
                <div class="atas" id="pesanan-id">
                </div>
                <div id="detail">
                </div>
                <div class="row total">
                    <div class="col-lg-3">
                        <div class="row">
                            <div class="col-lg-6 kiri" id="kiri">
                            </div>
                            <div class="col-lg-6 kanan text-end" id="kanan">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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

    function detail(id) {
        Swal.fire({
            title: "Memproses Data",
            html: "Mohon tunggu sebentar...",
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "{{ url('/detail-pesanan') }}",
            type: "GET",
            data: {
                q: id
            },
            dataType: "JSON",
            success: function(response) {
                Swal.close();

                var pesanan = response.pesanan;
                var detail = response.detail;
                var admin = response.admin;
                var ongkir = response.ongkir;

                $('#pesanan-id').html(`
                <div>
                    <h5 class="id-pesanan">ID Pesanan: ${pesanan.id_pesanan}</h5>
                    <h5 class="text-start">Tanggal: ${formatDate(pesanan.created_at)}</h5>
                </div>
                <h5 class="metode">
                    ${pesanan.metode_pembayaran} / ${pesanan.metode_pengiriman}
                </h5>
            `);

                var detailHtmlContent = '';
                detail.forEach(function(item) {
                    detailHtmlContent += `
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row gx-0">
                                <div class="col-lg-4 foto">
                                    <div class="d-flex justify-content-between">
                                        <img src="${item.produk.foto}" />
                                    </div>
                                </div>
                                <div class="col-lg-8 foto-detail text-start">
                                    <h5>${item.produk.judul}</h5>
                                    <h6>Ukuran ${item.ukuran}</h6>
                                    <h6>${item.jumlah} X ${number_format(item.produk.harga)}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="sub-harga">
                                <h6>${number_format(item.produk.harga * item.jumlah)}</h6>
                            </div>
                        </div>
                    </div>
                    <hr>
                `;
                });
                $('#detail').html(detailHtmlContent);

                var kiriHtmlContent = '';
                if (pesanan.metode_pembayaran === 'Transfer') {
                    kiriHtmlContent += '<h6>Total Harga</h6>';
                    if (pesanan.metode_pengiriman === 'Delivery') {
                        kiriHtmlContent += '<h6>Biaya Ongkir</h6>';
                    }
                    kiriHtmlContent += '<h6>Biaya Admin</h6><br>';
                }
                kiriHtmlContent += '<h6>Total Belanja</h6>';
                $('#kiri').html(kiriHtmlContent);

                var kananHtmlContent = '';
                if (pesanan.metode_pembayaran === 'Transfer') {
                    kananHtmlContent += `<h6>${number_format(pesanan.total)}</h6>`;
                    if (pesanan.metode_pengiriman === 'Pickup') {
                        kananHtmlContent += `
                        <h6>${number_format(admin)}</h6>
                        <h6>${number_format(pesanan.total)}</h6>
                    `;
                    } else if (pesanan.metode_pengiriman === 'Delivery') {
                        kananHtmlContent += `
                        <h6>${number_format(ongkir)}</h6>
                        <h6>${number_format(admin)}</h6>
                        <h6>${number_format(pesanan.total)}</h6>
                    `;
                    }
                } else {
                    kananHtmlContent += `<h6>${number_format(pesanan.total)}</h6>`;
                }
                $('#kanan').html(kananHtmlContent);
            },
            error: function(xhr, status, error) {
                Swal.close();
                Swal.fire({
                    title: 'Error',
                    text: 'Terjadi kesalahan jaringan: ' + error,
                    icon: 'error',
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    toast: true
                });
            }
        });
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
    }
    // Helper function to format numbers as currency
    function number_format(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(number).replace('IDR', 'Rp.').trim();
    }
</script>
@endsection
