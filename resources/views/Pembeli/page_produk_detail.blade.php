@extends('Pembeli.layout.app')
@section('title', 'Detail Produk')
@section('content')
    {{-- Detail Produk --}}
    <section class="detail-produk">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-lg-5">
                    <img src="{{ asset($produk_detail->foto) }}" class="card-img-top" alt="Produk Lokal Industri">
                </div>
                <div class="col-md-7 col-lg-7">
                    <h2 class="title">{{ $produk_detail->judul }}</h2>
                    <div class="price">
                        <h4>Rp. {{ number_format($produk_detail->harga, 0, '.', '.') }}</h4>
                    </div>
                    <div>
                        <form id="form_tambah" action="#" method="POST" role="form">
                            <input type="hidden" name="produk_id" value="{{ $produk_detail->id_produk }}">
                            <div class="mb-3">
                                <label for="ukuran">Ukuran</label>
                                <div class="radio-toolbar">
                                    @foreach ($produk_detail->ukuran as $u)
                                        @if ($u->stok != null)
                                            <input type="radio" id="radio{{ $u->id_ukuran }}" name="id_ukuran"
                                                value="{{ $u->id_ukuran }}">
                                            <label for="radio{{ $u->id_ukuran }}">{{ $u->jenis_ukuran }}</label>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="ukuran">Kuantitas</label>
                                <div class="qty-container">
                                    <button class="qty-btn-minus btn-light" type="button"><i
                                            class="fa fa-minus"></i></button>
                                    <input type="text" name="jumlah" value="0" class="input-qty" />
                                    <button class="qty-btn-plus btn-light" type="button"><i
                                            class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="button-container">
                                <button type="submit" id="btn_masukkan_keranjang" class="btn-keranjang"><i
                                        class="fa-solid fa-plus"></i> Keranjang</button>
                                <button class="btn-beli" id="btn_beli_sekarang">Beli Sekarang</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row description">
                <h4 class="title">Deskripsi Produk</h4>
                <div class="mx-2">
                    {!! $produk_detail->deskripsi !!}
                </div>
            </div>
        </div>
    </section>
    {{-- End Detail Produk --}}
@endsection
@section('script')
    <script>
        // Global Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function reset_form() {
            $('#form_tambah')[0].reset();
        }

        $(document).ready(function() {
            $(document).on('click', '.qty-btn-plus', function() {
                var $n = $(this).parent(".qty-container").find(".input-qty");
                $n.val(Number($n.val()) + 1);
            });

            $(document).on('click', '.qty-btn-minus', function() {
                var $n = $(this).parent(".qty-container").find(".input-qty");
                var amount = Number($n.val());
                if (amount > 0) {
                    $n.val(amount - 1);
                }
            });
        });

        $('#btn_masukkan_keranjang').click(function(event) {
            event.preventDefault();

            // Check if user is logged in
            var isLoggedIn = "{{ Auth::check() }}";
            if (!isLoggedIn) {
                window.location.href = "{{ route('login') }}";
                return;
            } else {
                // Ubah action form ke URL endpoint checkout
                var checkoutUrl = "{{ url('/keranjang/create') }}";
                $('#form_tambah').attr('action', checkoutUrl);

                var url = $('#form_tambah').attr('action');
                var formData = new FormData($('#form_tambah')[0]);

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

                // Lakukan AJAX request
                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "JSON",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        Swal.close();

                        if (data.errors) {
                            let errorMessages = '';
                            $.each(data.errors, function(key, value) {
                                errorMessages += value + '<br>';
                            });
                            Swal.fire({
                                title: 'Error',
                                html: errorMessages,
                                icon: 'error'
                            });
                        } else {
                            reset_form();
                            Swal.fire({
                                title: 'Sukses',
                                text: 'Produk Berhasil Dimasukkan Keranjang',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: false
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.close();
                        Swal.fire({
                            title: 'Error',
                            text: 'Terjadi kesalahan saat memproses memasukkan keranjang.',
                            icon: 'error',
                            confirmButtonText: 'Oke',
                            confirmButtonColor: '#000000'
                        });
                    }
                });
            }
        });
        // Event handler untuk tombol "Beli Sekarang"
        $('#btn_beli_sekarang').click(function(event) {
            event.preventDefault();

            // Check if user is logged in
            var isLoggedIn = "{{ Auth::check() }}";
            if (!isLoggedIn) {
                window.location.href = "{{ route('login') }}";
                return;
            } else {
                var checkoutUrl = "{{ url('/checkout-langsung') }}";
                $('#form_tambah').attr('action', checkoutUrl);

                var url = $('#form_tambah').attr('action');
                var formData = new FormData($('#form_tambah')[0]);

                // Tampilkan SweetAlert dengan indikator loading
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

                // Lakukan AJAX request
                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "JSON",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        Swal.close();
                        if (data.errors) {
                            let errorMessages = '';
                            $.each(data.errors, function(key, value) {
                                errorMessages += value + '<br>';
                            });
                            Swal.fire({
                                title: 'Error',
                                html: errorMessages,
                                icon: 'error'
                            });
                        } else if (data.error) {
                            Swal.fire("Error", data.error, "error");
                        } else {
                            Swal.fire({
                                title: 'Checkout Sekarang?',
                                text: "Anda akan langsung checkout, lanjutkan?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#000000',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, checkout!',
                                cancelButtonText: 'Batal'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "{{ url('/checkout') }}";
                                } else if (result.dismiss === Swal.DismissReason.cancel) {
                                    // Ajax request untuk membatalkan checkout
                                    $.ajax({
                                        url: "{{ url('/checkout-batalkan') }}",
                                        type: "POST",
                                        dataType: "JSON",
                                        processData: false,
                                        contentType: false,
                                        success: function(response) {
                                            console.log(response);
                                        },
                                        error: function(jqXHR, textStatus,
                                            errorThrown) {
                                            console.log(jqXHR);
                                        }
                                    });
                                }
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.close();
                        Swal.fire({
                            title: 'Error',
                            text: 'Terjadi kesalahan saat memproses checkout.',
                            icon: 'error',
                            confirmButtonText: 'Oke',
                            confirmButtonColor: '#000000'
                        });
                    },
                });
            }
        });
    </script>
@endsection
