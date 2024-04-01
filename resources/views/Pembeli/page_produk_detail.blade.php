@extends('Pembeli.layout.app')
@section('title', 'Detail Produk')
@section('content')
    {{-- Detail Produk --}}
    <section class="detail-produk">
        <div class="container">
            <hr class="my-2 hr-detail opacity-100" data-aos="flip-right" data-aos-delay="100">
            <div class="row mt-3 py-2">
                <div class="col-md-3 col-lg-5">
                    <img src="{{ asset($produk->foto) }}" class="card-img-top" alt="...">
                </div>
                <div class="col-md-5 col-lg-7 pt-2">
                    <h3 class="title">{{ $produk->judul }}</h3>
                    <div class="price p-4">
                        <h2>Rp {{ number_format($produk->harga, 0, '.', '.') }}</h2>
                    </div>
                    <div>
                        <a href="#" class="btn-resell"><i class="fa-solid fa-cart-shopping"></i> Masukkan
                            Keranjang</a>
                    </div>
                </div>
            </div>

            <style>
                .checked {
                    color: #CE3ABDe;
                }
            </style>

            <div class="description row my-2 py-2">
                <h4 class="title">Deskripsi</h4>
                <div class="mx-2">
                    {!! $produk->deskripsi !!}
                </div>
            </div>
        </div>
    </section>
    {{-- End Detail Produk --}}
@endsection
