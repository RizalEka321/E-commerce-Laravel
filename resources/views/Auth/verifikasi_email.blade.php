@extends('Auth.layout.app')
@section('title', 'Verifikasi email')
@section('content')
    <div class="container mt-3">
        <a href="{{ route('home') }}">
            <img src="{{ asset('assets/pembeli/img/logonavbar_hitam.png') }}" alt="" width="300px" height="70px">
        </a>
        <div class="container">
            <div class="konten_verifikasi">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="mb-1">
                            <h4>Verifikasi Email Anda</h4>
                        </div>
                        <p>Sebelum melanjutkan, kami mohon Anda memeriksa kotak masuk email Anda untuk menemukan tautan
                            verifikasi
                            yang telah kami kirimkan. Jika Anda tidak menemukan email tersebut,</p>
                        <form method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <p>Anda dapat meminta kami mengirimkan email verifikasi kembali dengan</p>
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">klik di sini</button>.
                        </form>
                        <br>
                        <p>Jika Anda masih mengalami masalah dengan verifikasi, silakan hubungi tim dukungan kami.</p>
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
