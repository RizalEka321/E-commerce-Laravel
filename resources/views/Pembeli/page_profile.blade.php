@extends('Pembeli.layout.app')
@section('title', 'Profile')
@section('content')
    <section class="profile">
        <div class="container">
            <div class="row">
                <div class="container pt-4">
                    <div class="col-lg-20">
                        <div class="row bg-white rounded">
                            <div class="col-md-4 col-lg-4 order-md-2">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <div class="text-center px-5">
                                                @if (Auth::user()->foto == null)
                                                    <img src="{{ asset('assets/pembeli/img/default.png') }}"
                                                        class="rounded img-fluid preview"
                                                        style="width: 100%; height: 250px; object-fit: cover" />
                                                @else
                                                    <img src="{{ asset(Auth::user()->foto) }}"
                                                        class="rounded img-fluid preview"
                                                        style="width: 100%; height: 250px; object-fit: cover" />
                                                @endif
                                                <h5 class="my-3">{{ Auth::user()->nama_depan }}</h5>
                                                <p class="text-muted text-center mb-3">
                                                    {{ '@' . Auth::user()->username }}
                                                </p>
                                                <form id="form_foto" action="{{ url('/profile/update-foto') }}"
                                                    method="post" enctype="multipart/form-data">
                                                    <div class="d-flex justify-content-center mb-2">
                                                        <input type="file" accept="image/*"
                                                            class="form-control text-muted @error('foto') is-invalid @enderror"
                                                            name="foto" id="foto" aria-describedby="avatarHelp"
                                                            style="display: none" onchange="PreviewImage()">
                                                        <input type="button" value="Ubah Avatar" class="btn-profile ms-1"
                                                            onclick="document.getElementById('foto').click();" />
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-8 order-md-1">
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
                                                    <input type="text" class="form-control" name="username"
                                                        id="username" value="{{ Auth::user()->username }}" disabled>
                                                    <span class="form-text text-danger error-message"></span>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="email" class="form-label"
                                                        style="font-weight: 700">Email</label>
                                                    <input type="email" class="form-control" name="email" id="email"
                                                        value="{{ Auth::user()->email }}" disabled>
                                                    <span class="form-text text-danger error-message"></span>
                                                </div>
                                                <div class="mb-4">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn-profile" data-bs-toggle="modal"
                                                        data-bs-target="#passwordModal">
                                                        Ubah Password
                                                    </button>
                                                </div>
                                                <div class="mb-4">
                                                    <label for="no_hp" class="form-label"
                                                        style="font-weight: 700">Telepon</label>
                                                    <input type="no_hp" class="form-control" name="no_hp" id="no_hp"
                                                        value="{{ Auth::user()->no_hp }}">
                                                    <span class="form-text text-danger error-message"></span>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="alamat" class="form-label"
                                                        style="font-weight: 700">Alamat</label>
                                                    <textarea id="alamat" name="alamat" class="form-control" placeholder="Masukkan Alamat" id="alamat">{{ Auth::user()->alamat }}</textarea>
                                                    <span class="form-text text-danger error-message"></span>
                                                </div>
                                                <button type="submit" class="btn-profile">
                                                    <i class="nav-icon fas fa-save"></i>
                                                    Simpan
                                                </button>
                                            </div>
                                        </form>
                                        <!-- Modal -->
                                        <div class="modal fade" id="passwordModal" tabindex="-1"
                                            aria-labelledby="ModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="ModalLabel">
                                                            Ubah Password</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="form_password"
                                                            action="{{ url('/profile/update-password') }}"
                                                            method="POST">
                                                            <div class="mb-3">
                                                                <div class="form-group inputan">
                                                                    <label for="password">Password Baru</label>
                                                                    <input type="password" name="password" id="password"
                                                                        class="form-control"
                                                                        placeholder="Masukkan Password">
                                                                    <span
                                                                        class="form-text text-danger error-message"></span>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <div class="form-group inputan">
                                                                    <label for="password_confirmation">Konfirmasi
                                                                        Password :</label>
                                                                    <input type="password" id="password_confirmation"
                                                                        name="password_confirmation" class="form-control"
                                                                        placeholder="Masukkan Password">
                                                                    <span
                                                                        class="form-text text-danger error-message"></span>
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

        // Reset validasi
        function reset_errors() {
            $('.error-message').empty();
        }

        $(function() {
            $('#form_profile').submit(function(event) {
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
                                'Data berhasil disimpan',
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
