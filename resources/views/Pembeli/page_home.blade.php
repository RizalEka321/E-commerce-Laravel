@extends('Pembeli.layout.app')
@section('title', 'Homepage')
@section('content')
    {{-- Banner --}}
    <div id="myCarousel" class="carousel slide mt-2" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-label="Slide 0"
                aria-current="true"></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 1"
                class=""></button>
            <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 2"
                class=""></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="4000">
                <img class="d-block w-100 img-fluid" src="{{ asset('assets/pembeli/img/icon/bg_yokresell.jpg') }}"
                    alt="slide 0">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>LOKAL-INDUSTRI</h1>
                        <h2>Ayo Majukan Dan Kembangkan UMKM Indonesia</h2>
                    </div>
                </div>
            </div>
            @foreach ($banner as $b)
                <div class="carousel-item" data-bs-interval="4000">
                    <img class="d-block w-100 img-fluid" src="{{ asset($b->foto) }}" alt="slide {{ $loop->iteration }}">
                    <div class="container">
                        <div class="carousel-caption">
                            <h1>{{ $b->judul }}</h1>
                            <h2>Rp {{ number_format($b->harga, 0, '.', '.') }}</h2>
                            <a href="#" class="btn-beli">Beli</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    {{-- ./Banner --}}

    {{-- Katalog --}}
    <section class="katalog">
        <div class="container py-3 mt-3">
            <div class="text-center">
                <hr class="hr-katalog opacity-100" data-aos="flip-right" data-aos-delay="100">
                <span data-aos="zoom-in">Katalog</span>
                <hr class="hr-katalog opacity-100" data-aos="flip-right" data-aos-delay="100">
            </div>
            <div class="col-lg-12 my-5" data-aos="zoom-in">
                <div class="katalog-slider owl-carousel">
                    @foreach ($katalog as $k)
                        <div class="single-box text-center">
                            <div class="img-area">
                                <img alt="" class="img-fluid move-animation" src="{{ asset($k->foto) }}" />
                            </div>
                            <div class="info-area">
                                {{-- <p class="kategori mt-1 mx-3">{{ $k->judul }}</p> --}}
                                <h4 id="title_card">{{ Str::limit($k->judul, 20) }}</h4>
                                <h6 class="price">Rp {{ number_format($k->harga, 0, '.', '.') }}</h6>
                                <a href="#" class="btn-beli">Beli</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    {{-- ./Paket Usaha --}}
    <section>
        <h1>TES</h1>
    </section>
@endsection