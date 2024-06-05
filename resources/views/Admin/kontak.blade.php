@extends('Admin.layout.app')
@section('title', 'Kontak')
@section('content')
    {{-- Data Tabel Katalog --}}
    <div id="tambah_data" class="details">
        <div class="content">
            <div class="card border-0">
                <div class="card_header mx-3 pt-1">
                    <h4 class="judul"><i class="fa-solid fa-industry"></i> PROFIL PERUSAHAAN</h4>
                    <hr>
                </div>
                <form id="form_tambah" action="{{ url('/admin/kontak/update') }}" method="POST" enctype="multipart/form-data"
                    role="form">
                    <div class="card-body">
                        <div class="row gx-5 mb-3">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <div id="input_foto" class="form-group">
                                        <label for="foto">Gambar :</label>
                                        <input id="foto" type="file" name="foto" class="form-control"
                                            accept=".jpeg, .png, .jpg">
                                        <span class="form-text text-danger error-message"></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="alamat">Alamat :</label>
                                        <textarea id="alamat" name="alamat" class="form-control" placeholder="Masukkan Alamat" id="alamat">{{ $profil->alamat }}</textarea>
                                        <span class="form-text text-danger error-message"></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="deskripsi">Deskripsi :</label>
                                        <input id="input_deskripsi" type="hidden" name="deskripsi"
                                            value="{{ $profil->deskripsi }}">
                                        <trix-editor input="input_deskripsi" id="deskripsi" class="form-control"
                                            placeholder="Deskripsi"></trix-editor>
                                        <span class="form-text text-danger error-message"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="instagram">Instagram :</label>
                                        <input id="instagram" type="text" name="instagram"
                                            value="{{ $kontak->instagram }}" class="form-control" placeholder="Instagram"
                                            autofocus>
                                        <span class="form-text text-danger error-message"></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="whatsapp">Whastapp :</label>
                                        <input id="whatsapp" type="text" name="whatsapp" value="{{ $kontak->whatsapp }}"
                                            class="form-control" placeholder="Whatsapp" autofocus>
                                        <span class="form-text text-danger error-message"></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="email">Email :</label>
                                        <input id="email" type="email" name="email" value="{{ $kontak->email }}"
                                            class="form-control" placeholder="Email" autofocus>
                                        <span class="form-text text-danger error-message"></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="facebook">Facebook :</label>
                                        <input id="facebook" type="text" name="facebook" value="{{ $kontak->facebook }}"
                                            class="form-control" placeholder="Facebook" autofocus>
                                        <span class="form-text text-danger error-message"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" id="btn-simpan" class="btn-tambah"><i
                                    class="nav-icon fas fa-save"></i>&nbsp;&nbsp; SIMPAN</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        // Global Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Fungsi Tambah
        $(function() {
            $('#form_tambah').submit(function(event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                var url = $(this).attr('action');
                var formData = new FormData($(this)[0]);

                Swal.fire({
                    title: "Menyimpan Data",
                    html: "Mohon tunggu sebentar...",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "JSON",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        Swal.close();
                        $('.error-message').empty();
                        if (data.errors) {
                            console.log(data);
                            $.each(data.errors, function(key, value) {
                                $('#' + key).next('.error-message').text('*' + value);
                            });
                        } else {
                            Swal.fire({
                                title: 'Sukses',
                                text: 'Data berhasil disimpan',
                                icon: 'success',
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: true
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.close();
                        Swal.fire({
                            title: 'Upss..!',
                            text: 'Terjadi kesalahan jaringan error message: ' +
                                errorThrown,
                            icon: 'error',
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            toast: true
                        });
                    }
                });
            });
        });
    </script>
@endsection
