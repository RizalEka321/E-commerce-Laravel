@extends('Admin.layout.app')
@section('title', 'Log Aktivitas')
@section('content')
    {{-- Data Tabel Log Aktivitas --}}
    <div id="datane" class="details">
        <div class="content">
            <div class="container">
                <div class="card_header pt-1">
                    <h4 class="judul"><i class="fa-solid fa-user-gear"></i> DATA LOG AKTIVITAS</h4>
                    <hr>
                </div>
                <table id="tabel_log" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Aktivitas</th>
                            <th>User</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="tambah_data" class="details hidden">
        <div class="content">
            <div class="card border-0">
                <div class="card_header mx-3 pt-1">
                    <h4 class="judul"><i class="fa-solid fa-user-gear"></i> DETAIL DATA AKTIVITAS</h4>
                    <hr>
                </div>
                <form id="form_tambah" role="form">
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="nama_lengkap">Nama :</label>
                                <input id="nama_lengkap" type="text" name="nama_lengkap"
                                    value="{{ old('nama_lengkap') }}" class="form-control" placeholder="Nama" readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="username">Username :</label>
                                <input id="username" type="text" name="username" value="{{ old('username') }}"
                                    class="form-control" placeholder="Username" readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="aktivitas">Aktivitas :</label>
                                <textarea id="aktivitas" name="aktivitas" class="form-control" placeholder="Masukkan Alamat" id="alamat" readonly>{{ old('alamat') }}</textarea>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a type="button" id="btn-close" class="btn-hapus"><i
                                    class='nav-icon fas fa-arrow-left'></i>&nbsp;&nbsp; KEMBALI</a>
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
        $('#btn-close').click(function() {
            $('#datane').removeClass('hidden');
            $('#tambah_data').addClass('hidden');
            $('.judul').html(
                '<h4 class="judul"><i class="fa-solid fa-shirt"></i> DATA LOG AKTIVITAS</h4>');
            reset_form();
        });

        // Global Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function reload_table() {
            $('#tabel_log').DataTable().ajax.reload();
        }

        // Fungsi index
        $(function() {
            var table = $('#tabel_log').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                orderClasses: false,
                info: false,
                ajax: "{{ url('/admin/log/list') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'aktivitas',
                        name: 'aktivitas'
                    },
                    {
                        data: 'user',
                        name: 'user',
                        render: function(data, type, full, meta) {
                            return full.user.username;
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, full, meta) {
                            var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat',
                                'Sabtu'
                            ];
                            // Ubah string tanggal menjadi objek Date
                            var tanggal = new Date(full.created_at);

                            // Mendapatkan nama hari dalam Bahasa Indonesia
                            var namaHari = days[tanggal.getDay()];

                            // Format tanggal yang diinginkan (misal: 'DD-MM-YYYY')
                            var tanggalFormatted = namaHari + ', ' + tanggal.getDate() + '-' + (
                                tanggal.getMonth() + 1) + '-' + tanggal.getFullYear();

                            // Mengembalikan tanggal yang diformat
                            return tanggalFormatted;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
        });

        // Fungsi detail
        function detail_data(id) {
            $('#form_tambah')[0].reset();

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
                url: "/admin/log/detail",
                type: "POST",
                data: {
                    q: id
                },
                dataType: "JSON",
                success: function(response) {
                    Swal.close();
                    var isi = response.log;
                    $('#nama_lengkap').val(isi.user.nama_lengkap);
                    $('#username').val(isi.user.username);
                    $('#aktivitas').val(isi.aktivitas);

                    $('#tambah_data').removeClass('hidden');
                    $('#datane').addClass('hidden');
                    $('.judul').html(
                        '<h4 class="judul"><i class="fa-solid fa-user-gear"></i> DETAIL DATA AKTIVITAS</h4>'
                    );
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
        };
    </script>
@endsection
