@extends('Pembeli.layout.app')
@section('title', 'Homepage')
@section('content')
    <div class="btn-wa">
        <a href="https://wa.me/{{ $nomor_wa }}?text=Halo%20admin%2C%20ada%20yang%20ingin%20saya%20tanyakan"
            class="btn-wa-button"><i class="fa-brands fa-whatsapp"></i><span class="long-text">Hubungi untuk custom
                produk</span>
        </a>
    </div>

    {{-- Banner --}}
    <section class="home_carousel">
        <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="4000">
                    <img class="d-block w-100 img-fluid" src="{{ asset('assets/pembeli/img/bg_carousel1.png') }}"
                        alt="slide 0">
                    <div class="carousel-caption">
                        <h1>Membuat pakaian dengan kualitas terbaik!</h1>
                        <a href="#produk" class="btn-lihat">Lihat Produk Kami</a>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="4000">
                    <img class="d-block w-100 img-fluid" src="{{ asset('assets/pembeli/img/bg_carousel2.png') }}"
                        alt="slide 1">
                    <div class="carousel-caption">
                        <h1>Wujudkan pakaian impianmu bersama Lokal Industri</h1>
                        <a href="#profil" class="btn-lihat">Lihat Profil Kami</a>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="4000">
                    <img class="d-block w-100 img-fluid" src="{{ asset('assets/pembeli/img/bg_carousel3.png') }}"
                        alt="slide 2">
                    <div class="carousel-caption">
                        <h1>Dibuat dengan cermat, untuk mewujudkan pakaian impian anda</h1>
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
                <div class="col-md-6 col-lg-6 order-md-2 order-1 img-perusahaan">
                    @if ($profile->foto == null)
                        <img src="{{ asset('assets/pembeli/img/default.png') }}" alt="Lokal Industri">
                    @else
                        <img src="{{ asset($profile->foto) }}" alt="Lokal Industri">
                    @endif
                </div>
                <div class="col-md-6 col-lg-6 order-md-1 order-2 info-perusahaan">
                    <h2>CV. Lokal Industri</h2>
                    {!! $profile->deskripsi !!}
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
                <button class="btn-panel" id="btn-faq-answer1" onclick="togglePanel('faq-answer1')">
                    <i class="fa-solid fa-chevron-down"></i> Custom produksi di Lokal apakah free design?
                </button>
                <div class="panel hilang" id="faq-answer1">
                    <div class="paragraf" id="myDiv_id1"></div>
                    <p id="paragraph_id1">
                        Ya, kami menyediakan layanan free design untuk setiap custom produksi di Lokal Industri. Tim
                        desainer kami siap membantu mewujudkan ide dan konsep Anda menjadi pakaian dengan kualitas terbaik.
                        Kami bekerja sama dengan Anda dari tahap awal desain hingga produk akhir, memastikan setiap detail
                        sesuai dengan keinginan Anda. Silakan hubungi kami untuk konsultasi lebih lanjut dan memulai proses
                        desain custom Anda tanpa biaya tambahan!
                    </p>
                </div>
                <button class="btn-panel" id="btn-faq-answer2" onclick="togglePanel('faq-answer2')">
                    <i class="fa-solid fa-chevron-down"></i> Apa saja bahan yang tersedia di Lokal Industri?
                </button>
                <div class="panel hilang" id="faq-answer2">
                    <div class="paragraf" id="myDiv_id2"></div>
                    <p id="paragraph_id2">
                        Lokal Industri menyediakan beragam bahan berkualitas tinggi untuk memenuhi berbagai kebutuhan
                        pakaian Anda. Berikut adalah beberapa bahan yang tersedia:
                    <ul>
                        <li>Katun: Nyaman dan breathable, ideal untuk pakaian sehari-hari.</li>
                        <li>Polyester: Tahan lama dan mudah dirawat, cocok untuk pakaian olahraga dan seragam.</li>
                        <li>Denim: Kuat dan stylish, sempurna untuk celana jeans dan jaket.</li>
                        <li>Linen: Ringan dan sejuk, pilihan terbaik untuk pakaian musim panas.</li>
                        <li>Rayon: Lembut dan halus, memberikan tampilan mewah pada pakaian kasual dan formal.</li>
                        <li>Spandex: Elastis dan nyaman, sering digunakan untuk pakaian olahraga dan aktif.</li>
                    </ul>
                    Kami terus menambah variasi bahan untuk memenuhi kebutuhan pelanggan kami. Jika Anda memiliki bahan
                    khusus yang diinginkan, silakan hubungi kami untuk informasi lebih lanjut!
                    </p>
                </div>
                <button class="btn-panel" id="btn-faq-answer3" onclick="togglePanel('faq-answer3')">
                    <i class="fa-solid fa-chevron-down"></i> Metode printing apa yang Lokal pakai?
                </button>
                <div class="panel hilang" id="faq-answer3">
                    <div class="paragraf" id="myDiv_id3"></div>
                    <p id="paragraph_id3">
                        Lokal Industri menggunakan berbagai metode printing untuk memastikan kualitas terbaik sesuai dengan
                        kebutuhan dan preferensi Anda:
                    <ul>
                        <li>Screen Printing: Ideal untuk desain dengan warna solid dan volume tinggi. Metode ini
                            menghasilkan cetakan yang tahan lama dan berkualitas tinggi.</li>
                        <li>Digital Printing: Cocok untuk desain yang kompleks dan penuh warna. Metode ini memungkinkan
                            cetakan detail dengan gradasi warna yang halus.</li>
                        <li>Sublimation Printing: Digunakan untuk bahan polyester, metode ini memberikan cetakan yang tahan
                            lama dan tidak pudar, sangat cocok untuk pakaian olahraga dan aktif.</li>
                    </ul>
                    Kami memastikan setiap metode printing dipilih berdasarkan jenis bahan dan desain Anda untuk mencapai
                    hasil terbaik. Jika Anda memiliki kebutuhan khusus atau ingin mengetahui lebih lanjut tentang metode
                    printing kami, jangan ragu untuk menghubungi kami!
                    </p>
                </div>
                <button class="btn-panel" id="btn-faq-answer4" onclick="togglePanel('faq-answer4')">
                    <i class="fa-solid fa-chevron-down"></i> Berapa lama estimasi pengerjaannya?
                </button>
                <div class="panel hilang" id="faq-answer4">
                    <div class="paragraf" id="myDiv_id4"></div>
                    <p id="paragraph_id4">
                        Estimasi waktu pengerjaan di Lokal Industri bervariasi tergantung pada kompleksitas desain, jenis
                        bahan, dan jumlah pesanan. Secara umum, berikut adalah estimasi waktu pengerjaan kami:
                    <ul>
                        <li>Pakaian Custom: 2-4 minggu</li>
                        <li>Printing dan Embroidery: 1-2 minggu</li>
                        <li>Proyek Skala Besar (seperti seragam perusahaan): 4-6 minggu</li>
                        <li>Pesanan Khusus dengan Desain yang Rumit: 3-5 minggu</li>
                    </ul>
                    Kami selalu berusaha untuk menyelesaikan pesanan secepat mungkin tanpa mengorbankan kualitas. Untuk
                    estimasi waktu yang lebih akurat, silakan hubungi tim kami dengan memberikan detail pesanan Anda. Kami
                    juga menyediakan layanan ekspres dengan biaya tambahan untuk kebutuhan yang mendesak.
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
            <form id="form_pesan" action="{{ url('/saran') }}" method="post">
                <div class="row mb-3">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="nama">NAMA</label>
                            <input type="text" id="nama" name="nama" class="input-kecil">
                            <span class="form-text text-danger error-message"></span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">EMAIL</label>
                            <input type="email" id="email" name="email" class="input-kecil">
                            <span class="form-text text-danger error-message"></span>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-group">
                        <label for="pesan">PESAN</label>
                        <textarea id="pesan" name="pesan" class="input-besar">{{ old('pesan') }}</textarea>
                        <span class="form-text text-danger error-message"></span>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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

        $(".btn-wa-button").hover(function() {
            $(".long-text").addClass("show-long-text");
        }, function() {
            $(".long-text").removeClass("show-long-text");
        });

        $(function() {
            $('#form_pesan').submit(function(event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                var url = $(this).attr('action');
                var formData = new FormData($(this)[0]);

                Swal.fire({
                    title: "Sedang memproses",
                    html: "Mohon tunggu sebentar...",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "JSON",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.close();
                        if (response.errors) {
                            $.each(response.errors, function(key, value) {
                                $('#' + key).next('.error-message').text('*' + value);
                            });
                        } else {
                            $('.error-message').empty();
                            $('#form_pesan')[0].reset();
                            Swal.fire({
                                title: 'Sukses',
                                text: 'Pesan berhasil dikirim',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: false
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.close();
                        Swal.fire({
                            title: 'Error',
                            text: 'Terjadi kesalahan saat mengirim pesan',
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 3000,
                            toast: false
                        });
                    }
                });
            });
        });
    </script>
@endsection
