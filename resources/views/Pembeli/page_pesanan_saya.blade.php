@extends('layouts_reseller.app')
@section('title', 'Pesanan Saya')
@section('content')
    <section class="pesanan">
        <div class="container">
            <hr class="my-2 hr-pesanan opacity-100" data-aos="flip-right" data-aos-delay="100">
            <div class="my-4">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab-menunggu-pembayaran" data-bs-toggle="tab"
                            href="#content-menunggu-pembayaran">Menunggu Pembayaran</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-pembayaran-diterima" data-bs-toggle="tab"
                            href="#content-pembayaran-diterima">Pembayaran Diterima</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-pesanan-diproses" data-bs-toggle="tab"
                            href="#content-pesanan-diproses">Pesanan
                            Diproses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-pesanan-dikirim" data-bs-toggle="tab"
                            href="#content-pesanan-dikirim">Pesanan
                            Dikirim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-selesai" data-bs-toggle="tab" href="#content-selesai">Selesai</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="content-menunggu-pembayaran" class="tab-pane fade show active">
                        @php
                            $hitungstatus = 0;
                        @endphp
                        @foreach ($transaksi as $item)
                            @if ($item->status === 'Menunggu Pembayaran')
                                <div class="row">
                                    <div class="col">
                                        <div class="card my-2 mx-2">
                                            <div class="card-body">
                                                <div class="price">
                                                    <h4 style="color: #CE3ABD">ID {{ $item->id }}</h4>
                                                </div>
                                                <hr>
                                                <div class="d-grid">
                                                    @if ($item->detail_transaksi)
                                                        @foreach ($item->detail_transaksi as $detailTransaksi)
                                                            <div class="d-flex">
                                                                <div class="card-image mt-3">
                                                                    <img width="100 px" height="100px"
                                                                        src="{{ asset('assets/users/' . $detailTransaksi->produk->users->role . '/' . $detailTransaksi->produk->users_id . '/' . $detailTransaksi->produk->foto) }}"
                                                                        class="card-title" alt="Image 1">
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">
                                                                        {{ $detailTransaksi->nama_produk }}
                                                                    </h5>
                                                                    <p class="card-text">Qty :
                                                                        <span>{{ $detailTransaksi->qty }}</span> x
                                                                        <span>Rp.
                                                                            {{ number_format($detailTransaksi->harga, 0, ',', '.') }}</span>
                                                                    </p>
                                                                    <div class="nav-item position-relative">
                                                                        <div class="price">
                                                                            <h5>Sub Total :</h5>
                                                                        </div>
                                                                        <div class="price position-absolute top-0 end-0">
                                                                            <h5>
                                                                                Rp.
                                                                                {{ number_format($detailTransaksi->sub_total, 0, ',', '.') }}
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                    <hr>
                                                    <div class="price">
                                                        <div class="total d-flex justify-content-end mb-4">
                                                            <h4>
                                                                Total: <span id="total">Rp.
                                                                    {{ number_format($item->total, 0, ',', '.') }}</span>
                                                            </h4>
                                                        </div>
                                                        <div class="total d-flex justify-content-end mb-0">
                                                            @if ($item->bukti_pembayaran == null)
                                                                <!-- Button trigger modal -->
                                                                <button type="button" class="btn-resell"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModal{{ $item->id }}">
                                                                    Upload Bukti Pembayaran
                                                                </button>
                                                            @else
                                                                <h4> Bukti Sudah Di upload</h4>
                                                            @endif

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="exampleModal{{ $item->id }}"
                                                                tabindex="-1" aria-labelledby="exampleModalLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title fs-5"
                                                                                id="exampleModalLabel">
                                                                                Upload Bukti Pembayaran</h1>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <form action="{{ Route('upload.bukti.reseller') }}"
                                                                            method="post" enctype="multipart/form-data">
                                                                            @method('PUT')
                                                                            @csrf
                                                                            <div class="modal-body">
                                                                                <div class="mb-3">
                                                                                    <label for="formFile"
                                                                                        class="form-label">Masukkan Disini
                                                                                    </label>
                                                                                    <input class="form-control"
                                                                                        type="file"
                                                                                        name="bukti_pembayaran"
                                                                                        id="formFile">
                                                                                    <input class="form-control"
                                                                                        type="hidden" name="id"
                                                                                        value="{{ $item->id }}"
                                                                                        id="formFile">
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">Close</button>
                                                                                <button type="submit"
                                                                                    class="btn-resell">Submit</button>
                                                                            </div>
                                                                        </form>
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
                                @php
                                    $hitungstatus++;
                                @endphp
                            @endif
                        @endforeach
                        @if ($hitungstatus === 0)
                            <div class="row">
                                <div class="col">
                                    <div class="card py-4 my-2 mx-2">
                                        <div class="card-body py-5 text-center">
                                            <div class="my-3"><i class="fa-solid fa-money-bill-transfer fa-shake"></i>
                                            </div>
                                            <div class="mb-2">
                                                <h4>Pesanan Menunggu Pembayaran Kosong</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div id="content-pembayaran-diterima" class="tab-pane fade">
                        @php
                            $hitungstatus = 0;
                        @endphp
                        @foreach ($transaksi as $item)
                            @if ($item->status === 'Pembayaran Diterima')
                                <div class="row">
                                    <div class="col">
                                        <div class="card mt-2 mx-2">
                                            <div class="card-body">
                                                <div class="price">
                                                    <h4 style="color: #CE3ABD">ID {{ $item->id }}</h4>
                                                </div>
                                                <hr>
                                                <div class="d-grid">
                                                    @if ($item->detail_transaksi)
                                                        @foreach ($item->detail_transaksi as $detailTransaksi)
                                                            <div class="d-flex">
                                                                <div class="card-image mt-3">
                                                                    <img width="100 px" height="100px"
                                                                        src="{{ asset('assets/users/' . $detailTransaksi->produk->users->role . '/' . $detailTransaksi->produk->users_id . '/' . $detailTransaksi->produk->foto) }}"
                                                                        class="card-title" alt="Image 1">
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">
                                                                        {{ $detailTransaksi->nama_produk }}
                                                                    </h5>
                                                                    <p class="card-text">Qty :
                                                                        <span>{{ $detailTransaksi->qty }}</span> x
                                                                        <span>Rp.
                                                                            {{ number_format($detailTransaksi->harga, 0, ',', '.') }}</span>
                                                                    </p>
                                                                    <div class="nav-item position-relative">
                                                                        <div class="price">
                                                                            <h5>Sub Total :</h5>
                                                                        </div>
                                                                        <div class="price position-absolute top-0 end-0">
                                                                            <h5>
                                                                                Rp.
                                                                                {{ number_format($detailTransaksi->sub_total, 0, ',', '.') }}
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                    <hr>
                                                    <div class="price">
                                                        <div class="total d-flex justify-content-end mb-0">
                                                            <h4>
                                                                Total: <span id="total">Rp.
                                                                    {{ number_format($item->total, 0, ',', '.') }}</span>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $hitungstatus++;
                                @endphp
                            @endif
                        @endforeach
                        @if ($hitungstatus === 0)
                            <div class="row">
                                <div class="col">
                                    <div class="card py-4 my-2 mx-2">
                                        <div class="card-body py-5 text-center">
                                            <div class="my-3"><i class="fa-solid fa-money-check-dollar fa-flip"></i>
                                            </div>
                                            <div class="mb-2">
                                                <h4>Pesanan Pembayaran Diterima Kosong</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div id="content-pesanan-diproses" class="tab-pane fade">
                        @php
                            $hitungstatus = 0;
                        @endphp
                        @foreach ($transaksi as $item)
                            @if ($item->status === 'Pesanan Diproses')
                                <div class="row">
                                    <div class="col">
                                        <div class="card my-2 mx-2">
                                            <div class="card-body">
                                                <div class="price">
                                                    <h4 style="color: #CE3ABD">ID {{ $item->id }}</h4>
                                                </div>
                                                <hr>
                                                @if ($item->detail_transaksi)
                                                    @foreach ($item->detail_transaksi as $detailTransaksi)
                                                        <div class="d-flex">
                                                            <div class="card-image mt-3">
                                                                <img width="100 px" height="100px"
                                                                    src="{{ asset('assets/users/' . $detailTransaksi->produk->users->role . '/' . $detailTransaksi->produk->users_id . '/' . $detailTransaksi->produk->foto) }}"
                                                                    class="card-title" alt="Image 1">
                                                            </div>
                                                            <div class="card-body">
                                                                <h5 class="card-title">{{ $detailTransaksi->nama_produk }}
                                                                </h5>
                                                                <p class="card-text">Qty :
                                                                    <span>{{ $detailTransaksi->qty }}</span> x
                                                                    <span>Rp.
                                                                        {{ number_format($detailTransaksi->harga, 0, ',', '.') }}</span>
                                                                </p>
                                                                <div class="nav-item position-relative">
                                                                    <div class="price">
                                                                        <h5>Sub Total :</h5>
                                                                    </div>
                                                                    <div class="price position-absolute top-0 end-0">
                                                                        <h5>
                                                                            Rp.
                                                                            {{ number_format($detailTransaksi->sub_total, 0, ',', '.') }}
                                                                        </h5>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                <hr>
                                                <div class="price">
                                                    <div class="total d-flex justify-content-end mb-0">
                                                        <h4>
                                                            Total: <span id="total">Rp.
                                                                {{ number_format($item->total, 0, ',', '.') }}</span>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $hitungstatus++;
                                @endphp
                            @endif
                        @endforeach
                        @if ($hitungstatus === 0)
                            <div class="row">
                                <div class="col">
                                    <div class="card py-4 my-2 mx-2">
                                        <div class="card-body py-5 text-center">
                                            <div class="m-3"><i class="fa-solid fa-gear fa-spin fa-xl"></i><i
                                                    class="fa-solid fa-gear fa-spin fa-spin-reverse fa-2xs"></i></div>
                                            <div class="mb-2">
                                                <h4>Pesanan Diproses Kosong</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div id="content-pesanan-dikirim" class="tab-pane fade">
                        @php
                            $hitungstatus = 0;
                        @endphp
                        @foreach ($transaksi as $item)
                            @if ($item->status === 'Pesanan Dikirim')
                                <div class="row">
                                    <div class="col">
                                        <div class="card my-2 mx-2">
                                            <div class="card-body">
                                                <div class="price">
                                                    <h4 style="color: #CE3ABD">ID {{ $item->id }}</h4>
                                                </div>
                                                <hr>
                                                <div class="d-grid">
                                                    @if ($item->detail_transaksi)
                                                        @foreach ($item->detail_transaksi as $detailTransaksi)
                                                            <div class="d-flex">
                                                                <div class="card-image mt-3">
                                                                    <img width="100 px" height="100px"
                                                                        src="{{ asset('assets/users/' . $detailTransaksi->produk->users->role . '/' . $detailTransaksi->produk->users_id . '/' . $detailTransaksi->produk->foto) }}"
                                                                        class="card-title" alt="Image 1">
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">
                                                                        {{ $detailTransaksi->nama_produk }}
                                                                    </h5>
                                                                    <p class="card-text">Qty :
                                                                        <span>{{ $detailTransaksi->qty }}</span> x
                                                                        <span>Rp.
                                                                            {{ number_format($detailTransaksi->harga, 0, ',', '.') }}</span>
                                                                    </p>
                                                                    <div class="nav-item position-relative">
                                                                        <div class="price">
                                                                            <h5>Sub Total :</h5>
                                                                        </div>
                                                                        <div class="price position-absolute top-0 end-0">
                                                                            <h5>
                                                                                Rp.
                                                                                {{ number_format($detailTransaksi->sub_total, 0, ',', '.') }}
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                    <hr>
                                                    <div class="price">
                                                        <div class="total d-flex justify-content-end mb-0">
                                                            <h4>
                                                                Total: <span id="total">Rp.
                                                                    {{ number_format($item->total, 0, ',', '.') }}</span>
                                                            </h4>
                                                        </div>
                                                        <div class="d-flex justify-content-end mt-3 mb-0">
                                                            <button type="button" id="konfirmasiBtn{{ $item->id }}"
                                                                class="btn-resell btn-konfirmasi my-2"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#detailmodal{{ $item->id }}">Konfirmasi
                                                                Pesanan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="detailmodal{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="ubahStatusLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fs-5" id="ubahStatusLabel">Konfirmasi Pesanan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('pesanan.update', ['id' => $item->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <p>Apakah Anda yakin ingin mengkonfirmasi pesanan ini?</p>
                                                    <input type="hidden" name="status" value="Selesai">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn-nilai"
                                                    data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn-resell">Konfirmasi</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $hitungstatus++;
                                @endphp
                            @endif
                        @endforeach
                        @if ($hitungstatus === 0)
                            <div class="row">
                                <div class="col">
                                    <div class="card py-4 my-2 mx-2">
                                        <div class="card-body py-5 text-center">
                                            <div class="my-3"><i class="fa-solid fa-truck-fast fa-bounce"></i></div>
                                            <div class="mb-2">
                                                <h4>Pesanan Dikirim Kosong</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div id="content-selesai" class="tab-pane fade">
                        @php
                            $hitungstatus = 0;
                        @endphp
                        @foreach ($transaksi as $item)
                            @if ($item->status === 'Selesai')
                                <div class="row">
                                    <div class="col">
                                        <div class="card my-2 mx-2">
                                            <div class="card-body">
                                                <div class="price">
                                                    <h4 style="color: #CE3ABD">ID {{ $item->id }}</h4>
                                                </div>
                                                <hr>
                                                <div class="d-grid">
                                                    @if ($item->detail_transaksi)
                                                        @foreach ($item->detail_transaksi as $detailTransaksi)
                                                            <div class="d-flex">
                                                                <div class="card-image mt-3">
                                                                    <img width="100 px" height="100px"
                                                                        src="{{ asset('assets/users/' . $detailTransaksi->produk->users->role . '/' . $detailTransaksi->produk->users_id . '/' . $detailTransaksi->produk->foto) }}"
                                                                        class="card-title" alt="Image 1">
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">
                                                                        {{ $detailTransaksi->nama_produk }}
                                                                    </h5>
                                                                    <p class="card-text">Qty :
                                                                        <span>{{ $detailTransaksi->qty }}</span> x
                                                                        <span>Rp.
                                                                            {{ number_format($detailTransaksi->harga, 0, ',', '.') }}</span>
                                                                    </p>
                                                                    <div class="nav-item position-relative">
                                                                        <div class="price">
                                                                            <h5>Sub Total :</h5>
                                                                        </div>
                                                                        <div class="price position-absolute top-0 end-0">
                                                                            <h5>
                                                                                Rp.
                                                                                {{ number_format($detailTransaksi->sub_total, 0, ',', '.') }}
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                    <hr>
                                                    <div class="price">
                                                        <div class="total d-flex justify-content-end mb-0">
                                                            <h4>
                                                                Total: <span id="total">Rp.
                                                                    {{ number_format($item->total, 0, ',', '.') }}</span>
                                                            </h4>
                                                        </div>
                                                        <div class="d-flex justify-content-end mt-3 mb-0">
                                                            <a target="_blank" type="button" class="btn-resell"
                                                                href="{{ route('invoice.print', $item->id) }}">Cetak</a>
                                                            <button type="button" id="nilaiProdukBtn{{ $item->id }}"
                                                                class="btn-nilai mx-2" data-bs-toggle="modal"
                                                                data-bs-target="#nilaiProduk{{ $item->id }}">Nilai
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="nilaiProduk{{ $item->id }}" tabindex="-1"
                                    aria-labelledby="nilaiProdukLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fs-5" id="nilaiProdukLabel">Detail pesanan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true"></span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card">
                                                    <div class="card-body">
                                                        @if ($item->detail_transaksi)
                                                            @foreach ($item->detail_transaksi as $detailTransaksi)
                                                                <p class="mb-3">{{ $detailTransaksi->nama_produk }} -
                                                                    <b>Qty
                                                                        :
                                                                        <span>{{ $detailTransaksi->qty }}</span>
                                                                    </b>
                                                                </p>
                                                                <p class="form-control">Rp.
                                                                    {{ number_format($detailTransaksi->harga, 0, ',', '.') }}
                                                                </p>
                                                                @if ($detailTransaksi->produk->trashed())
                                                                    <p>Produk Tidak Tersedia</p>
                                                                @elseif ($detailTransaksi->produk->review()->where('users_id', Auth::id())->exists())
                                                                    <p>Produk Sudah Dinilai</p>
                                                                    <a href="{{ route('produk_detail.reseller', $detailTransaksi->produk->slug) }}"
                                                                        class="btn-resell form-control">Lihat Halaman
                                                                        Produk</a>
                                                                @else
                                                                    <a href="{{ route('produk_detail.reseller', $detailTransaksi->produk->slug) }}"
                                                                        class="btn-resell form-control">Rate</a>
                                                                @endif

                                                                <hr>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn-nilai"
                                                    data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $hitungstatus++;
                                @endphp
                            @endif
                        @endforeach
                        @if ($hitungstatus === 0)
                            <div class="row">
                                <div class="col">
                                    <div class="card py-4 my-2 mx-2">
                                        <div class="card-body py-5 text-center">
                                            <div class="my-3"><i class="fa-solid fa-clipboard-check fa-shake"></i></div>
                                            <div class="mb-2">
                                                <h4>Pesanan Selesai Kosong</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
