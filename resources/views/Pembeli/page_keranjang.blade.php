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
            font-size: 15px;
            display: inline-block;
            text-decoration: none;
            transition: all 0.5s ease-in-out;
            color: var(--red);
        }

        .tabel-header .btn-hapus:hover {
            color: var(--black);
        }

        .keranjang .btn-hapus-keranjang {
            font-weight: 600;
            font-size: 25px;
            text-decoration: none;
            color: var(--red);
        }

        .keranjang .btn-hapus-keranjang:hover {
            color: var(--black);
        }
    </style>
    <section class="keranjang mb-4">
        <h1 class="title">Keranjang</h1>
        <div class="container">
            <table id="tabel_keranjang" class="tabel">
                <thead>
                    <tr>
                        <div class="tabel-header">
                            <div class="text-end me-2">
                                <a href="javascript:void(0)" type="button" id="btn-del" class="btn-hapus"
                                    onClick="delete_all_data({{ Auth::user()->id }})">Hapus Semua</a>
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
                                <h5><strong>Total Belanja : <span id="total_keranjang"></span></strong></h5>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <div class="text-end">
                <a href="javascript:void(0)" class="btn-keranjang px-5" onclick="checkout({{ Auth::user()->id }})">Beli</a>
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
            Swal.fire({
                title: "Memuat Ulang Data",
                html: "Mohon tunggu sebentar...",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });
            reload_data(true);
        });

        function reload_data(reloadPage = false) {
            $.ajax({
                url: "{{ url('/keranjang/list') }}",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    isi_tabel(response.data);
                    if (reloadPage) {
                        Swal.close();
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan: ' + error
                    });
                }
            });
        }

        function isi_tabel(data) {
            var tableBody = $('#tabel_keranjang tbody');
            var totalHarga = 0;
            tableBody.empty();

            if (Array.isArray(data)) {
                data.forEach(function(item) {
                    var row = $('<tr>');
                    row.append('<td>' + item.produk + '</td>');

                    totalHarga += item.sub_total;
                    tableBody.append(row);
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
            $(document).on('click', '.qty-btn-plus', function() {
                var $qtyInput = $(this).parent(".qty-container-keranjang").find(".input-qty");
                var currentQty = parseInt($qtyInput.val());
                $qtyInput.val(currentQty + 1);
                updateKeranjang($qtyInput);
            });

            $(document).on('click', '.qty-btn-minus', function() {
                var $qtyInput = $(this).parent(".qty-container-keranjang").find(".input-qty");
                var currentQty = parseInt($qtyInput.val());
                if (currentQty > 0) {
                    $qtyInput.val(currentQty - 1);
                    updateKeranjang($qtyInput);
                }
            });

            function updateKeranjang($qtyInput) {
                var jumlah = $qtyInput.val();
                var id_keranjang = $qtyInput.data('id');

                Swal.fire({
                    title: "Memperbarui Keranjang",
                    html: "Mohon tunggu sebentar...",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '/keranjang/update',
                    type: 'POST',
                    data: {
                        id_keranjang: id_keranjang,
                        jumlah: jumlah
                    },
                    success: function(response) {
                        if (response.error) {
                            Swal.close();
                            reload_data(false);
                            Swal.fire({
                                title: 'Upss..!',
                                text: response.error,
                                icon: 'error',
                                position: 'center',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: false
                            });
                        } else if (response.hapus) {
                            delete_data(id_keranjang);
                        } else {
                            Swal.close();
                            reload_data(false);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errorMessage = xhr.responseJSON.error;
                            if (errorMessage) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: errorMessage
                                });
                            }
                        }
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
                confirmButtonColor: '#000000',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Sedang Menghapus",
                        html: "Mohon tunggu sebentar...",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: "{{ url('/keranjang/delete') }}",
                        type: "POST",
                        data: {
                            q: id
                        },
                        dataType: "JSON",
                        success: function(response) {
                            Swal.close();
                            Swal.fire({
                                title: 'Hapus!',
                                text: 'Produk berhasil dihapus',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: false
                            });
                            reload_data(false);
                        },
                        error: function(xhr, status, error) {
                            Swal.close();
                            console.log(error);
                        }
                    });
                }
            });
        }

        function delete_all_data(id) {
            Swal.fire({
                title: 'Hapus Semua Produk',
                text: "Apakah anda yakin!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#000000',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Sedang Menghapus",
                        html: "Mohon tunggu sebentar...",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    $.ajax({
                        url: "{{ url('/keranjang/delete-all') }}",
                        type: "POST",
                        data: {
                            q: id
                        },
                        dataType: "JSON",
                        success: function(response) {
                            Swal.close();
                            Swal.fire({
                                title: 'Hapus!',
                                text: 'Semua produk berhasil dihapus',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: false
                            });
                            reload_data(false);
                        },
                        error: function(xhr, status, error) {
                            swal.close();
                            console.log(error);
                        }
                    });
                }
            });
        }

        function checkout(id) {
            Swal.fire({
                title: 'Checkout',
                text: "Apakah anda yakin!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#000000',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, checkout!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/checkout-keranjang') }}",
                        type: "POST",
                        data: {
                            q: id
                        },
                        dataType: "JSON",
                    });
                    window.location.href = "{{ url('/checkout') }}";
                }
            });
        }
    </script>

@endsection
