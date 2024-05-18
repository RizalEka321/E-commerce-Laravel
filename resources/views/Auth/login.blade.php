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
                    <div class="judul text-center">
                        <h1>Login</h1>
                    </div>
                    <div class="row mt-4">
                        <form class="formLogin" id="form_login" method="POST" action="{{ url('/dologin') }}">
                            <div class="mb-4">
                                <div class="form-group inputan">
                                    <label for="username">Username</label>
                                    <input type="text" id="username" name="username" placeholder="Username"
                                        autofocus="username">
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="form-group inputan">
                                    <label for="password">Password</label>
                                    <div class="password-input">
                                        <input type="password" name="password" id="password" placeholder="Password">
                                        <span class="form-text text-danger error-message"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mb-2">
                                <button type="submit" class="btn">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="btn-belum text-center">
                        <p>Belum Punya Akun? <a class="btn-daflog" href="{{ route('register') }}">Daftar</a></p>
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
            $('#form_login').attr('action', "{{ url('/dologin') }}");
            $('#form_login')[0].reset();
            $('.error-message').empty();
        }

        function togglePasswordVisibility() {
            var passwordField = document.getElementById("password");
            var icon = document.querySelector(".password-toggle i");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        // Fungsi login
        $(function() {
            $('#form_login').submit(function(event) {
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
