@extends('Pembeli.layout.app')
@section('title', 'Profile')
@section('content')
    <section class="profile">
        <h1 class="title">Akun Pengguna</h1>
        <div class="container">
            <div class="konten">
                <div class="row">
                    <div class="col-md-4 col-lg-4 order-md-1">
                        <div class="card">
                            <div class="card-body">
                                <div class="foto-profil">
                                    @if (Auth::user()->foto == null)
                                        <img src="{{ asset('assets/pembeli/img/default.png') }}" class="preview" />
                                    @else
                                        <img src="{{ asset(Auth::user()->foto) }}" class="preview" />
                                    @endif
                                    <form id="form_foto" action="{{ url('/profile/update-foto') }}" method="post"
                                        enctype="multipart/form-data">
                                        <div class="d-flex justify-content-center mb-2">
                                            <input type="file" accept="image/*" class="form-control" name="foto"
                                                id="foto" style="display: none">
                                            <button type="button" class="btn-profile ms-1" id="ubahAvatarBtn">Ubah
                                                Avatar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-8 order-md-2">
                        <div class="card">
                            <div class="card-body">
                                <form id="form_profile" action="{{ url('/profile/update') }}" method="POST">
                                    <div class="mb-4">
                                        <div class="mb-4">
                                            <div class="form-group">
                                                <label for="nama" class="form-label"
                                                    style="font-weight: 700">Nama</label>
                                                <input type="text" class="form-control" name="nama_lengkap"
                                                    id="nama_lengkap" value="{{ Auth::user()->nama_lengkap }}">
                                                <span class="form-text text-danger error-message"></span>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="username" class="form-label"
                                                style="font-weight: 700">Username</label>
                                            <input type="text" class="form-control" name="username" id="username"
                                                value="{{ Auth::user()->username }}" disabled>
                                            <span class="form-text text-danger error-message"></span>
                                        </div>
                                        <div class="mb-2">
                                            <label for="email" class="form-label" style="font-weight: 700">Email</label>
                                            <input type="email" class="form-control" name="email" id="email"
                                                value="{{ Auth::user()->email }}" disabled>
                                            <span class="form-text text-danger error-message"></span>
                                        </div>
                                        <div class="mb-4">
                                            <label for="password" class="form-label"
                                                style="font-weight: 700">Password</label>
                                            <button type="button" class="btn-password" data-bs-toggle="modal"
                                                data-bs-target="#passwordModal">
                                                Ubah Password <i class="fa-solid fa-chevron-up"></i>
                                            </button>
                                        </div>
                                        <div class="mb-4">
                                            <label for="no_hp" class="form-label"
                                                style="font-weight: 700">Telepon</label>
                                            <input type="no_hp" class="form-control" name="no_hp" id="no_hp"
                                                value="{{ Auth::user()->no_hp }}">
                                            <span class="form-text text-danger error-message"></span>
                                        </div>
                                        <div>
                                            <label for="alamat" class="form-label" style="font-weight: 700">Alamat</label>
                                            <textarea id="alamat" name="alamat" class="form-control" placeholder="Masukkan Alamat" id="alamat">{{ Auth::user()->alamat }}</textarea>
                                            <span class="form-text text-danger error-message"></span>
                                        </div>
                                    </div>
                                </form>
                                <!-- Modal -->
                                <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="ModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="ModalLabel">
                                                    Ubah Password</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="form_password" action="{{ url('/profile/update-password') }}"
                                                    method="POST">
                                                    <div class="mb-3">
                                                        <div class="form-group inputan">
                                                            <label for="password">Password Baru</label>
                                                            <input type="password" name="password" id="password"
                                                                class="form-control" placeholder="Masukkan Password">
                                                            <span class="form-text text-danger error-message"></span>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <div class="form-group inputan">
                                                            <label for="password_confirmation">Konfirmasi
                                                                Password :</label>
                                                            <input type="password" id="password_confirmation"
                                                                name="password_confirmation" class="form-control"
                                                                placeholder="Masukkan Password">
                                                            <span class="form-text text-danger error-message"></span>
                                                        </div>
                                                    </div>
                                                    <button type="submit" id="btn-simpan" class="btn-profile"><i
                                                            class="nav-icon fas fa-save"></i>&nbsp;&nbsp;
                                                        Simpan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-2 text-end">
                    <button type="submit" class="btn-profile" id="btn-update">
                        <i class="nav-icon fas fa-save"></i>
                        Simpan
                    </button>
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

        // Reset validasi
        function reset_errors() {
            $('.error-message').empty();
        }

        $('#btn-update').click(function(e) {
            e.preventDefault();
            var url = $('#form_profile').attr('action');
            var formData = new FormData($('#form_profile')[0]);

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
                    } else {
                        Swal.fire(
                            'Sukses',
                            'Profile berhasil diperbarui',
                            'success'
                        );
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

        $(function() {
            $('#form_password').submit(function(event) {
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
                        } else {
                            Swal.fire(
                                'Sukses',
                                'Password berhasil diubah',
                                'success'
                            );
                            $('#form_password')[0].reset();
                            $('#passwordModal').modal('hide');
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

        $('#ubahAvatarBtn').click(function() {
            $('#foto').click();
        });

        $(function() {
            $('#foto').change(function() {
                var url = $('#form_foto').attr('action');
                var formData = new FormData($('#form_foto')[0]);

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
                        } else {
                            Swal.fire(
                                'Sukses',
                                'Foto profile berhasil diubah',
                                'success'
                            );
                            $('.preview').attr('src', data.foto);
                            $('#form_foto')[0].reset();
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
