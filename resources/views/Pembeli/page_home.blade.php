@extends('Pembeli.layout.app')
@section('title', 'Homepage')
@section('content')
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
            <div class="row">
                <div class="col-md-6">
                    <h2>Profil Perusahaan</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem eum porro ea illo repellat quis
                        consequatur sint deserunt sed atque, molestias veritatis tempore? Maiores labore ipsam, odio eaque
                        totam explicabo tempore? Doloremque sunt perferendis dolore odit dolorem reprehenderit provident
                        eaque. Quod veniam ex esse vitae, provident deserunt illo rem? Quae quos laboriosam eum! Blanditiis
                        quod, aspernatur totam quas, dolore dignissimos officiis minus quaerat magni quo, corporis numquam a
                        repellat consequuntur quis doloremque vitae eveniet recusandae. Cupiditate commodi ea sequi,
                        provident nobis omnis cumque quidem quis eius mollitia suscipit soluta, at iure unde, recusandae
                        libero fugit animi sit placeat molestiae repudiandae saepe nam consectetur praesentium? Perspiciatis
                        ducimus eum ex temporibus cupiditate qui omnis veritatis veniam, vitae, doloremque fuga laborum odio
                        quaerat obcaecati eos voluptatibus, inventore nisi pariatur corrupti earum maxime dolor error. Quasi
                        nesciunt quo, totam ipsum repudiandae aspernatur ipsa.</p>
                </div>
                <div class="col-md-6">
                    <img src="{{ asset('assets/Pembeli/img/logo1.png') }}" class="img-fluid" width="100%"
                        alt="Company Image">
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
