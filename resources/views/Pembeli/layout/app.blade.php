<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/pembeli/img/logo-yokresell.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/pembeli/img/logo-yokresell.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Lokal Industri | @yield('title')
    </title>

    {{-- CSS File --}}
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="{{ url('assets/plugins/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ url('assets/plugins/fontawesome/css/all.min.css') }}">
    {{-- Bootstrap --}}
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    {{-- OwlCarousel --}}
    <link href="{{ asset('assets/plugins/OwlCarousel2-2.3.4/css/owl.carousel.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/OwlCarousel2-2.3.4/css/owl.carousel.min.css') }}" rel="stylesheet" />
    {{-- Style Sendiri --}}
    <link href="{{ asset('assets/pembeli/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/pembeli/css/style-home.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/pembeli/css/style-produk.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/pembeli/css/style-detail-produk.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/pembeli/css/style-pesanan-saya.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/pembeli/css/style-profile.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/css/loading.css') }}" rel="stylesheet">
    <script type="text/javascript" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
</head>

<body>
    {{-- Loader --}}
    <div id="loading-container">
        <div id="loading" class="loading"></div>
    </div>

    {{-- Navbar --}}
    @include('Pembeli.layout.navbar')
    {{-- End Navbar --}}

    {{-- Main Content --}}
    @yield('content')
    {{-- End Main Content --}}

    {{-- Footer --}}
    @include('Pembeli.layout.footer')
    {{-- End Footer --}}

    {{-- JS Files --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
        integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/js/glightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@srexi/purecounterjs/dist/purecounter_vanilla.js"></script>
    <script src="{{ asset('assets/plugins/OwlCarousel2-2.3.4/js/owl.carousel.js') }}"></script>
    <script src="{{ asset('assets/plugins/OwlCarousel2-2.3.4/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/pembeli/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/admin/preview_img.js') }}"></script>
    <script src="{{ asset('assets/js/admin/preview_berkas.js') }}"></script>
    @yield('script')
    <script>
        function loading() {
            const loadingContainer = document.getElementById("loading-container");
            const loading = document.getElementById('loading');

            loadingContainer.style.display = "none";
            loadingContainer.classList.add("hidden");
        }
        window.addEventListener('load', loading);
    </script>
</body>

</html>
