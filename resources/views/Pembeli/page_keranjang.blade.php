@extends('Pembeli.layout.app')
@section('title', 'Keranjang')
@section('content')
    {{-- Keranjang --}}
    <section class="keranjang mb-4">
        <h1 class="title">Keranjang</h1>
        <div class="container">
            <table id="tabel_keranjang" class="tabel">
                <thead>
                    <tr>
                        <div class="tabel-header">
                            <div id="btn-atas" class="text-end me-2">
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
                                <h5 class="total-keranjang">Total Belanja : <span id="total_keranjang"></span></h5>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <div class="text-end" id="btn-bawah">
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
                title: "Sedang memproses",
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
                    isi_tabel(response.data, response.total_barang);
                    if (reloadPage) {
                        Swal.close();
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Terjadi kesalahan saat menampilkan data',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 3000,
                        toast: false
                    });
                }
            });
        }

        function isi_tabel(data, totalBarang) {
            var tableBody = $('#tabel_keranjang tbody');
            var totalHarga = 0;
            tableBody.empty();

            if (Array.isArray(data) && data.length > 0) {
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
                $('#btn-bawah').html(
                    `<a href="javascript:void(0)" class="btn-keranjang px-5" onclick="checkout({{ Auth::user()->id }})">Beli (${totalBarang})</a>`
                )
            } else {
                tableBody.html(`<tr><td>${data}</td></tr>`);
                $('#total_keranjang').text('Rp. 0');
                $('#btn-del').removeAttr('onClick');
                $('#btn-bawah').html(
                    `<a href="#" class="btn-keranjang-disable px-5">Beli</a>`
                )
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
                                title: 'Error',
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
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Terjadi kesalahan saat memperbarui jumlah produk',
                            icon: 'error',
                            position: 'center',
                            showConfirmButton: false,
                            timer: 3000,
                            toast: false
                        });
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
                        title: "Sedang Memproses",
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
                        error: function(jqXHR, textStatus, errorThrown) {
                            Swal.close();
                            Swal.fire({
                                title: 'Error',
                                text: 'Terjadi kesalahan saat menghapus produk',
                                icon: 'error',
                                position: 'center',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: false
                            });
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    reload_data(false);
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
                        title: "Sedang mengproses",
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
                        error: function(jqXHR, textStatus, errorThrown) {
                            swal.close();
                            Swal.fire({
                                title: 'Error',
                                text: 'Terjadi kesalahan saat menghapus semua produk',
                                icon: 'error',
                                position: 'center',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: false
                            });
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
                        url: "{{ url('/checkout-keranjang') }}",
                        type: "POST",
                        data: {
                            q: id
                        },
                        dataType: "JSON",
                        success: function(response) {
                            if (response.error) {
                                Swal.close();
                                Swal.fire({
                                    title: 'Error',
                                    text: response.error,
                                    icon: 'error',
                                    position: 'center',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    toast: false
                                });
                            } else {
                                window.location.href = "{{ url('/checkout') }}";
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            swal.close();
                            Swal.fire({
                                title: 'Error',
                                text: 'Terjadi kesalahan saat mencheckout keranjang',
                                icon: 'error',
                                position: 'center',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: false
                            });
                        }
                    });
                }
            });
        }
    </script>
@endsection
