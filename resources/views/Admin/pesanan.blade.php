@extends('Admin.layout.app')
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
                            <th width="10%">Aksi</th>
                            <th width="10%">ID</th>
                            <th width="30%">Nama</th>
                            <th width="10%">Pengiriman</th>
                            <th width="10%">Pembayaran</th>
                            <th width="30%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- Form Data --}}
    <div id="tambah_data" class="details hidden">
        <div class="content">
            <div class="card border-0">
                <div class="card_header mx-3 pt-1">
                    <h4 class="judul"><i class="fa-solid fa-truck-fast"></i>EDIT DATA PESANAN</h4>
                    <hr>
                </div>
                <form id="form_tambah" action="#" method="POST" enctype="multipart/form-data" role="form">
                    <div class="card-body">
                        <div class="row gx-5 mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label for="no_hp">No Telepon :</label>
                                    <input id="no_hp" type="text" name="no_hp" value="{{ old('no_hp') }}"
                                        class="form-control" placeholder="No Telepon" autofocus>
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="alamat_pengiriman">Alamat :</label>
                                    <textarea id="alamat_pengiriman" name="alamat_pengiriman" class="form-control" placeholder="Alamat"
                                        id="alamat_pengiriman">{{ old('alamat_pengiriman') }}</textarea>
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row gx-5 mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label for="metode_pembayaran">Metode Pembayaran :</label>
                                    <select id="metode_pembayaran" name="metode_pembayaran" class="form-control">
                                        <option value="">-- Pilih Metode --</option>
                                        <option value="Transfer">Transfer</option>
                                        <option value="Cash">Cash</option>
                                    </select>
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="metode_pengiriman">Metode Pengiriman :</label>
                                    <select id="metode_pengiriman" name="metode_pengiriman" class="form-control">
                                        <option value="">-- Pilih Metode --</option>
                                        <option value="Pickup">Pickup</option>
                                        <option value="Delivery">Delivery</option>
                                    </select>
                                    <span class="form-text text-danger error-message"></span>
                                </div>
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
        // ButtoN
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
                        searchable: true,
                        className: 'text-center'
                    },
                    {
                        data: 'id_pesanan',
                        name: 'id_pesanan',
                        className: 'text-center'
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
                ],
                language: {
                    paginate: {
                        first: '<i class="fas fa-angle-double-left"></i>',
                        last: '<i class="fas fa-angle-double-right"></i>',
                        next: '<i class="fas fa-angle-right"></i>',
                        previous: '<i class="fas fa-angle-left"></i>'
                    }
                }
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
                            text: 'Terjadi kesalahan jaringan: ' + errorThrown,
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
            $('#form_tambah').attr('action', '/admin/pesanan/update?q=' + id);

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
                url: "{{ url('/admin/pesanan/edit') }}",
                type: "POST",
                data: {
                    q: id
                },
                dataType: "JSON",
                success: function(response) {
                    Swal.close();
                    var isi = response.pesanan;
                    $('#alamat_pengiriman').val(isi.alamat_pengiriman);
                    $('#no_hp').val(isi.no_hp);
                    $('#metode_pembayaran').val(isi.metode_pembayaran);
                    $('#metode_pengiriman').val(isi.metode_pengiriman);
                    $('#tambah_data').removeClass('hidden');
                    $('#datane').addClass('hidden');
                    $('.judul').html(
                        '<h4 class="judul"><i class="fa-solid fa-truck-fast"></i> EDIT DATA PESANAN</h4>'
                    );
                    $('#btn-simpan').html(
                        '<i class="nav-icon fas fa-save"></i>&nbsp;&nbsp; SIMPAN');

                },
                error: function(jqXHR, textStatus, errorThrown) {
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

        // Fungsi Update Status
        $(document).on('change', '.status-dropdown', function() {
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
                url: '/admin/pesanan/update-status',
                method: 'POST',
                data: {
                    status: status,
                    id: id
                },
                success: function(response) {
                    Swal.close();
                    Swal.fire({
                        title: 'Sukses',
                        text: 'Status berhasil diubah',
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
                        text: 'Terjadi kesalahan jaringan: ' + errorThrown,
                        icon: 'error',
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        toast: true
                    });
                }
            });
        });
    </script>
@endsection
