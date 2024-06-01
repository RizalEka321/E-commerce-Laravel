@extends('Admin.layout.app')
@section('title', 'User Manajemen')
@section('content')
    <div id="datane" class="details">
        <div class="content">
            <div class="container">
                <div class="card_header py-1 mb-2">
                    <h4 class="judul"><i class="fa-solid fa-users"></i> DATA USER</h4>
                    <hr>
                </div>
                <a type="button" class="btn-tambah mb-2" id="btn-add"><i class="fa-solid fa-square-plus"></i>&nbsp;&nbsp;
                    TAMBAH DATA USER</a>
                <table id="tabel_user" class="table table-bordered user" style="width:100%">
                    <thead>
                        <tr>
                            <th width="5%">Aksi</th>
                            <th width="5%">No</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
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
                    <h4 class="judul"><i class="fa-solid fa-cube"></i> TAMBAH DATA USER</h4>
                    <hr>
                </div>
                <form id="form_tambah" action="{{ url('/admin/user-manajemen/create') }}" method="POST"
                    enctype="multipart/form-data" role="form">
                    <div class="card-body">
                        <div class="row gx-5 mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label for="nama_lengkap">Nama :</label>
                                    <input id="nama_lengkap" type="text" name="nama_lengkap"
                                        value="{{ old('nama_lengkap') }}" class="form-control"
                                        placeholder="Masukkan Nama Panjang"autofocus>
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="username">Username :</label>
                                    <input id="username" type="text" name="username" value="{{ old('username') }}"
                                        class="form-control" placeholder="Masukkan Username">
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row gx-5 mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label for="email">Email :</label>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                                        class="form-control" placeholder="Masukkan Email">
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="no_hp">No Handphone(HP) (Opsional) :</label>
                                    <input id="no_hp" type="text" name="no_hp" value="{{ old('no_hp') }}"
                                        class="form-control" placeholder="Masukkan No HP">
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                        </div>
                        <div id="input_foto" class="row gx-5 mb-3 hidden">
                            <div class="col">
                                <div class="form-group">
                                    <label for="foto">Foto(Opsional):</label>
                                    <input id="foto" type="file" name="foto" class="form-control">
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="role">Role :</label>
                                    <select id="role" name="role" class="form-control">
                                        <option value="Pegawai">Pegawai</option>
                                        <option value="Pembeli">Pembeli</option>
                                    </select>
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="alamat">Alamat(Opsional) :</label>
                            <textarea id="alamat" name="alamat" class="form-control" placeholder="Masukkan Alamat" id="alamat">{{ old('alamat') }}</textarea>
                            <span class="form-text text-danger error-message"></span>
                        </div>
                    </div>
                    <div class="row gx-5 mb-3">
                        <div class="col">
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password">
                                <span class="form-text text-danger error-message"></span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="harga_satuan">Konfirmasi Password :</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Konfirmasi Password">
                                <span class="form-text text-danger error-message"></span>
                            </div>
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
                '<h4 class="judul"><i class="fa-solid fa-shirt"></i>TAMBAH DATA USER</h4>');

        });
        $('#btn-close').click(function() {
            $('#datane').removeClass('hidden');
            $('#tambah_data').addClass('hidden');
            $('.judul').html(
                '<h4 class="judul"><i class="fa-solid fa-shirt"></i> DATA USER</h4>');
            reset_form();
        });

        // Global Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Reload Table
        function reload_table() {
            $('#tabel_user').DataTable().ajax.reload();
        }

        // Reset Form
        function reset_form() {
            $('#form_tambah').attr('action', "{{ url('/admin/user-manajemen/create') }}");
            $('#form_tambah')[0].reset();
        }

        // Fungsi index tabel
        $(function() {
            var table = $('#tabel_user').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                orderClasses: false,
                info: false,
                ajax: "/admin/user-manajemen/list",
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
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                ]
            });
        });

        // Fungsi Tambah data
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
                            $.each(data.errors, function(key, value) {
                                // Show error message below each input
                                $('#' + key).next('.error-message').text('*' + value);
                            });
                        } else {
                            reset_form();
                            $('#datane').removeClass('hidden');
                            $('#tambah_data').addClass('hidden');
                            Swal.fire(
                                'Sukses',
                                'Data user berhasil ditambahkan',
                                'success'
                            );
                            $('#form_modal').modal('hide');
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
            $('#form_tambah').attr('action', '/admin/user-manajemen/update?q=' + id);
            $.ajax({
                url: "{{ url('/admin/user-manajemen/edit') }}",
                type: "POST",
                data: {
                    q: id
                },
                dataType: "JSON",
                success: function(data) {
                    console.log(data);

                    if (data.status) {
                        var isi = data.isi;
                        $('#nama_lengkap').val(isi.nama_lengkap);
                        $('#username').val(isi.username);
                        $('#role').val(isi.role);
                        $('#email').val(isi.email);
                        $('#no_hp').val(isi.no_hp);
                        $('#alamat').val(isi.alamat);
                        $('#password').val(isi.password);
                        if (isi.foto) {
                            $('#foto').text(isi.foto);
                        }

                        $('#tambah_data').removeClass('hidden');
                        $('#datane').addClass('hidden');
                        $('.judul').html(
                            '<h4 class="judul"><i class="fa-solid fa-users"></i> EDIT DATA USER</h4>');
                        $('#btn-simpan').html(
                            '<i class="nav-icon fas fa-save"></i>&nbsp;&nbsp; SIMPAN');
                    } else {
                        Swal.fire("SALAH BOS", "Datanya ada yang salah", "error");
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
                title: 'Hapus User',
                text: "Apakah anda yakin!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/admin/user-manajemen/delete') }}",
                        type: "POST",
                        data: {
                            q: id
                        },
                        dataType: "JSON",
                    });
                    Swal.fire(
                        'Hapus!',
                        'User berhasil Dihapus',
                        'success'
                    )
                    reload_table();
                }
            })
        };
    </script>
@endsection
