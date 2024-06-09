@extends('Pembeli.layout.app')
@section('title', 'Detail Produk')
@section('content')
    {{-- Detail Produk --}}
    <section class="detail-produk">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-lg-5">
                    <img src="{{ asset($produk_detail->foto) }}" alt="Produk Lokal Industri">
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
                                <label for="ukuran"><b>Ukuran</b></label>
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
                                <label for="ukuran"><b>Kuantitas</b></label>
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
                <h5 class="judul_description">{{ $produk_detail->judul }}</h5>
                <h5 class="title_description">Detail Produk:</h5>
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
            var isLoggedIn = "{{ Auth::check() }}";
            if (!isLoggedIn) {
                window.location.href = "{{ route('login') }}";
                return;
            } else {
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

                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "JSON",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.close();
                        if (response.errors) {
                            let errorMessages = '';
                            $.each(response.errors, function(key, value) {
                                errorMessages += value + '<br>';
                            });
                            Swal.fire({
                                title: 'Error',
                                html: errorMessages,
                                icon: 'error',
                                position: 'center',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: false
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
                            position: 'center',
                            showConfirmButton: false,
                            timer: 3000,
                            toast: false
                        });
                    }
                });
            }
        });

        $('#btn_beli_sekarang').click(function(event) {
            event.preventDefault();
            var isLoggedIn = "{{ Auth::check() }}";
            if (!isLoggedIn) {
                window.location.href = "{{ route('login') }}";
                return;
            } else {
                var checkoutUrl = "{{ url('/checkout-langsung') }}";
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

                $.ajax({
                    url: url,
                    type: "POST",
                    dataType: "JSON",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.close();
                        if (response.errors) {
                            let errorMessages = '';
                            $.each(response.errors, function(key, value) {
                                errorMessages += value + '<br>';
                            });
                            Swal.fire({
                                title: 'Error',
                                html: errorMessages,
                                icon: 'error',
                                position: 'center',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: false
                            });
                        } else if (response.error) {
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
                                    $.ajax({
                                        url: "{{ url('/checkout-batalkan') }}",
                                        type: "POST",
                                        dataType: "JSON",
                                        processData: false,
                                        contentType: false,
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
                            position: 'center',
                            showConfirmButton: false,
                            timer: 3000,
                            toast: false
                        });
                    },
                });
            }
        });
    </script>
@endsection
