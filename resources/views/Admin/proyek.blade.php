@extends('Admin.layout.app')
@section('title', 'Proyek')
@section('content')
    {{-- Data Tabel proyek --}}
    <div id="datane" class="details">
        <div class="content">
            <div class="container">
                <div class="card_header pt-1">
                    <h4 class="judul"><i class="fa-solid fa-cube"></i> DATA PROYEK</h4>
                    <hr>
                </div>
                @if (Auth::user()->role == 'Pegawai')
                    <a type="button" class="btn-tambah mb-2" id="btn-add"><i
                            class="fa-solid fa-square-plus"></i>&nbsp;&nbsp;
                        TAMBAH DATA PROYEK</a>
                @endif
                <table id="tabel_proyek" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th width="15%">Aksi</th>
                            <th width="5%">No</th>
                            <th width="20%">Instansi</th>
                            <th width="10%">Jumlah</th>
                            <th width="15%">Total</th>
                            <th width="15%">Pembayaran</th>
                            <th width="20%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- Form Tambah Data --}}
    <div id="tambah_data" class="details hidden">
        <div class="content">
            <div class="card border-0">
                <div class="card_header mx-3 pt-1">
                    <h4 class="judul"><i class="fa-solid fa-cube"></i> TAMBAH DATA MOBIL</h4>
                    <hr>
                </div>
                <form id="form_tambah" action="{{ url('/admin/proyek/create') }}" method="POST"
                    enctype="multipart/form-data" role="form">
                    <div class="card-body">
                        <div class="row gx-5 mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label for="nama_pemesan">Nama Pemesan :</label>
                                    <input id="nama_pemesan" type="text" name="nama_pemesan"
                                        value="{{ old('nama_pemesan') }}" class="form-control" placeholder="Masukkan Nama">
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="instansi">Perusahan/instansi :</label>
                                    <input id="instansi" type="text" name="instansi" value="{{ old('instansi') }}"
                                        class="form-control" placeholder="Masukkan Nama Instansi">
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row gx-5 mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label for="no_hp">No Handphone(HP) :</label>
                                    <input id="no_hp" type="text" name="no_hp" value="{{ old('no_hp') }}"
                                        class="form-control" placeholder="Masukkan No HP">
                                    <span class="form-text text-danger error-message"></span>

                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="alamat">Alamat :</label>
                                    <textarea id="alamat" name="alamat" class="form-control" placeholder="Masukkan Alamat" id="alamat">{{ old('alamat') }}</textarea>
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row gx-5 mb-3 hidden">
                            <div class="col">
                                <div class="form-group">
                                    <label for="item">Item :</label>
                                    <input id="item" type="text" name="item" value="{{ old('item') }}"
                                        class="form-control" placeholder="Masukkan item yang dipesan">
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="deadline">Deadline Proyek :</label>
                                    <input id="deadline" type="date" name="deadline" value="{{ old('deadline') }}"
                                        class="form-control" placeholder="Masukkan Deadline Proyek">
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row gx-5 mb-3 hidden">
                            <div class="col">
                                <div class="form-group">
                                    <label for="foto_logo">Gambar Logo :</label>
                                    <input id="foto_logo" type="file" name="foto_logo" class="form-control"
                                        accept=".jpeg, .png, .jpg">
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="foto_desain">Gambar Desain :</label>
                                    <input id="foto_desain" type="file" name="foto_desain" class="form-control"
                                        accept=".jpeg, .png, .jpg">
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="deskripsi_proyek">Deskripsi :</label>
                                <input id="input_deskripsi_proyek" type="hidden" name="deskripsi_proyek"
                                    value="{{ old('deskripsi_proyek') }}">
                                <trix-editor input="input_deskripsi_proyek" id="deskripsi_proyek" class="form-control"
                                    placeholder="Deskripsi"></trix-editor>
                                <span class="form-text text-danger error-message"></span>
                            </div>
                        </div>
                        <div class="row gx-5 mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label for="jumlah">Jumlah :</label>
                                    <input id="jumlah" type="number" name="jumlah" value="{{ old('jumlah') }}"
                                        class="form-control" max="9999" placeholder="Masukkan jumlah">
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="harga_satuan">Harga Satuan :</label>
                                    <input id="harga_satuan" type="text" name="harga_satuan"
                                        value="{{ old('harga_satuan') }}" class="form-control"
                                        placeholder="Masukkan Harga Satuan">
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                        </div>
                        <div id="input_dp" class="mb-5">
                            <div class="form-group">
                                <label for="nominal_dp">DP Proyek(opsional) :</label>
                                <input id="nominal_dp" type="text" name="nominal_dp" value="{{ old('nominal_dp') }}"
                                    class="form-control" placeholder="Masukkan DP Proyek">
                                <span class="form-text text-danger error-message"></span>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div>
                            <a type="button" id="btn-close" class="btn-hapus"><i
                                    class='nav-icon fas fa-arrow-left'></i>&nbsp;&nbsp; KEMBALI</a>
                            <button type="submit" id="btn-simpan" class="btn-tambah"><i
                                    class="nav-icon fas fa-save"></i>&nbsp;&nbsp; TAMBAH</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        // Button
        $('#btn-add').click(function() {
            $('#tambah_data').removeClass('hidden');
            $('#datane').addClass('hidden');
            $('.judul').html(
                '<h4 class="judul"><i class="fa-solid fa-cube"></i> TAMBAH DATA PROYEK</h4>');
            $('#input_dp').removeClass('hidden');
            $('#input_foto').removeClass('hidden');

        });
        $('#btn-close').click(function() {
            $('#datane').removeClass('hidden');
            $('#tambah_data').addClass('hidden');
            $('.judul').html(
                '<h4 class="judul"><i class="fa-solid fa-cube"></i> DATA PROYEK</h4>');
            $('#input_dp').removeClass('hidden');
            $('#input_foto').removeClass('hidden');
            reset_form();
        });

        // Global Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function reload_table() {
            $('#tabel_proyek').DataTable().ajax.reload();
        }

        function reset_form() {
            $('#form_tambah').attr('action', "{{ url('/admin/proyek/create') }}");
            $('#form_tambah')[0].reset();
        }

        // Fungsi index
        $(function() {
            var table = $('#tabel_proyek').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                orderClasses: false,
                info: false,
                ajax: "{{ url('/admin/proyek/list') }}",
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true,
                        className: 'text-center'
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center'
                    },
                    {
                        data: 'instansi',
                        name: 'instansi',
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah',
                        className: 'text-center'
                    },
                    {
                        data: 'total',
                        name: 'total',
                        render: function(data, type, full, meta) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(full.total);
                        }
                    },
                    {
                        data: 'pembayaran',
                        name: 'pembayaran',
                    },
                    {
                        data: 'pengerjaan',
                        name: 'pengerjaan',
                    }
                ]
            });
        });

        // Fungsi Tambah
        $(function() {
            $('#form_tambah').submit(function(event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                var url = $(this).attr('action');
                var formData = new FormData($(this)[0]);

                Swal.fire({
                    title: "Sedang memproses",
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
                    success: function(response) {
                        Swal.close();
                        $('.error-message').empty();
                        if (response.errors) {
                            $.each(response.errors, function(key, value) {
                                $('#' + key).next('.error-message').text('*' + value);
                            });
                            Swal.fire({
                                title: 'Error',
                                html: 'Terjadi kesalahan pada data yang dimasukkan.',
                                icon: 'error',
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: true
                            });
                        } else {
                            reset_form();
                            $('#datane').removeClass('hidden');
                            $('#tambah_data').addClass('hidden');
                            Swal.fire({
                                title: 'Sukses',
                                text: 'Data berhasil disimpan',
                                icon: 'success',
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: true
                            });
                            reload_table();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.close();
                        Swal.fire({
                            title: 'Error',
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

        // Fungsi Edit dan Update
        function edit_data(id) {
            $('#form_tambah')[0].reset();
            $('#form_tambah').attr('action', '/admin/proyek/update?q=' + id);

            Swal.fire({
                title: "Sedang memproses",
                html: "Mohon tunggu sebentar...",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "{{ url('/admin/proyek/edit') }}",
                type: "POST",
                data: {
                    q: id
                },
                dataType: "JSON",
                success: function(response) {
                    Swal.close();
                    var isi = response.proyek;
                    $('#nama_pemesan').val(isi.nama_pemesan);
                    $('#instansi').val(isi.instansi);
                    $('#no_hp').val(isi.no_hp);
                    $('#alamat').val(isi.alamat);
                    $('#item').val(isi.item);
                    $('#deadline').val(isi.deadline);
                    $('#jumlah').val(isi.jumlah);
                    $('#harga_satuan').val(isi.harga_satuan);
                    if (isi.foto_logo) {
                        $('#foto_logo').text(isi.foto_logo);
                    }
                    if (isi.foto_desain) {
                        $('#foto_desain').text(isi.foto_desain);
                    }
                    var editor = document.getElementById('deskripsi_proyek');
                    editor.editor.loadHTML(isi.deskripsi_proyek);
                    $('#input_dp').addClass('hidden');
                    $('#tambah_data').removeClass('hidden');
                    $('#datane').addClass('hidden');
                    $('.judul').html(
                        '<h4 class="judul"><i class="fa-solid fa-cube"></i> EDIT DATA PROYEK</h4>');
                    $('#btn-simpan').html(
                        '<i class="nav-icon fas fa-save"></i>&nbsp;&nbsp; SIMPAN');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.close();
                    Swal.fire({
                        title: 'Error',
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
        }

        // Fungsi Hapus
        function delete_data(id) {
            Swal.fire({
                title: 'Hapus proyek',
                text: "Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Sedang memproses",
                        html: "Mohon tunggu sebentar...",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: "{{ url('/admin/proyek/delete') }}",
                        type: "POST",
                        data: {
                            q: id
                        },
                        dataType: "JSON",
                        success: function(response) {
                            Swal.close();
                            Swal.fire({
                                title: 'Hapus!',
                                text: 'Proyek berhasil Dihapus',
                                icon: 'success',
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: true
                            });
                            reload_table();
                        },
                        error: function(xhr, status, error) {
                            Swal.close();
                            Swal.fire({
                                title: 'Error',
                                text: 'Terjadi kesalahan jaringan: ' + errorThrown,
                                icon: 'error',
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: true
                            });
                        }
                    });
                }
            });
        }

        $(document).on('change', '.pengerjaan-dropdown', function() {
            var status = $(this).val();
            var id = $(this).data('id');

            Swal.fire({
                title: "Sedang memproses",
                html: "Mohon tunggu sebentar...",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '/admin/proyek/update-pengerjaan',
                method: 'POST',
                data: {
                    status_pengerjaan: status,
                    id: id
                },
                success: function(response) {
                    Swal.close();
                    Swal.fire({
                        title: 'Sukses',
                        text: 'Status pengerjaan berhasil diubah',
                        icon: 'success',
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        toast: true
                    });
                    reload_table();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.close();
                    Swal.fire({
                        title: 'Error',
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

        $(document).on('change', '.pembayaran-dropdown', function() {
            var status = $(this).val();
            var id = $(this).data('id');

            Swal.fire({
                title: "Sedang memproses",
                html: "Mohon tunggu sebentar...",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '/admin/proyek/update-pembayaran',
                method: 'POST',
                data: {
                    status_pembayaran: status,
                    id: id
                },
                success: function(response) {
                    Swal.close();
                    Swal.fire({
                        title: 'Sukses',
                        text: 'Status pembayaran berhasil diubah',
                        icon: 'success',
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        toast: true
                    });
                    reload_table();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.close();
                    Swal.fire({
                        title: 'Error',
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


        $(document).ready(function() {
            function calculateDP() {
                var jumlah = parseInt($('#jumlah').val()) || 0;
                var hargaSatuan = parseInt($('#harga_satuan').val()) || 0;
                var dp = jumlah * hargaSatuan * 0.5;

                dp = Math.round(dp);

                $('#nominal_dp').val(dp);
            }

            $('#jumlah, #harga_satuan').on('input', function() {
                calculateDP();
            });
        });
    </script>
@endsection
