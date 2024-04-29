@extends('Pembeli.layout.app')
@section('title', 'Homepage')
@section('content')
    <a href="#" class="act-btn">
        <i class="fa-brands fa-whatsapp"></i>
    </a>
    {{-- Banner --}}
    <div class="konten">
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
    </div>
    {{-- ./Banner --}}

    {{-- Profile Perusahaan --}}
    <section class="home_perusahaan" id="profil">
        <div class="container">
            <div class="text-center mb-2">
                <span>Profile Perusahaan</span>
            </div>
            <div class="tab">
                <button class="tablinks" onclick="openCity(event, 'Profile')" id="defaultOpen">Profile</button>
                <button class="tablinks" onclick="openCity(event, 'Lokasi')">Lokasi</button>
                <button class="tablinks" onclick="openCity(event, 'Kontak')">Kontak</button>
            </div>

            <div id="Profile" class="tabcontent">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt molestias laboriosam quae fugit accusamus,
                    cum neque omnis eligendi quasi cumque autem consequatur ipsam molestiae. Aliquam nihil accusamus officia
                    sapiente iure voluptate expedita modi officiis, mollitia sunt perspiciatis consectetur. Laudantium
                    cumque consequuntur repudiandae fugit pariatur similique blanditiis eum modi adipisci praesentium
                    commodi ea illo, dicta, nostrum numquam eligendi cum ad nobis, aliquam vero accusantium recusandae. Quod
                    deserunt officiis accusamus asperiores omnis. Cumque doloremque voluptate nemo distinctio pariatur ut
                    labore molestiae excepturi quas accusamus repellat nam velit autem numquam non vero quibusdam quis quae
                    voluptatibus, sit debitis perferendis. Nam odio molestiae blanditiis corrupti, illum ratione nostrum
                    veritatis in omnis ipsa asperiores nesciunt eos distinctio eius harum illo molestias, delectus, ad
                    obcaecati sint! Iusto nostrum incidunt quibusdam dignissimos at minus sed veniam numquam illo esse est
                    rerum maxime, perspiciatis fugit ut veritatis maiores cumque nobis possimus sequi expedita. Explicabo
                    placeat saepe aut, blanditiis sit obcaecati eligendi officiis rerum tempore nostrum nobis iusto eaque
                    natus vitae ipsa maiores cumque, excepturi quasi nam repudiandae vero fugiat. Quod aliquid laboriosam
                    fugiat perferendis mollitia veritatis cum saepe illo magni? Id nobis ab fugit, deleniti autem ipsum
                    possimus aperiam! Et magnam deleniti consequatur natus veritatis repudiandae temporibus totam!</p>
            </div>

            <div id="Lokasi" class="tabcontent">
                <p>Paris is the capital of France.</p>
            </div>

            <div id="Kontak" class="tabcontent">
                <p>Tokyo is the capital of Japan.</p>
            </div>
        </div>
    </section>

    <style>
        .tab {
            overflow: hidden;
            display: flex;
            justify-content: center;
            background-color: var(--black);
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        /* Style the buttons inside the tab */
        .tab button {
            background-color: var(--black);
            color: var(--white);
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 50px;
            transition: 0.3s;
            font-size: 17px;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ccc;
            color: var(--black);
            transform: scale(1.4);
            transition: transform 0.3s;
        }


        /* Create an active/current tablink class */
        .tab button.active {
            background-color: #ccc;
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border-top: none;
        }

        /* Style the close button */
        .topright {
            float: right;
            cursor: pointer;
            font-size: 28px;
        }

        .topright:hover {
            color: red;
        }
    </style>
    {{-- Profile Perusahaan --}}

    {{-- Produk --}}
    <section class="home_produk" id="produk">
        <div class="container py-3 mt-3">
            <div class="text-center">
                <span>Produk</span>
                <hr class="hr-home_produk opacity-100" data-aos="flip-right" data-aos-delay="100">
            </div>
            <div class="col-lg-12 my-5">
                <div class="home_produk-slider owl-carousel">
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
    {{-- <section class="home" id="kontak">
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
    </section> --}}
    {{-- FAQ --}}
@endsection
