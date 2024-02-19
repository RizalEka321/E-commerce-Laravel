@extends('Admin.layout.app')
@section('title', 'User Manajemen')
@section('content')
    <div id="datane" class="details">
        <div class="content">
            <div class="container">
                <div class="card_header py-1 mb-2">
                    <h4 class="judul"><i class="fa-solid fa-users"></i> DATA AKUN</h4>
                    <hr>
                </div>
                <a type="button" class="btn-tambah mb-2" id="btn-add" data-bs-toggle="modal" data-bs-target="#form_modal"><i
                        class="fa-solid fa-square-plus"></i>&nbsp;&nbsp;
                    TAMBAH DATA AKUN</a>
                <table id="tabel_user" class="table table-bordered user" style="width:100%">
                    <thead>
                        <tr>
                            <th width="10%">Aksi</th>
                            <th width="5%">No</th>
                            <th>Username</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="form_modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ModalLabel"><i class="fa-solid fa-users"></i> TAMBAH AKUN</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form_tambah" action="{{ url('/user-management/create') }}" method="POST"
                        class="was-validated" role="form">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="name">Username :</label>
                                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                                        class="form-control" placeholder="Username" required autofocus>
                                    <div class="valid-feedback"><i>*valid</i> </div>
                                    <div class="invalid-feedback"><i>*required</i></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="email">Email :</label>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                                        class="form-control" placeholder="Email" required autofocus>
                                    <div class="valid-feedback"><i>*valid</i> </div>
                                    <div class="invalid-feedback"><i>*required</i> </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="password">Password Baru:</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                                    <div class="valid-feedback"><i>*valid</i> </div>
                                    <div class="invalid-feedback"><i>*wajib menggunakan kombinasi angka dan huruf
                                            yang mengandung huruf kapital minimal 8 karakter</i> </div>
                                </div>
                            </div>
                            {{-- <div class="mb-3">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password :</label>
                                    <input id="password_confirmation" type="password" name="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        placeholder="Confirm Password" required autocomplete="new-password">
                                    <div class="valid-feedback"><i>*valid</i> </div>
                                    <div class="invalid-feedback"><i>*required</i> </div>
                                </div>
                            </div> --}}
                        </div>
                        <!-- /.card-body -->
                        <div class="modal-footer">
                            <div class="btn-group">
                                <button type="button" id="btn-close" class="btn-hapus" data-bs-dismiss="modal"><i
                                        class="nav-icon fas fa-arrow-left"></i>&nbsp;&nbsp; KEMBALI</button>
                                <button type="submit" id="btn-simpan" class="btn-tambah"><i
                                        class="nav-icon fas fa-save"></i>&nbsp;&nbsp; TAMBAH</button>
                            </div>
                        </div>
                    </form>
                </div>
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

        $('#btn-add').click(function() {
            $('.modal-title').html(
                '<h4 class="judul"><i class="fa-solid fa-car"></i> TAMBAH DATA AKUN</h4>');
            $('#btn-simpan').html(
                '<i class="nav-icon fas fa-save"></i>&nbsp;&nbsp; TAMBAH');
            reset_form();
        });

        $('#btn-close').click(function() {
            $('.modal-title').html(
                '<h4 class="judul"><i class="fa-solid fa-car"></i> TAMBAH DATA AKUN</h4>');
            $('#btn-simpan').html(
                '<i class="nav-icon fas fa-save"></i>&nbsp;&nbsp; TAMBAH');
            reset_form();
        });

        function reload_table() {
            $('#tabel_user').DataTable().ajax.reload();
        }

        function reset_form() {
            $('#form_tambah').attr('action', "{{ url('/user-management/create') }}");
            $('#form_tambah')[0].reset();
        }

        // Fungsi index
        $(function() {
            var table = $('.user').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                orderClasses: false,
                info: false,
                ajax: "/user-management/list",
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
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
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
            $('#form_tambah').attr('action', '/user-management/update?q=' + id);
            $.ajax({
                url: "{{ url('/user-management/edit') }}",
                type: "POST",
                data: {
                    q: id
                },
                dataType: "JSON",
                success: function(data) {
                    console.log(data);

                    if (data.status) {
                        var isi = data.isi;
                        $('#name').val(isi.name);
                        $('#email').val(isi.email);
                        $('#password').val(isi.password);

                        $('.modal-title').html(
                            '<h4 class="judul"><i class="fa-solid fa-car"></i> EDIT DATA AKUN</h4>');
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
                title: 'Hapus Akun',
                text: "Apakah anda yakin!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/user-management/delete') }}",
                        type: "POST",
                        data: {
                            q: id
                        },
                        dataType: "JSON",
                    });
                    Swal.fire(
                        'Hapus!',
                        'Akun berhasil Dihapus',
                        'success'
                    )
                    reload_table();
                }
            })
        };
    </script>
@endsection
