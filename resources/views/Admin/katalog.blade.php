@extends('admin.layout.app')
@section('title', 'Katalog')
@section('content')
    {{-- Data Tabel Katalog --}}
    <div id="datane" class="details">
        <div class="content">
            <div class="container">
                <div class="card_header pt-1">
                    <h4 class="judul"><i class="fa-solid fa-shirt"></i> DATA KATALOG</h4>
                    <hr>
                </div>
                <a type="button" class="btn-tambah mb-2" id="btn-add"><i class="fa-solid fa-square-plus"></i>&nbsp;&nbsp;
                    TAMBAH DATA KATALOG</a>
                <table id="tabel_katalog" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th width="15%">Aksi</th>
                            <th width="5%">No</th>
                            <th width="32%">Nama</th>
                            <th width="25%">Stok</th>
                            <th width="25%">Harga</th>
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
                    <h4 class="judul"><i class="fa-solid fa-shirt"></i> TAMBAH DATA KATALOG</h4>
                    <hr>
                </div>
                <form id="form_tambah" action="{{ url('/admin/katalog/create') }}" method="POST"
                    enctype="multipart/form-data" class="was-validated" role="form">
                    <div class="card-body">
                        <div class="row gx-5 mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label for="judul">Nama :</label>
                                    <input id="judul" type="text" name="judul" value="{{ old('judul') }}"
                                        class="form-control" placeholder="Nama" required autofocus>
                                    <div class="valid-feedback"><i>*valid</i> </div>
                                    <div class="invalid-feedback"><i>*required</i> </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="stok">Stok :</label>
                                    <input id="stok" type="text" name="stok" value="{{ old('stok') }}"
                                        class="form-control" placeholder="Stok" required autofocus>
                                    <div class="valid-feedback"><i>*valid</i> </div>
                                    <div class="invalid-feedback"><i>*required</i> </div>
                                </div>
                            </div>
                        </div>
                        <div class="row gx-5 mb-3">
                            <div class="col">
                                <div id="input_foto" class="form-group">
                                    <label for="foto">Gambar :</label>
                                    <input id="foto" type="file" name="foto" class="form-control" required
                                        autofocus>
                                    <div class="valid-feedback"><i>*valid</i> </div>
                                    <div class="invalid-feedback"><i>*required</i> </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="harga">Harga:</label>
                                    <input id="harga" type="number" name="harga" value="{{ old('harga') }}"
                                        class="form-control" placeholder="Harga" required autofocus>
                                    <div class="valid-feedback"><i>*valid</i> </div>
                                    <div class="invalid-feedback"><i>*required</i> </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi :</label>
                                <input id="deskripsi" type="hidden" name="deskripsi" value="{{ old('deskripsi') }}">
                                <trix-editor input="deskripsi" id="trix_deskripsi" class="form-control"
                                    placeholder="Deskripsi" required autofocus></trix-editor>
                                <div class="valid-feedback"><i>*valid</i> </div>
                                <div class="invalid-feedback"><i>*required</i> </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
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
                '<h4 class="judul"><TAMBA<i class="fa-solid fa-shirt"></i>TAMBAH DATA KATALOG</h4>');

        });
        $('#btn-close').click(function() {
            $('#datane').removeClass('hidden');
            $('#tambah_data').addClass('hidden');
            $('.judul').html(
                '<h4 class="judul"><i class="fa-solid fa-shirt"></i> DATA KATALOG</h4>');
            reset_form();
        });

        // Global Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function reload_table() {
            $('#tabel_katalog').DataTable().ajax.reload();
        }

        function reset_form() {
            $('#form-add').attr('action', "{{ url('/admin/katalog/create') }}");
            $('#form_tambah')[0].reset();
        }

        // Fungsi index
        $(function() {
            var table = $('#tabel_katalog').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                orderClasses: false,
                info: false,
                ajax: "{{ url('/admin/katalog/list') }}",
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'judul',
                        name: 'judul'
                    },
                    {
                        data: 'stok',
                        name: 'stok',
                    },
                    {
                        data: 'harga',
                        name: 'harga',
                        render: function(data, type, full, meta) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(full.harga);
                        }
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
                            // $.each(data.errors, function(key, value) {
                            //     Swal.fire('Upss..!', value, 'error');
                            // });
                            Swal.fire("Error", "Datanya ada yang kurang", "error");
                        } else {
                            reset_form();
                            $('#datane').removeClass('hidden');
                            $('#tambah_data').addClass('hidden');
                            Swal.fire(
                                'Sukses',
                                'Data berhasil disimpan',
                                'success'
                            );
                            reload_table();
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

        // Fungsi Edit dan Update
        function edit_data(id) {
            $('#form_tambah')[0].reset();
            $('#form_tambah').attr('action', '/admin/katalog/update?q=' + id);
            $.ajax({
                url: "{{ url('/admin/katalog/edit') }}",
                type: "POST",
                data: {
                    q: id
                },
                dataType: "JSON",
                success: function(data) {
                    console.log(data);

                    if (data.status) {
                        var isi = data.isi;
                        $('#judul').val(isi.judul);
                        $('#stok').val(isi.stok);
                        $('#harga').val(isi.harga);
                        // $('#foto').val(isi.foto);
                        var editor = document.getElementById('trix_deskripsi');
                        editor.editor.loadHTML(isi.deskripsi);


                        // $('#input_foto').addClass('hidden');
                        $('#tambah_data').removeClass('hidden');
                        $('#datane').addClass('hidden');
                        $('.judul').html(
                            '<h4 class="judul"><i class="fa-solid fa-shirt"></i> EDIT DATA KATALOG</h4>');
                        $('#btn-simpan').html(
                            '<i class="nav-icon fas fa-save"></i>&nbsp;&nbsp; SIMPAN');
                    } else {
                        Swal.fire("SALAH BOS", "Tulisen kang bener", "error");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire('Upss..!', 'Terjadi kesalahan jaringan error message: ' + errorThrown,
                        'error');
                }
            });
        };

        // Fungsi Hapus
        function delete_data(id) {
            Swal.fire({
                title: 'Hapus Katalog',
                text: "Apakah anda yakin!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/admin/katalog/delete') }}",
                        type: "POST",
                        data: {
                            q: id
                        },
                        dataType: "JSON",
                    });
                    Swal.fire(
                        'Hapus!',
                        'Data berhasil Dihapus',
                        'success'
                    )
                    reload_table();
                }
            })
        };
    </script>
@endsection
