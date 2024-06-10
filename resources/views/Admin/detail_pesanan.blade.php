@extends('Admin.layout.app')
@section('title', 'Detail Pesanan')
@section('content')
    {{-- Data Tabel Pesanan --}}
    <div id="datane" class="details">
        <div class="content">
            <div class="container">
                <div class="card_header pt-1">
                    <h4 class="judul"><i class="fa-solid fa-truck-fast"></i> DATA PESANAN {{ $detail->pesanan_id }}</h4>
                    <hr>
                </div>
                <a href="{{ route('admin.pesanan') }}" type="button" class="btn-hapus mb-2" id="btn-close"><i
                        class='nav-icon fas fa-arrow-left'></i>&nbsp;&nbsp;
                    KEMBALI</a>
                <table id="tabel_detail" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 30%;">Produk</th>
                            <th style="width: 5%;">Jumlah</th>
                            <th style="width: 5%;">Ukuran</th>
                            <th style="width: 20%;">Harga</th>
                            <th style="width: 35%;">Total</th>
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
        // Fungsi index
        $(function() {
            var table = $('#tabel_detail').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                orderClasses: false,
                info: false,
                ajax: "{{ url('/admin/pesanan/detail/list') }}/{{ $detail->pesanan_id }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'produk_id',
                        name: 'produk_id',
                        render: function(data, type, full, meta) {
                            return full.produk.judul;
                        }
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'ukuran',
                        name: 'ukuran'
                    },
                    {
                        data: 'produk_id',
                        name: 'produk_id',
                        render: function(data, type, full, meta) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(full.produk.harga);
                        }
                    },
                    {
                        data: 'total',
                        name: 'total',
                        render: function(data, type, full, meta) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(full.total);
                        }
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
    </script>
@endsection
