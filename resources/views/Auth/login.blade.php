@extends('Auth.layout.app')
@section('title', 'Login')
@section('content')
    <div class="container mt-5">
        <div class="container-fluid">
            <div class="row main-content">
                <div class="col-md-4 text-center company__info">
                    <img src="{{ asset('assets/admin/img/Logo_Lokal.png') }}" alt="LogoLokal">
                </div>
                <div class="col-md-8 col-xs-12 col-sm-12">
                    <div class="container">
                        <div class="row text-center">
                            <h2>Log In</h2>
                        </div>
                        <div class="row mt-2">
                            <form class="formLogin" id="form_login" method="POST" action="{{ url('/dologin') }}">
                                <div class="mb-3">
                                    <div class="form-group inputan">
                                        <input type="text" id="username" name="username" placeholder="Masukkan Username"
                                            autofocus="username">
                                        <span class="form-text text-danger error-message"></span>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="form-group inputan">
                                        <input type="password" name="password" id="password"
                                            placeholder="Masukkan Password">
                                        <span class="form-text text-danger error-message"></span>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn">Login</button>
                                </div>
                            </form>
                        </div>
                        <div class="row text-center">
                            <p>Belum Punya Akun? <a href="{{ route('register') }}">Daftar</a></p>
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
            $('#form_login').attr('action', "{{ url('/dologin') }}");
            $('#form_login')[0].reset();
            $('.error-message').empty();
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
