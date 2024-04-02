@extends('Pembeli.layout.app')
@section('title', 'Keranjang')
@section('content')
    {{-- Keranjang --}}
    <section class="keranjang">
        <div class="container">
            <hr class="my-2 hr-keranjang opacity-100" data-aos="flip-right" data-aos-delay="100">
            <table id="tabel_keranjang" class="table table-hover table-condensed">
                <thead>
                    <tr>
                        <th width="50%">Produk</th>
                        <th width="10%">Harga</th>
                        <th width="8%">Kuantitas</th>
                        <th width="22%">Total Harga</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-end">
                            <h3><strong>Total <span id="total_keranjang"></span></strong></h3>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-end">
                            <button class="btn-keranjang px-5">Checkout</button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
    {{-- Keranjang --}}
    <section class="home" id="produk">
        <div class="container py-3 mt-3">
            <div>
                <h5>Produk Lainnya</h5>
                <hr class="hr-home opacity-100" data-aos="flip-right" data-aos-delay="100">
            </div>
            <div class="col-lg-12 my-5">
                <div class="home-slider owl-carousel">
                    @foreach ($produk as $k)
                        <div class="single-box text-center">
                            <div class="img-area">
                                <img alt="produk" class="img-fluid move-animation" src="{{ asset($k->foto) }}" />
                            </div>
                            <div class="info-area">
                                {{-- <p class="kategori mt-1 mx-3">{{ $k->judul }}</p> --}}
                                <h4 id="title_card">{{ Str::limit($k->judul, 20) }}</h4>
                                <h6 class="price">Rp {{ number_format($k->harga, 0, '.', '.') }}</h6>
                                <a href="{{ route('detail_produk', $k->slug) }}" class="btn-beli">Beli</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function reload_table() {
            $('#tabel_keranjang').DataTable().ajax.reload();
        }

        $(function() {
            var table = $('#tabel_keranjang').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                paging: false,
                orderClasses: false,
                info: false,
                ajax: "{{ url('/keranjang/list') }}",
                columns: [{
                        data: 'produk',
                        name: 'produk',
                    },
                    {
                        data: 'harga',
                        name: 'harga',
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'total_harga',
                        name: 'total_harga'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api(),
                        data;

                    // Total semua harga dalam tabel
                    var totalHarga = api.column(3, {
                        page: 'current'
                    }).data().reduce(function(a, b) {
                        // Menghilangkan simbol rupiah ('Rp') dan tanda pemisah ribuan (titik)
                        var price = parseInt(b.replace('Rp ', '').replace(/\./g, ''));
                        return a + price;
                    }, 0);

                    // Mengubah total harga menjadi format mata uang Rupiah
                    var formattedTotalHarga = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(totalHarga);

                    // Menampilkan total harga dalam elemen dengan id 'total_keranjang'
                    $('#total_keranjang').text(formattedTotalHarga);
                }
            });
        });

        $(document).on('change', '.update-keranjang', function() {
            var jumlah = $(this).val();
            var id_keranjang = $(this).data('id'); // Mengambil ID dari data-id atribut

            $.ajax({
                url: '/keranjang/update',
                type: 'POST',
                data: {
                    id_keranjang: id_keranjang,
                    jumlah: jumlah
                },
                success: function(response) {
                    reload_table();
                    console.log(response);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        function delete_data(id) {
            Swal.fire({
                title: 'Hapus Produk',
                text: "Apakah anda yakin!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/keranjang/delete') }}",
                        type: "POST",
                        data: {
                            q: id
                        },
                        dataType: "JSON",
                    });
                    Swal.fire(
                        'Hapus!',
                        'Produk berhasil Dihapus',
                        'success'
                    )
                    reload_table();
                }
            })
        };
    </script>
@endsection
