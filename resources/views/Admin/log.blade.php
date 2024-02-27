@extends('admin.layout.app')
@section('title', 'Log Aktivitas')
@section('content')
    {{-- Data Tabel Log Aktivitas --}}
    <div id="datane" class="details">
        <div class="content">
            <div class="container">
                <div class="card_header pt-1">
                    <h4 class="judul"><i class="fa-solid fa-shirt"></i> DATA LOG AKTIVITAS</h4>
                    <hr>
                </div>
                <table id="tabel_log" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Aktivitas</th>
                            <th>User</th>
                            <th>tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
                    }
                ]
            });
        });
    </script>
@endsection
