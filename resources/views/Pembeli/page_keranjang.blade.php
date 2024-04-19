@extends('Pembeli.layout.app')
@section('title', 'Keranjang')
@section('content')
    {{-- Keranjang --}}
    <section class="keranjang">
        <div class="container">
            <hr class="my-2 hr-keranjang opacity-100" data-aos="flip-right" data-aos-delay="100">
            <table id="tabel_keranjang" class="table table-condensed">
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
                        <td class="text-start">
                            <a href="javascript:void(0)" type="button" id="btn-del" class="btn-hapus"
                                onClick="delete_all_data({{ Auth::user()->id }})">Hapus Semua</a>
                        </td>
                        <td colspan="5" class="text-end">
                            <a href="javascript:void(0)" class="btn-keranjang px-5"
                                onclick="checkout({{ Auth::user()->id }})">Checkout</a>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
    {{-- Keranjang --}}
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

        function hitungTotalHarga() {
            var totalHarga = 0;
            // Loop melalui setiap baris tabel
            $('#tabel_keranjang tbody tr').each(function() {
                // Periksa apakah checkbox pada baris ini dicentang
                if ($(this).find('.checkbox-produk').is(':checked')) {
                    // Ambil harga dan jumlah dari baris ini
                    var harga = parseInt($(this).find('.harga-produk').text().replace('Rp ', '').replace(/\./g,
                        ''));
                    var jumlah = parseInt($(this).find('.input-qty').val());
                    // Hitung total harga untuk produk ini dan tambahkan ke totalHarga
                    totalHarga += harga * jumlah;
                }
            });

            // Mengubah total harga menjadi format mata uang Rupiah
            var formattedTotalHarga = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(totalHarga);

            // Menampilkan total harga dalam elemen dengan id 'total_keranjang'
            $('#total_keranjang').text(formattedTotalHarga);
        }


        $(document).ready(function() {
            // Event listener untuk tombol plus
            $(document).on('click', '.qty-btn-plus', function() {
                var $qtyInput = $(this).parent(".qty-container").find(".input-qty");
                var currentQty = parseInt($qtyInput.val());
                $qtyInput.val(currentQty + 1);
                updateKeranjang($qtyInput);
            });

            // Event listener untuk tombol minus
            $(document).on('click', '.qty-btn-minus', function() {
                var $qtyInput = $(this).parent(".qty-container").find(".input-qty");
                var currentQty = parseInt($qtyInput.val());
                if (currentQty > 0) {
                    $qtyInput.val(currentQty - 1);
                    updateKeranjang($qtyInput);
                }
            });

            // Fungsi untuk mengirim data perubahan jumlah ke server
            function updateKeranjang($qtyInput) {
                var jumlah = $qtyInput.val();
                var id_keranjang = $qtyInput.data('id');

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
            }
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

        function delete_all_data(id) {
            Swal.fire({
                title: 'Hapus Semua Produk',
                text: "Apakah anda yakin!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/keranjang/delete-all') }}",
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

        function checkout(id) {
            Swal.fire({
                title: 'Checkout',
                text: "Apakah anda yakin!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, checkout!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/keranjang/checkout') }}",
                        type: "POST",
                        data: {
                            q: id
                        },
                        dataType: "JSON",
                    });
                    window.location.href = "{{ url('/checkout') }}";
                }
            })
        }
    </script>
@endsection
