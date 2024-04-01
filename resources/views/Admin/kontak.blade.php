@extends('admin.layout.app')
@section('title', 'Kontak')
@section('content')
    {{-- Data Tabel Katalog --}}
    <div id="tambah_data" class="details">
        <div class="content">
            <div class="card border-0">
                <div class="card_header mx-3 pt-1">
                    <h4 class="judul"><i class="fa-solid fa-address-book"></i> KONTAK PERUSAHAAN</h4>
                    <hr>
                </div>
                <form id="form_tambah" action="{{ url('/admin/kontak/update') }}" method="POST" enctype="multipart/form-data"
                    role="form">
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="instagram">Instagram :</label>
                                <input id="instagram" type="text" name="instagram" value="{{ $kontak->instagram }}"
                                    class="form-control" placeholder="Instagram" autofocus>
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

        function reset_errors() {
            $('.error-message').empty();
        }

        // Fungsi Tambah
        $(function() {
            $('#form_tambah').submit(function(event) {
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
                            console.log(data)
                            $.each(data.errors, function(key, value) {
                                // Show error message below each input
                                $('#' + key).next('.error-message').text('*' + value);
                            });
                            Swal.fire("Error", "Datanya ada yang kurang", "error");
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
    </script>
@endsection
