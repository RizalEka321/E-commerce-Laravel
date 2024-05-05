@extends('Pembeli.layout.app')
@section('title', 'Pesanan Saya')
@section('content')
    <section class="pesanan">
        <div class="container">
            <div class="my-4">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab-menunggu-pembayaran" data-bs-toggle="tab"
                            href="#content-menunggu-pembayaran">Menunggu Pembayaran</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab-pesanan-diproses" data-bs-toggle="tab"
                            href="#content-pesanan-diproses">Pesanan
                            Diproses</a>
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
                        @foreach ($pesanan as $item)
                            @if ($item->status === 'Menunggu Pembayaran')
                                <div class="row">
                                    <div class="col">
                                        <div class="card my-2 mx-2">
                                            <div class="card-body">
                                                <hr>
                                                <div class="d-grid">
                                                    @if ($item->detail)
                                                        @foreach ($item->detail as $d)
                                                            <div class="d-flex">
                                                                <div class="card-image mt-3">
                                                                    <img width="100 px" height="100px"
                                                                        src="{{ asset($d->produk->foto) }}"
                                                                        class="card-title" alt="Image 1">
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">
                                                                        {{ $d->produk->judul }}
                                                                    </h5>
                                                                    <p class="card-text">Qty :
                                                                        <span>{{ $d->jumlah }}</span> x
                                                                        <span>Rp.
                                                                            {{ number_format($d->produk->harga, 0, ',', '.') }}</span>
                                                                    </p>
                                                                    <div class="nav-item position-relative">
                                                                        <div class="price">
                                                                            <h5>Sub Total :</h5>
                                                                        </div>
                                                                        <div class="price position-absolute top-0 end-0">
                                                                            <h5>
                                                                                Rp.
                                                                                {{ number_format($d->produk->harga * $d->jumlah, 0, ',', '.') }}
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
                                                            {{-- @if ($item->bukti_pembayaran == null)
                                                                <!-- Button trigger modal -->
                                                                <button type="button" class="btn-resell"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModal{{ $item->id }}">
                                                                    Upload Bukti Pembayaran
                                                                </button>
                                                            @else
                                                                <h4> Bukti Sudah Di upload</h4>
                                                            @endif --}}

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
                                                                        <form action="#" method="post"
                                                                            enctype="multipart/form-data">
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
                    <div id="content-pesanan-diproses" class="tab-pane fade">
                        @php
                            $hitungstatus = 0;
                        @endphp
                        @foreach ($pesanan as $item)
                            @if ($item->status === 'Diproses')
                                <div class="row">
                                    <div class="col">
                                        <div class="card my-2 mx-2">
                                            <div class="card-body">
                                                <hr>
                                                @if ($item->detail)
                                                    @foreach ($item->detail as $d)
                                                        <div class="d-flex">
                                                            <div class="card-image mt-3">
                                                                <img width="100 px" height="100px"
                                                                    src="{{ asset($d->produk->foto) }}" class="card-title"
                                                                    alt="Image 1">
                                                            </div>
                                                            <div class="card-body">
                                                                <h5 class="card-title">{{ $d->produk->judul }}
                                                                </h5>
                                                                <p class="card-text">Qty :
                                                                    <span>{{ $d->jumlah }}</span> x
                                                                    <span>Rp.
                                                                        {{ number_format($d->produk->harga, 0, ',', '.') }}</span>
                                                                </p>
                                                                <div class="nav-item position-relative">
                                                                    <div class="price">
                                                                        <h5>Sub Total :</h5>
                                                                    </div>
                                                                    <div class="price position-absolute top-0 end-0">
                                                                        <h5>
                                                                            Rp.
                                                                            {{ number_format($d->produk->harga * $d->jumlah, 0, ',', '.') }}
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
                    <div id="content-selesai" class="tab-pane fade">
                        @php
                            $hitungstatus = 0;
                        @endphp
                        @foreach ($pesanan as $item)
                            @if ($item->status === 'Selesai')
                                <div class="row">
                                    <div class="col">
                                        <div class="card my-2 mx-2">
                                            <div class="card-body">
                                                <hr>
                                                <div class="d-grid">
                                                    @if ($item->detail)
                                                        @foreach ($item->detail as $d)
                                                            <div class="d-flex">
                                                                <div class="card-image mt-3">
                                                                    <img width="100 px" height="100px"
                                                                        src="{{ asset($d->produk->foto) }}"
                                                                        class="card-title" alt="Image 1">
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">
                                                                        {{ $d->produk->judul }}
                                                                    </h5>
                                                                    <p class="card-text">Qty :
                                                                        <span>{{ $d->jumlah }}</span> x
                                                                        <span>Rp.
                                                                            {{ number_format($d->produk->harga, 0, ',', '.') }}</span>
                                                                    </p>
                                                                    <div class="nav-item position-relative">
                                                                        <div class="price">
                                                                            <h5>Sub Total :</h5>
                                                                        </div>
                                                                        <div class="price position-absolute top-0 end-0">
                                                                            <h5>
                                                                                Rp.
                                                                                {{ number_format($d->produk->harga * $d->jumlah, 0, ',', '.') }}
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
                                                            <a target="_blank" type="button" class="btn-resell me-2"
                                                                href="#">Beli Lagi</a>
                                                            <a target="_blank" type="button" class="btn-resell"
                                                                href="#">Cetak</a>
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
