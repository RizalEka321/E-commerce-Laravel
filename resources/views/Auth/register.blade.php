@extends('Auth.layout.app')
@section('title', 'Login')
@section('content')
    <div class="container mt-5">
        <div class="container-fluid">
            <div class="row main-content bg-success">
                <div class="col-md-4 text-center company__info">
                    <img src="{{ asset('assets/admin/img/Logo_Lokal.png') }}" alt="LogoLokal">
                </div>
                <div class="col-md-8 col-xs-12 col-sm-12 login_form ">
                    <div class="container-fluid">
                        <div class="row text-center">
                            <h2>Register</h2>
                        </div>
                        <div class="row">
                            <form id="form_register" method="POST" action="{{ url('/doregister') }}">
                                <div class="mb-3">
                                    <div class="form-group inputan">
                                        <label for="nama_lengkap">Nama Lengkap</label>
                                        <input type="text" id="nama_lengkap" name="nama_lengkap"
                                            placeholder="Masukkan Nama" autofocus="nama_lengkap">
                                        <span class="form-text text-danger error-message"></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group inputan">
                                        <label for="username">Username</label>
                                        <input type="text" id="username" name="username" placeholder="Masukkan Username"
                                            autofocus="username">
                                        <span class="form-text text-danger error-message"></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group inputan">
                                        <label for="email">Email</label>
                                        <input type="email" id="email" name="email" placeholder="Masukkan Email"
                                            autofocus="username">
                                        <span class="form-text text-danger error-message"></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group inputan">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password"
                                            placeholder="Masukkan Password">
                                        <span class="form-text text-danger error-message"></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group inputan">
                                        <label for="password_confirmation">Konfirmasi Password :</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            placeholder="Masukkan Password">
                                        <span class="form-text text-danger error-message"></span>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn">Daftar</button>
                                </div>
                            </form>
                        </div>
                        <div class="row text-center">
                            <a href="{{ route('login') }}">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function reset_form() {
            $('#form_register').attr('action', "{{ url('/doregister') }}");
            $('#form_register')[0].reset();
            $('.error-message').empty();
        }

        // Fungsi login
        $(function() {
            $('#form_register').submit(function(event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                var url = $(this).attr('action');
                var formData = new FormData($(this)[0]);

                // showLoading();
                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "JSON",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        $('.error-message').empty();
                        if (data.errors) {
                            $.each(data.errors, function(key, value) {
                                // Show error message below each input
                                $('#' + key).next('.error-message').text('*' + value);
                            });
                        } else if (data.error) {
                            Swal.fire("Error", data.error, "error");
                        } else {
                            window.location.href = data.redirect;
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                    },
                    complete: function() {
                        // hideLoading();
                    }
                });
            });
        });
    </script>
@endsection
