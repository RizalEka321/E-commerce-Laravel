@extends('Pembeli.layout.app')
@section('title', 'Keranjang')
@section('content')
    {{-- Keranjang --}}
    <style>
        .tabel-header {
            background-color: var(--white);
            margin-bottom: 8px;
            padding: 10px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .tabel-header .btn-hapus {
            text-decoration: none;
        }

        .tabel-header .btn-hapus {
            font-weight: 600;
            font-size: 12px;
            display: inline-block;
            text-decoration: none;
            -webkit-transition: all 0.5s ease-in-out;
            color: var(--black);
        }

        .tabel-header .btn-hapus:hover {
            border-color: var(--red);
            color: var(--white);
            background: var(--red);
        }
    </style>
    <section class="keranjang mb-4">
        <h1 class="title">Keranjang</h1>
        <div class="container">
            <table id="tabel_keranjang" class="tabel">
                <thead>
                    <tr>
                        <div class="tabel-header">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="checkbox" id="checkbox_semua" onclick="selectAll()">
                                    <a class="btn-hapus" id="pilih_semua" onclick="selectAll()">Pilih Semua</a>
                                </div>
                                <div id="hapus" class="col-lg-6 hidden text-end">
                                    <a href="javascript:void(0)" type="button" id="btn-del" class="btn-hapus"
                                        onClick="delete_all_data({{ Auth::user()->id }})">Hapus Semua</a>
                                </div>
                            </div>
                        </div>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-end">
                            <div class="keranjang-bawah">
                                <h3><strong>Total <span id="total_keranjang"></span></strong></h3>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <div class="text-end">
                <a href="javascript:void(0)" class="btn-keranjang px-5"
                    onclick="checkout({{ Auth::user()->id }})">Checkout</a>
            </div>
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

        $(document).ready(function() {
            reload_data();
        });

        function reload_data() {
            $.ajax({
                url: "{{ url('/keranjang/list') }}",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    isi_tabel(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function isi_tabel(data) {
            var tableBody = $('#tabel_keranjang tbody');
            var totalHarga = 0;
            tableBody.empty(); // Bersihkan tabel sebelum menambahkan data baru

            // Periksa apakah data adalah array
            if (Array.isArray(data)) {
                data.forEach(function(item) {
                    var row = $('<tr>');
                    row.append('<td>' + item.produk + '</td>');

                    totalHarga += item.sub_total;
                    tableBody.append(row);
                });

                var formattedTotalHarga = totalHarga.toLocaleString("id-ID", {
                    style: "currency",
                    currency: "IDR"
                });

                var formattedTotalHarga = totalHarga.toLocaleString("id-ID", {
                    style: "currency",
                    currency: "IDR",
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });

                $('#total_keranjang').text(formattedTotalHarga);
            } else {
                console.error('Data yang diterima bukanlah array:', data);
            }
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
                        reload_data();
                        console.log(response);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });

        function selectAll() {
            // Mengambil semua elemen checkbox di dalam tabel
            var checkboxes = document.querySelectorAll('.tabel-isi input[type="checkbox"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = true;
            });


            $('#hapus').removeClass('hidden');
        }

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
                    reload_data();
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
                    reload_data();
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
