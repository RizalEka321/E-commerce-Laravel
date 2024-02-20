@extends('auth.layout.app')
@section('title', 'Login')
@section('content')
    <div class="container login">
        <div class="card mt-4 mb-5" data-aos="zoom-in" data-aos-delay="100">
            <div class="row g-0">
                <div class="col-md-6 bg-title d-flex justify-content-center align-items-center">
                    <a href="{{ route('pembeli.dashboard') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" version="1.1"
                            style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd"
                            viewBox="0 0 1245 520" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="Layer_x0020_1">
                                <metadata id="CorelCorpID_0Corel-Layer" />
                                <g id="_1378897322096" class="logo-white">
                                    <path
                                        d="M517.45 169.8c6.71,10.6 10.57,23.02 10.57,36.3 0,38.91 -33.11,70.45 -73.94,70.45 -26.9,0 -50.44,-13.69 -63.38,-34.15 -12.93,20.46 -36.47,34.15 -63.37,34.15 -26.9,0 -50.44,-13.69 -63.38,-34.15 -12.93,20.46 -36.47,34.15 -63.37,34.15 -26.9,0 -50.44,-13.69 -63.37,-34.15 -12.94,20.46 -36.48,34.15 -63.38,34.15 -40.83,0 -73.94,-31.54 -73.94,-70.45 0,-13.28 3.86,-25.7 10.57,-36.3l78.91 -124.44c4.71,-7.43 12.57,-11.65 21.73,-11.65 101.9,0 203.8,0 305.71,0 9.16,0 17.02,4.22 21.73,11.65l78.91 124.44zm-507 350.02c190.13,-37.24 316.88,-37.24 507,0 -121.67,-74.49 -385.31,-74.49 -507,0zm466.9 -231.37l-13.32 189.39c-114,-41.09 -286.15,-41.09 -400.16,0l-13.31 -189.39c7.32,2.45 15.14,3.77 23.27,3.77 6.64,0 13.07,-0.88 19.18,-2.54l6.22 88.17c0.37,5.2 2.78,9.52 7.01,12.56 4.23,3.04 9.09,3.94 14.12,2.62 85.73,-22.45 201.83,-22.45 287.18,-0.02 5.03,1.32 9.9,0.42 14.12,-2.62 4.23,-3.04 6.65,-7.36 7.02,-12.57l6.22 -88.13c6.11,1.65 12.54,2.53 19.18,2.53 8.13,0 15.95,-1.32 23.27,-3.77zm-366.25 -271.5l305.71 0 0 -8.39c0,-4.62 -7.59,-8.38 -16.9,-8.38l-271.91 0c-9.31,0 -16.9,3.76 -16.9,8.38l0 8.39z" />
                                    <g transform="matrix(1 0 0 1 -87.9943 -16.2203)">
                                        <text x="622.5" y="260">Yok</text>
                                    </g>
                                    <g transform="matrix(1 0 0 1 -87.9943 -16.2203)">
                                        <text x="622.5" y="501.26">Resell</text>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </a>
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h2 class="card-title px-4 pt-4">Login</h2>
                        <form class="p-4" method="POST" action="#">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter your email" required autofocus="email">
                            </div>
                            <div>
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Enter your password" required>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn-login">Login</button>
                                <p>Tidak Punya Akun? <a href="#" class="btn-daftar">Daftar</a></p>
                            </div>
                            {{-- <div class="text-center">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="btn-daftar">Lupa password?</a>
                                @endif
                            </div> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
