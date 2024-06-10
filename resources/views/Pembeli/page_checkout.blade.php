@extends('Pembeli.layout.app')
@section('title', 'Checkout Produk')
@section('content')
    <section class="checkout">
        <h1 class="title">Checkout</h1>
        <div class="container">
            <div class="konten_produk">
                <div class="row">
                    <div class="col-lg-8 kiri">
                        <div class="card identitas">
                            <div class="card-body">
                                <div>
                                    <h6>Alamat Pengiriman:</h6>
                                    <p id="alamatku">{{ Auth::user()->alamat }}<button type="button" class="btn-tulis"
                                            onclick="update_alamat()">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </button></p>
                                    <div id="isi-alamat" class="hidden">
                                        <form id="form_alamat"
                                            action="{{ url('/checkout/update-alamat') }}?q={{ Auth::user()->id }}"
                                            method="post">
                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat Baru</label>
                                                <textarea id="alamat" name="alamat" class="input-besar"></textarea>
                                                <span class="form-text text-danger error-message"></span>
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" class="btn-bayar">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div>
                                    <h6>No. Telepon:</h6>
                                    <p id="nohpku">{{ Auth::user()->no_hp }} <button type="button" class="btn-tulis"
                                            onclick="update_nohp()">
                                            <i class="fa-regular fa-pen-to-square"></i></button></p>
                                    <div id="isi-nohp" class="hidden">
                                        <form id="form_nohp"
                                            action="{{ url('/checkout/update-nohp') }}?q={{ Auth::user()->id }}"
                                            method="post">
                                            <div class="mb-3">
                                                <label for="no_hp" class="form-label">No. Telepon Baru</label>
                                                <input type="text" id="no_hp" name="no_hp" class="input-kecil">
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" class="btn-bayar">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach ($checkout as $item)
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <div class="row">
                                                <div class="col-lg-5 foto">
                                                    <div class="d-flex justify-content-between">
                                                        <img src="{{ asset($item->produk->foto) }}" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-7 foto-detail">
                                                    <h5>{{ $item->produk->judul }}</h5>
                                                    <h6 class="size">Size, {{ $item->ukuran }}</h6>
                                                    <h6>Rp. {{ number_format($item->produk->harga, 0, ',', '.') }} x
                                                        {{ $item->jumlah }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="sub-harga me-3">
                                                <h6 class="jumlah-harga">Rp.
                                                    {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <form id="form_checkout" action="{{ url('/checkout-store') }}" method="POST"
                            enctype="multipart/form-data" role="form">
                            <div class="card metode">
                                <button type="button" class="btn-metode" data-bs-toggle="modal"
                                    data-bs-target="#info_pembayaran">
                                    <i class="fa-solid fa-circle-info"></i>
                                </button>
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="ukuran">Metode Pembayaran :</label>
                                    <div class="radio-checkout">
                                        <div class="mr-2">
                                            <input type="radio" id="radio_cash" name="metode_pembayaran" value="Cash">
                                            <label for="radio_cash">CASH</label>
                                        </div>
                                        <div>
                                            <input type="radio" id="radio_transfer" name="metode_pembayaran"
                                                value="Transfer">
                                            <label for="radio_transfer">TRANSFER</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card metode hidden" id="metode-pengiriman">
                                <button type="button" class="btn-metode" data-bs-toggle="modal"
                                    data-bs-target="#info_pengiriman">
                                    <i class="fa-solid fa-circle-info"></i>
                                </button>
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="ukuran">Metode Pengiriman :</label>
                                    <div class="radio-checkout d-flex">
                                        <input type="radio" id="radio_pickup" name="metode_pengiriman" value="Pickup">
                                        <label for="radio_pickup">PICKUP</label>
                                        <input type="radio" id="radio_delivery" name="metode_pengiriman"
                                            value="Delivery">
                                        <label for="radio_delivery">DELIVERY</label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 kanan">
                        <div class="card">
                            <h6 class="total">Ringkasan Belanja</h6>
                            <div class="d-flex justify-content-between">
                                <h6>Total Harga ({{ $total_barang }} Barang)</h6>
                                <h6 class="text-left">Rp. {{ number_format($total_harga, 0, ',', '.') }}</h6>
                            </div>
                            <div class="hidden" id="biaya-ongkir">
                                <div class="d-flex justify-content-between">
                                    <h6>Ongkos Kirim</h6>
                                    <h6 class="text-left">Rp. {{ number_format($ongkir, 0, ',', '.') }}</h6>
                                </div>
                            </div>
                            <div class="hidden" id="biaya-admin">
                                <div class="d-flex justify-content-between">
                                    <h6>Biaya Admin</h6>
                                    <h6 class="text-left">Rp. {{ number_format($admin, 0, ',', '.') }}</h6>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <h6 class="total">Total Belanja</h6>
                                <h6 class="text-left" id="total-belanja">Rp.
                                    {{ number_format($total_harga, 0, ',', '.') }}</h6>
                            </div>
                            <button class="btn-bayar" id="btn-bayar"><i class="fa-solid fa-shield"></i> Bayar</button>
                        </div>
                    </div>
                </div>
                <!-- Modal Pembayaran -->
                <div class="modal fade" id="info_pembayaran" tabindex="-1" aria-labelledby="modal_pembayaran"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modal_pembayaran"><i
                                        class="fa-solid fa-money-bills"></i> Metode
                                    Pembayaran</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h6>1. Cash</h6>
                                <p>Anda dapat melakukan pembayaran secara tunai dengan datang langsung ke kantor CV. Lokal
                                    Industri dengan menunjukkan nota pembelian Anda. Silakan pastikan untuk membawa jumlah
                                    yang sesuai dengan total pesanan Anda.</p>
                                <h6>2. Transfer</h6>
                                <p>Anda dapat melakukan pemabayaran secara transfer dengan memilih antara transfer antar
                                    bank atau dari e-wallet. Setelah memilih metode, anda akan diberikan Virtual
                                    Account (VA) atau QR Code yang harus dibayar dalam waktu maksimal 24 jam setelah
                                    checkout. Hal ini memastikan bahwa pesanan dapat segera diproses. Metode ini memberikan
                                    kemudahan dan keamanan dalam bertransaksi online bagi pelanggan Lokal Industri.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn-batal" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Pengiriman -->
                <div class="modal fade" id="info_pengiriman" tabindex="-1" aria-labelledby="modal_pengiriman"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modal_pengiriman"><i class="fa-solid fa-truck"></i>
                                    Metode
                                    Pengiriman</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h6>1. Pickup</h6>
                                <p>Jika Anda memilih opsi pickup, Anda dapat mengambil pesanan Anda langsung dari lokasi
                                    kami setelah pesanan Anda selesai diproses. Kami akan memberikan informasi lengkap
                                    mengenai lokasi dan jam operasional kami sehingga Anda dapat melakukan pengambilan
                                    dengan mudah.
                                </p>
                                <h6>2. Delivery</h6>
                                <p>Jika Anda memilih opsi delivery, pesanan Anda akan dikirim langsung ke alamat yang Anda
                                    tentukan. Kami bekerja sama dengan layanan pengiriman terpercaya untuk memastikan
                                    pesanan Anda tiba dengan aman dan tepat waktu.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn-batal" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        // Global Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let isCheckoutInProgress = false;

        window.addEventListener('beforeunload', function(event) {
            if (!isCheckoutInProgress) {
                handleLeavePage();
            }
        });

        window.addEventListener('popstate', function(event) {
            if (!isCheckoutInProgress) {
                handleLeavePage();
            }
        });

        function handleLeavePage() {
            $.ajax({
                url: "{{ url('/checkout-batalkan') }}",
                type: "POST",
                dataType: "JSON",
                processData: false,
                contentType: false,
            });
        }

        $(document).ready(function() {
            $('input[name="metode_pembayaran"]').on('change', function() {
                var total_harga = '{{ number_format($total_harga, 0, ',', '.') }}';
                if ($(this).val() === 'Transfer') {
                    $('#metode-pengiriman').removeClass('hidden');
                } else {
                    $('#metode-pengiriman').addClass('hidden');
                    $('#biaya-ongkir').addClass('hidden');
                    $('#biaya-admin').addClass('hidden');
                    $('#total-belanja').text('Rp. ' + total_harga);
                    $('input[name="metode_pengiriman"]').prop('checked', false);
                }
            });

            $('input[name="metode_pengiriman"]').on('change', function() {
                var total_with_OD = '{{ number_format($total_with_OD, 0, ',', '.') }}';
                var total_with_OP = '{{ number_format($total_with_OP, 0, ',', '.') }}';

                if ($(this).val() === 'Delivery') {
                    $('#biaya-ongkir').removeClass('hidden');
                    $('#biaya-admin').removeClass('hidden');
                    $('#total-belanja').text('Rp. ' + total_with_OD);
                } else if ($(this).val() === 'Pickup') {
                    $('#biaya-ongkir').addClass('hidden');
                    $('#biaya-admin').removeClass('hidden');
                    $('#total-belanja').text('Rp. ' + total_with_OP);
                }
            });
        });

        $('#btn-bayar').click(function(e) {
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

            e.preventDefault();
            var url = $('#form_checkout').attr('action');
            var formData = new FormData($('#form_checkout')[0]);

            $.ajax({
                url: url,
                type: "POST",
                dataType: "JSON",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.errors) {
                        Swal.close();
                        let errorMessages = '';
                        $.each(response.errors, function(key, value) {
                            errorMessages += value + '<br>';
                        });
                        Swal.fire({
                            title: 'Error',
                            html: errorMessages,
                            icon: 'error',
                            confirmButtonText: 'Oke',
                            confirmButtonColor: '#000000'
                        });
                    } else {
                        window.location.href = response.redirect;
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Terjadi kesalahan saat memproses pembayaran.',
                        icon: 'error',
                        position: 'center',
                        showConfirmButton: false,
                        timer: 3000,
                        toast: false
                    });
                }
            });
        });

        function update_alamat() {
            $('#isi-alamat').toggleClass('hidden');
        }

        $(function() {
            $('#form_alamat').submit(function(event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                var url = $(this).attr('action');
                var formData = new FormData($(this)[0]);

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
                            $.each(response.errors, function(key, value) {
                                $('#' + key).next('.error-message').text('*' + value);
                            });
                        } else {
                            $('.error-message').empty();
                            $('#form_alamat')[0].reset();
                            $('#isi-alamat').addClass('hidden');
                            $('#alamatku').html(response.alamat +
                                `<button type="button" class="btn-tulis" onclick="update_alamat()"><i class="fa-regular fa-pen-to-square"></i></button>`
                            );
                            Swal.fire({
                                title: 'Sukses',
                                text: 'Alamat berhasil diperbarui',
                                icon: 'success',
                                position: 'center',
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
                            text: 'Terjadi kesalahan saat memperbarui alamat',
                            icon: 'error',
                            position: 'center',
                            showConfirmButton: false,
                            timer: 3000,
                            toast: false
                        });
                    }
                });
            });
        });

        function update_nohp() {
            $('#isi-nohp').toggleClass('hidden');
        }

        $(function() {
            $('#form_nohp').submit(function(event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                var url = $(this).attr('action');
                var formData = new FormData($(this)[0]);

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
                            $.each(response.errors, function(key, value) {
                                $('#' + key).next('.error-message').text('*' + value);
                            });
                        } else {
                            $('.error-message').empty();
                            $('#form_nohp')[0].reset();
                            $('#isi-nohp').addClass('hidden');
                            $('#nohpku').html(response.nohp +
                                `<button type="button" class="btn-tulis" onclick="update_nohp()"><i class="fa-regular fa-pen-to-square"></i></button>`
                            );
                            Swal.fire({
                                title: 'Sukses',
                                text: 'Nomor HP berhasil diperbarui',
                                icon: 'success',
                                position: 'center',
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
                            text: 'Terjadi kesalahan saat memperbarui nomor HP',
                            icon: 'error',
                            position: 'center',
                            showConfirmButton: false,
                            timer: 3000,
                            toast: false
                        });
                    }
                });
            });
        });
    </script>
@endsection
