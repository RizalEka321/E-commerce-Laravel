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
    {{-- Bootstrap --}}
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    {{-- AOS Animate --}}
    <link rel="stylesheet" href="{{ url('assets/plugins/aos/css/aos.css') }}">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="{{ url('assets/plugins/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ url('assets/plugins/fontawesome/css/all.min.css') }}">
    {{-- OwlCarousel --}}
    <link href="{{ asset('assets/plugins/OwlCarousel2-2.3.4/css/owl.carousel.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/OwlCarousel2-2.3.4/css/owl.carousel.min.css') }}" rel="stylesheet" />
    {{-- Style Sendiri --}}
    <link href="{{ asset('assets/pembeli/css/variable.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/pembeli/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/pembeli/css/style-home.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/pembeli/css/style-produk.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/pembeli/css/style-detail-produk.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/pembeli/css/style-pesanan-saya.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/pembeli/css/style-profile.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/pembeli/css/style-cart.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/pembeli/css/style-checkout.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/css/loading.css') }}" rel="stylesheet">
    @if (!Request::is('/'))
        <link href="{{ asset('assets/pembeli/css/style-tambahan.css') }}" rel="stylesheet" />
    @endif
    {{-- Data Tables --}}
    <link rel="stylesheet" href="{{ url('assets/plugins/datatables-bs4/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/plugins/datatables-responsive/css/responsive.bootstrap5.min.css') }}">
    {{-- SweetAlert --}}
    <link rel="stylesheet" href="{{ url('assets/plugins/sweetalert/sweetalert2.min.css') }}">
    {{-- Midtrans --}}
    <script type="text/javascript" src="https://app.stg.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.clientKey') }}"></script>

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
    {{-- Bootstrap --}}
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    {{-- Jquery --}}
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    {{-- AOS Animate --}}
    <script src="{{ asset('assets/plugins/aos/js/aos.js') }}"></script>
    {{-- Glightbox --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/js/glightbox.min.js"></script>
    {{-- Vanila --}}
    <script src="https://cdn.jsdelivr.net/npm/@srexi/purecounterjs/dist/purecounter_vanilla.js"></script>
    {{-- OwlCarousel --}}
    <script src="{{ asset('assets/plugins/OwlCarousel2-2.3.4/js/owl.carousel.js') }}"></script>
    <script src="{{ asset('assets/plugins/OwlCarousel2-2.3.4/js/owl.carousel.min.js') }}"></script>
    {{-- JS Sendiri --}}
    <script src="{{ asset('assets/pembeli/js/main.js') }}"></script>
    @if (Request::is('/'))
        <script src="{{ asset('assets/pembeli/js/navbar.js') }}"></script>
    @endif
    <script src="{{ asset('assets/pembeli/js/tab_perusahaan.js') }}"></script>
    {{-- Data Tables --}}
    <script src="{{ url('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('assets/plugins/datatables-bs4/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('assets/plugins/datatables-responsive/js/responsive.bootstrap5.min.js') }}"></script>
    {{-- Sweetalert --}}
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
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
