@extends('Auth.layout.app')
@section('title', 'Login')
@section('content')

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="">
        <title>Login Admin</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/auth/css/login.css') }}">
    </head>

    <body>
        <!-- Main Content -->
        <div class="container-fluid">
            <div class="row main-content bg-success text-center">
                <div class="col-md-4 text-center company__info">
                    <img src="{{ asset('assets/admin/img/Logo_Lokal.png') }}" alt="LogoLokal">
                </div>
                <div class="col-md-8 col-xs-12 col-sm-12 login_form ">
                    <div class="container-fluid">
                        <div class="row">
                            <h2>Log In</h2>
                        </div>
                        <div class="row">
                            <form control="" class="form-group" method="POST" action="{{ route('dologin') }}">
                                @csrf
                                <div class="row">
                                    <input type="text" class="form__input" id="username" name="username"
                                        placeholder="Enter your username" required autofocus="username">
                                </div>
                                <div class="row">
                                    <!-- <span class="fa fa-lock"></span> -->
                                    <input type="password" name="password" id="password" class="form__input"
                                        placeholder="Enter your password" required>
                                </div>
                                <div class="row">
                                    <input type="submit" value="Login" class="btn">
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <p>Tidak Punya Akun? <a href="#">Daftar</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection
