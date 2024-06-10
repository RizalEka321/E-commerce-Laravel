@extends('Auth.layout.app')
@section('title', 'Verifikasi email')
@section('content')
    <section class="auth">
        <div class="konten_auth">
            <a class="text-center" href="{{ route('home') }}">
                <img src="{{ asset('assets/pembeli/img/logo_auth.png') }}" alt="" width="300px" height="70px">
            </a>
            <div class="card verifikasi">
                <div class="card-body">
                    <div class="atas mb-4">
                        <div class="logo-verifikasi mb-2">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <h5>Registrasi Anda Sudah Berhasil!</h5>
                        <h6>Silahkan periksa email untuk verifikasi akun</h6>
                    </div>
                    <p class="tengah-1">Jika belum ada pesan masuk, silahkan klik tombol dibawah ini untuk mengirimkan pesan
                        verifikasi</p>
                    <div class="tengah-2 mb-4">
                        <form method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn-verifikasi">Kirim</button>.
                        </form>
                    </div>
                    <p class="bawah">Jika masih mengalami kendala pada proses verifikasi silahkan hubungi admin</p>
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

        // Fungsi login
        $(function() {
            $('#form_login').submit(function(event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                var url = $(this).attr('action');
                var formData = new FormData($(this)[0]);

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
                });
            });
        });
    </script>
@endsection
