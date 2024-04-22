@extends('Pembeli.layout.app')
@section('title', 'Homepage')
@section('content')
    <a href="#" class="act-btn">
        <i class="fa-brands fa-whatsapp"></i>
    </a>
    {{-- Banner --}}
    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
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
                <img class="d-block w-100 img-fluid" src="{{ asset('assets/pembeli/img/bg1.jpg') }}" alt="slide 0">
                <div class="carousel-caption">
                    <h1>LOKAL-INDUSTRI</h1>
                    <h2>Ayo Majukan Dan Kembangkan UMKM Indonesia</h2>
                    <a href="#produk" class="btn-lihat">Lihat Produk Kami</a>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="4000">
                <img class="d-block w-100 img-fluid" src="{{ asset('assets/pembeli/img/bg1.jpg') }}" alt="slide 1">
                <div class="carousel-caption">
                    <h1>LOKAL-INDUSTRI</h1>
                    <h2>Ayo Majukan Dan Kembangkan UMKM Indonesia</h2>
                    <a href="#profil" class="btn-lihat">Lihat Profil Kami</a>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="4000">
                <img class="d-block w-100 img-fluid" src="{{ asset('assets/pembeli/img/bg1.jpg') }}" alt="slide 2">
                <div class="carousel-caption">
                    <h1>LOKAL-INDUSTRI</h1>
                    <h2>Ayo Majukan Dan Kembangkan UMKM Indonesia</h2>
                    <a href="#kontak" class="btn-lihat">Hubungi Kami</a>
                </div>
            </div>
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

    {{-- Profile Perusahaan --}}
    <section class="home" id="profil">
        <div class="container">
            <div class="text-center">
                <hr class="hr-home opacity-100" data-aos="flip-right" data-aos-delay="100">
                <span>Profile Perusahaan</span>
                <hr class="hr-home opacity-100" data-aos="flip-right" data-aos-delay="100">
            </div>
            <div class="col-lg-20">
                <div class="row">
                    <div class="col-md-5 col-lg-5 order-md-2">
                        <div class="card border-0 bg-white rounded">
                            <div class="card-body">
                                <img src="{{ asset('assets/pembeli/img/logo1.png') }}" class="img-fluid" width="100%"
                                    alt="Company Image">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 col-lg-7 order-md-1">
                        <div class="card border-0 bg-white rounded">
                            <div class="card-body">
                                <h2>Profil Perusahaan</h2>
                                <p>CV. Lokal Industri adalah sebuah perusahaan yang bergerak dalam bidang jasa pembuatan
                                    baju konveksi yang berlokasi di Desa Jajag, Kecamatan Gambiran. memiliki potensi yang
                                    menjanjikan dalam industri pembuatan baju. Mereka secara teratur menerima pesanan dari
                                    pelanggan lokal maupun sekitarnya, dengan jumlah orderan yang bervariasi tergantung pada
                                    faktor-faktor seperti musim dan permintaan pasar. Jenis pesanan yang diterima pun
                                    beragam, mulai dari baju seragam sekolah, baju kerja, hingga baju promosi perusahaan.
                                    Setiap bulannya, CV tersebut biasanya mendapatkan 2-3 proyek pembuatan pakaian dengan
                                    masing-masing proyek mencapai lebih dari 100 pcs produksi. Namun demikian, di CV
                                    tersebut saat ini masih menggunakan cara manual dalam proses pencatatan pesanan masuk
                                    dengan menggunakan buku. Selain itu, proses pemasaran masih mengandalkan platform
                                    WhatsApp. Terlebih lagi, pemilik perusahaan harus menghitung jumlah omset dari proyek
                                    yang sudah selesai secara manual menggunakan buku, yang dapat mengakibatkan resiko
                                    kehilangan data dan memakan waktu yang lama.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Profile Perusahaan --}}

    {{-- Produk --}}
    <section class="home" id="produk">
        <div class="container py-3 mt-3">
            <div class="text-center">
                <hr class="hr-home opacity-100" data-aos="flip-right" data-aos-delay="100">
                <span>Produk</span>
                <hr class="hr-home opacity-100" data-aos="flip-right" data-aos-delay="100">
            </div>
            <div class="col-lg-12 my-5">
                <div class="home-slider owl-carousel">
                    @foreach ($produk as $k)
                        <div class="single-box text-center">
                            <div class="img-area">
                                <img alt="produk" class="img-fluid move-animation" src="{{ asset($k->foto) }}" />
                            </div>
                            <div class="info-area">
                                {{-- <p class="kategori mt-1 mx-3">{{ $k->judul }}</p> --}}
                                <h4 id="title_card">{{ Str::limit($k->judul, 20) }}</h4>
                                <h6 class="price">Rp {{ number_format($k->harga, 0, '.', '.') }}</h6>
                                <a href="{{ route('detail_produk', $k->slug) }}" class="btn-beli">Beli</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    {{-- Produk --}}

    {{-- FAQ --}}
    <section class="home" id="kontak">
        <div class="container py-3 mt-3">
            <div class="text-center">
                <hr class="hr-home opacity-100" data-aos="flip-right" data-aos-delay="100">
                <span>Kontak</span>
                <hr class="hr-home opacity-100" data-aos="flip-right" data-aos-delay="100">
            </div>
            <h2>Pertanyaan Umum (FAQ)</h2>
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Pertanyaan 1?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Jawaban untuk pertanyaan 1 di sini...
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Pertanyaan 2?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Jawaban untuk pertanyaan 2 di sini...
                        </div>
                    </div>
                </div>
                <!-- More FAQ items go here -->
            </div>
        </div>
    </section>
    {{-- FAQ --}}
@endsection
