@extends('admin.layout.app')
@section('title', 'Pesanan')
@section('content')
    {{-- Data Tabel Pesanan --}}
    <div id="datane" class="details">
        <div class="content">
            <div class="container">
                <div class="card_header pt-1">
                    <h4 class="judul"><i class="fa-solid fa-truck-fast"></i> DATA PESANAN</h4>
                    <hr>
                </div>
                <table id="tabel_pesanan" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Aksi</th>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Pengiriman</th>
                            <th>Pembayaran</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- Detail --}}
    <div id="detail_pesanan" class="details">
        <div class="content">
            <div class="container">
                <div class="card_header pt-1">
                    <h4 class="judul"><i class="fa-solid fa-truck-fast"></i>DETAIL PESANAN</h4>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-5">
                        <table border="2">
                            <tbody>
                                <tr>
                                    <td width="27%">ID Pesanan</td>
                                    <td width="2%">:</td>
                                    <td>Bang Johnes</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>Blogger</td>
                                </tr>
                                <tr>
                                    <td>No HP</td>
                                    <td>:</td>
                                    <td>Blogger</td>
                                </tr>
                                <tr>
                                    <td>Pengiriman</td>
                                    <td>:</td>
                                    <td>Blogger</td>
                                </tr>
                                <tr>
                                    <td>Pembayaran</td>
                                    <td>:</td>
                                    <td>Blogger</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-7">
                        <table id="tabel_detail" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="10%">Aksi</th>
                                    <th width="5%">No</th>
                                    <th>Katalog</th>
                                    <th>jumlah</th>
                                    <th>total</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Form Edit Data --}}
    <div id="tambah_data" class="details hidden">
        <div class="content">
            <div class="card border-0">
                <div class="card_header mx-3 pt-1">
                    <h4 class="judul"><i class="fa-solid fa-truck-fast"></i> TAMBAH DATA PESANAN</h4>
                    <hr>
                </div>
                <form id="form_tambah" action="{{ url('/admin/pesanan/create') }}" method="POST"
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
    {{-- Modal Detail --}}
    <div class="modal fade" id="modal_detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Pesanan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="tabel_detail" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>No</th>
                                <th>Katalog</th>
                                <th>Pengiriman</th>
                                <th>Pembayaran</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
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
                '<h4 class="judul"><iTAMB<i class="fa-solid fa-truck-fast"></i>TAMBAH DATA PESANAN</h4>');

        });
        $('#btn-close').click(function() {
            $('#datane').removeClass('hidden');
            $('#tambah_data').addClass('hidden');
            $('.judul').html(
                '<h4 class="judul"><i class="fa-solid fa-truck-fast"></i> DATA PESANAN</h4>');
            reset_form();
        });

        // Global Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function reload_table() {
            $('#tabel_pesanan').DataTable().ajax.reload();
        }

        function reset_form() {
            $('#form-add').attr('action', "{{ url('/admin/pesanan/create') }}");
            $('#form_tambah')[0].reset();
        }

        // Fungsi index
        $(function() {
            var table = $('#tabel_pesanan').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                orderClasses: false,
                info: false,
                ajax: "{{ url('/admin/pesanan/list') }}",
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
                        data: 'users_id',
                        name: 'users_id',
                        render: function(data, type, full, meta) {
                            return full.user.nama_lengkap;
                        }
                    },
                    {
                        data: 'metode_pengiriman',
                        name: 'metode_pengiriman',
                    },
                    {
                        data: 'metode_pembayaran',
                        name: 'metode_pembayaran',
                    },
                    {
                        data: 'status',
                        name: 'status',
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
            $('#form_tambah').attr('action', '/admin/pesanan/update?q=' + id);
            $.ajax({
                url: "{{ url('/admin/pesanan/edit') }}",
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
                            '<h4 class="judul"><i class="fa-solid fa-truck-fast"></i> EDIT DATA PESANAN</h4>'
                        );
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
                title: 'Hapus Pesanan',
                text: "Apakah anda yakin!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/admin/pesanan/delete') }}",
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

        // Fungsi Update Status
        $(document).on('change', '.status-dropdown', function() {
            var status = $(this).val();
            var id = $(this).data('id');
            $.ajax({
                url: '/admin/pesanan/update-status',
                method: 'POST',
                data: {
                    status: status,
                    id: id
                },
                success: function(response) {
                    console.log('Status berhasil diubah');
                    Swal.fire(
                        'Sukses',
                        'Status berhasil diubah',
                        'success'
                    );
                    reload_table();
                },
                error: function(xhr, status, error) {
                    console.log('Terjadi kesalahan: ' + error);
                }
            });
        });

        // Detail Pesanan
        function detail_data(id) {
            $.ajax({
                url: "{{ url('/admin/pesanan/detail') }}",
                method: 'GET',
                data: {
                    q: id
                },
                success: function(response) {
                    var rows = '';
                    $.each(response, function(index, item) {
                        rows += '<tr>';
                        rows +=
                            '<td><div class="btn-group"><a href="javascript:void(0)" type="button" id="btn-edit" class="btn-edit" onClick="edit_data(' +
                            item.id_details +
                            ')"><i class="fa-solid fa-pen-to-square"></i></a><a href="javascript:void(0)" type="button" id="btn-del" class="btn-hapus" onClick="delete_data(' +
                            item.id_details +
                            ')"><i class="fa-solid fa-trash-can"></i></a></div></td>';
                        rows += '<td class="text-center">' + (index + 1) + '</td>';
                        rows += '<td>' + item.katalog.judul + '</td>';
                        rows += '<td>' + item.jumlah + '</td>';
                        rows += '</tr>';
                    });
                    $('#tabel_detail tbody').append(rows);
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                }
            });
        }
    </script>
@endsection
