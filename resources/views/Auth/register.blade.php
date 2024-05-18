@extends('Auth.layout.app')
@section('title', 'Login')
@section('content')
    <section class="auth">
        <div class="konten_auth">
            <a class="text-center" href="{{ route('home') }}">
                <img src="{{ asset('assets/pembeli/img/logo_auth.png') }}" alt="" width="300px" height="70px">
            </a>
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <h1>Register</h1>
                    </div>
                    <div class="row mt-4">
                        <form class="formLogin" id="form_register" method="POST" action="{{ url('/doregister') }}">
                            <div class="mb-3">
                                <div class="form-group inputan">
                                    <label for="nama_lengkap">Nama Lengkap</label>
                                    <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan Nama"
                                        autofocus="nama_lengkap">
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
                                    <input type="text" id="email" name="email" placeholder="Masukkan Email"
                                        autofocus="email">
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-group inputan">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" placeholder="Masukkan Password">
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="form-group inputan">
                                    <label for="password_confirmation">Konfirmasi Password :</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        placeholder="Masukkan Password">
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                            <div class="text-center mb-2">
                                <button type="submit" class="btn">Daftar</button>
                            </div>
                        </form>
                    </div>
                    <div class="row text-center">
                        <p>Punya Akun? <a class="btn-daflog" href="{{ route('login') }}">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
