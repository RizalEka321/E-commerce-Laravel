<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/logo-yokresell.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo-yokresell.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        LOKAL-INDUSTRI | @yield('title')
    </title>

    {{-- CSS File --}}
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/auth/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/auth/css/style-auth.css') }}" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/admin/css/loading.css') }}">
    <script src="{{ asset('assets/admin/js/loading.js') }}"></script>

</head>

<body>
    {{-- Topbar --}}
    {{-- @include('Auth.layout.topbar') --}}
    {{-- End Topbar --}}

    {{-- Main Content --}}
    {{-- Loader --}}
    <div id="loading-container">
        <div id="loading" class="loading"></div>
    </div>
    @yield('content')
    {{-- End Main Content --}}

    {{-- Footer --}}
    {{-- @include('Auth.layout.footer') --}}
    {{-- End Footer --}}

    {{-- JS Files --}}
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/js/glightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@srexi/purecounterjs/dist/purecounter_vanilla.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- JS File --}}
    <script src="{{ asset('assets/auth/js/main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/auth/js/alamat-autocomplete.js') }}"></script>
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
