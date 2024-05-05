@extends('Pembeli.layout.app')
@section('title', 'Homepage')
@section('content')
    <a href="https://wa.me/{{ $nomor_wa }}?text=Halo%20admin%2C%20ada%20yang%20ingin%20saya%20tanyakan" class="act-btn">
        <i class="fa-brands fa-whatsapp"></i>
    </a>
    {{-- Banner --}}
    <section class="home_carousel">
        <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="4000">
                    <img class="d-block w-100 img-fluid" src="{{ asset('assets/pembeli/img/bg_carousel.png') }}"
                        alt="slide 0">
                    <div class="carousel-caption">
                        <h1>Membuat pakaian dengan kualitas terbaik!</h1>
                        <a href="#produk" class="btn-lihat">Lihat Produk Kami</a>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="4000">
                    <img class="d-block w-100 img-fluid" src="{{ asset('assets/pembeli/img/bg_carousel.png') }}"
                        alt="slide 1">
                    <div class="carousel-caption">
                        <h1>Ayo Majukan Dan Kembangkan UMKM Indonesia</h1>
                        <a href="#profil" class="btn-lihat">Lihat Profil Kami</a>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="4000">
                    <img class="d-block w-100 img-fluid" src="{{ asset('assets/pembeli/img/bg_carousel.png') }}"
                        alt="slide 2">
                    <div class="carousel-caption">
                        <h1>Ayo Majukan Dan Kembangkan UMKM Indonesia</h1>
                        <a href="#kontak" class="btn-lihat">Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- ./Banner --}}

    {{-- Profile Perusahaan --}}
    <section class="home_perusahaan" id="profil">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 info-perusahaan">
                    <h2>CV. Lokal Industri</h2>
                    {!! $profile->deskripsi !!}
                </div>
                <div class="col-lg-6 img-perusahaan">
                    <img src="{{ asset($profile->foto) }}" alt="Lokal Industri">
                </div>
            </div>
        </div>
    </section>
    {{-- ./Profile Perusahaan --}}

    {{-- Bg Produk --}}
    <section class="home_bgproduk">
        <img src="{{ asset('assets/pembeli/img/bg_home.png') }}" alt="produk-kami">
    </section>
    {{-- ./Profile Perusahaan --}}

    {{-- Produk --}}
    <section class="home_produk" id="produk">
        <div class="container">
            <div class="text-center">
                <span>Beli Sekarang</span>
            </div>
            <div class="col-lg-12 mt-5">
                <div class="home_produk-slider owl-carousel">
                    @foreach ($produk as $k)
                        <div class="single-box">
                            <a href="{{ route('detail_produk', $k->slug) }}" class="btn-beli">
                                <div class="img-produk">
                                    <img alt="produk" class="img-fluid move-animation" src="{{ asset($k->foto) }}" />
                                </div>
                                <div class="info-produk">
                                    <h4 class="produk">{{ Str::limit($k->judul, 25) }}</h4>
                                    <h4 class="harga">Rp {{ number_format($k->harga, 0, '.', '.') }}</h4>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    {{-- ./Produk --}}

    {{-- FAQ --}}
    <section class="home_faq" id="FAQ">
        <div class="container">
            <div class="text-center mb-4">
                <span>Pertanyaan Umum (FAQ)</span>
            </div>
            <div class="tab">
                <button class="btn-panel" id="btn-faq-answer1" onclick="togglePanel('faq-answer1')"><i
                        class="fa-solid fa-chevron-down"></i> Custom produksi di Lokal apakah free design? </button>
                <div class="panel hilang" id="faq-answer1">
                    <div class="paragraf" id="myDiv_id1"></div>
                    <p id="paragraph_id1">Frequently Asked Questions (FAQ) pages contain a list of commonly asked
                        questions and answers on a website about topics such as hours, shipping and handling,
                        product information, and return policies.

                        Sure there are chatbots, support lines, and customer reviews to help shoppers on their
                        path to purchase, but there’s one forgotten customer service tactic that is
                        cost-effective and streamlined. That tactic is an FAQ page.
                    </p>
                </div>
                <button class="btn-panel" id="btn-faq-answer2" onclick="togglePanel('faq-answer2')"><i
                        class="fa-solid fa-chevron-down"></i> Apa saja bahan yang tersedia di Lokal Industri? </button>
                <div class="panel hilang" id="faq-answer2">
                    <div class="paragraf" id="myDiv_id2"></div>
                    <p id="paragraph_id2">An FAQ page is a time-saving customer service tactic that provides the
                        most commonly asked questions and answers for current or potential customers.

                        Before diving into how to make an FAQ page, you need to know why having one is so
                        important. There are so many reasons beyond improving the customer experience for
                        perfecting your FAQ page. Keep in mind the importance of an FAQ page when developing
                        your own e-commerce website so you can make sure it increases sales and not the other
                        way around.
                    </p>
                </div>
                <button class="btn-panel" id="btn-faq-answer3" onclick="togglePanel('faq-answer3')"><i
                        class="fa-solid fa-chevron-down"></i> Metode printing apa yang Lokal pakai? </button>
                <div class="panel hilang" id="faq-answer3">
                    <div class="paragraf" id="myDiv_id3"></div>
                    <p id="paragraph_id3">An FAQ page is a time-saving customer service tactic that provides the
                        most commonly asked questions and answers for current or potential customers.

                        Before diving into how to make an FAQ page, you need to know why having one is so
                        important. There are so many reasons beyond improving the customer experience for
                        perfecting your FAQ page. Keep in mind the importance of an FAQ page when developing
                        your own e-commerce website so you can make sure it increases sales and not the other
                        way around.
                    </p>
                </div>
                <button class="btn-panel" id="btn-faq-answer4" onclick="togglePanel('faq-answer4')"><i
                        class="fa-solid fa-chevron-down"></i> Berapa lama estimasi pengerjaannya? </button>
                <div class="panel hilang" id="faq-answer4">
                    <div class="paragraf" id="myDiv_id4"></div>
                    <p id="paragraph_id4">An FAQ page is a time-saving customer service tactic that provides the
                        most commonly asked questions and answers for current or potential customers.

                        Before diving into how to make an FAQ page, you need to know why having one is so
                        important. There are so many reasons beyond improving the customer experience for
                        perfecting your FAQ page. Keep in mind the importance of an FAQ page when developing
                        your own e-commerce website so you can make sure it increases sales and not the other
                        way around.
                    </p>
                </div>
            </div>
        </div>
    </section>
    {{-- ./FAQ --}}

    {{-- Kontak --}}
    <section class="home_kontak" id="kontak">
        <div class="container">
            <div class="info-kontak text-center">
                <span class="mb-2">Hubungi Kami</span>
                <p>Isi form berikut untuk menghubungi kami lebih lanjut melalui email. Deskripsikan pertanyaaan anda dengan
                    sebaik mungkin </p>
            </div>
            <form action="" method="post">
                <div class="row mb-3">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="nama">NAMA</label>
                            <input type="text" id="nama" name="nama" class="input-kecil">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">EMAIL</label>
                            <input type="email" id="email" name="email" class="input-kecil">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-group">
                        <label for="pesan">PESAN</label>
                        <textarea id="pesan" name="pesan" class="input-besar">{{ old('pesan') }}</textarea>
                    </div>
                </div>
                <div class="text-center">
                    <button type="sumbit" class="btn-kirim">Kirim</button>
                </div>
            </form>
        </div>
    </section>
    {{-- ./Kontak --}}
@endsection
@section('script')
    <script>
        function togglePanel(panelId) {
            var panel = $('#' + panelId);
            var btn = $('#btn-' + panelId);
            if (panel.hasClass('hilang')) {
                panel.removeClass('hilang');
                btn.addClass("muncul");
            } else {
                panel.addClass('hilang');
                btn.removeClass("muncul");
            }
        }
    </script>
@endsection
