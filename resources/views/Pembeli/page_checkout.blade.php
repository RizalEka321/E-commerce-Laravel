@extends('Pembeli.layout.app')
@section('title', 'Detail Produk')
@section('content')
    <section class="checkout">
        <div class="container">
            <div class="konten_produk">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div>
                                    <h6>Alamat Pengiriman:</h6>
                                    <p>{{ Auth::user()->alamat }} <button type="button" class="btn btn-primary"
                                            data-bs-toggle="modal" data-bs-target="#modal_alamat">
                                            <i class="fa-solid fa-pencil"></i>
                                        </button></p>
                                </div>
                                <div>
                                    <h6>No. Telepon:</h6>
                                    <p>{{ Auth::user()->no_hp }} <button type="button" class="btn btn-primary"
                                            data-bs-toggle="modal" data-bs-target="#modal_no_hp">
                                            <i class="fa-solid fa-pencil"></i></button></p>
                                </div>
                                <!-- Button trigger modal -->

                                <!-- Modal -->
                                <div class="modal fade" id="modal_alamat" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h1>Alamat</h1>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade" id="modal_no_hp" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h1>No HP</h1>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach ($checkout as $item)
                            <div class="card mb-4">
                                <div class="card-body d-flex">
                                    <div class="card-image me-3">
                                        <img src="{{ asset($item->produk->foto) }}" class="card-title" alt="Image 1">
                                    </div>
                                    <div class="card-content">
                                        <h5 class="card-title">
                                            {{ $item->produk->judul }}
                                        </h5>
                                        <p class="card-text">Size,
                                            <span>{{ $item->ukuran }}</span>
                                        </p>
                                        <div class="nav-item position-relative">
                                            <div class="price position-absolute top-0 end-0">
                                                <h5>{{ $item->jumlah }} X Rp.
                                                    {{ number_format($item->produk->harga, 0, '.', '.') }}
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <form id="form_tambah" action="{{ url('/pemesanan-store') }}" method="POST"
                            enctype="multipart/form-data" role="form">
                            <div class="card mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="ukuran">Metode Pembayaran
                                        <button type="button" class="btn" data-bs-toggle="modal"
                                            data-bs-target="#info_pembayaran">
                                            <i class="fa-solid fa-circle-info"></i>
                                        </button>
                                    </label>
                                    <div class="radio-toolbar d-flex">
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

                            <div class="card">
                                <div class="d-flex justify-content-between align-items-center">
                                    <label for="ukuran">Metode Pengiriman<button type="button" class="btn"
                                            data-bs-toggle="modal" data-bs-target="#info_pengiriman">
                                            <i class="fa-solid fa-circle-info"></i>
                                        </button></label>
                                    <div class="radio-toolbar d-flex">
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
                    <div class="col-lg-4">
                        <di class="card">
                            <h6>Ringkasan Belanja</h6>
                            <div class="d-flex justify-content-between">
                                <h6>Total Harga ({{ $total_barang }} Barang)</h6>
                                <h6 class="text-left">Rp. {{ number_format($total_harga, 0, ',', '.') }}</h6>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6>Ongkos Kirim</h6>
                                <h6 class="text-left">Rp. {{ number_format($ongkir, 0, ',', '.') }}</h6>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6>Biaya Admin</h6>
                                <h6 class="text-left">Rp. {{ number_format($admin, 0, ',', '.') }}</h6>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <h6>Total Belanja</h6>
                                <h6 class="text-left">Rp. {{ number_format($total_keseluruhan, 0, ',', '.') }}</h6>
                            </div>
                            <button class="btn-bayar"><i class="fa-solid fa-shield"></i> Bayar</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="container mb-5">
            <div class="konten">
                <div class="card border-0">
                </div>
            </div>
        </div>
        <!-- Modal Pembayaran -->
        <div class="modal fade" id="info_pembayaran" tabindex="-1" aria-labelledby="modal_pembayaran"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modal_pembayaran"><i class="fa-solid fa-money-bills"></i> Metode
                            Pembayaran</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6>1. Cash</h6>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum reprehenderit a voluptatum ab esse
                            ipsum natus obcaecati exercitationem minima! Amet, commodi. Reiciendis voluptatem vero, aliquam
                            itaque magni possimus rem error ut at odit consectetur cupiditate incidunt nulla quis ipsam
                            ullam blanditiis iste similique obcaecati veniam optio a maxime neque ratione?</p>
                        <h6>2. Transfer</h6>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum reprehenderit a voluptatum ab esse
                            ipsum natus obcaecati exercitationem minima! Amet, commodi. Reiciendis voluptatem vero, aliquam
                            itaque magni possimus rem error ut at odit consectetur cupiditate incidunt nulla quis ipsam
                            ullam blanditiis iste similique obcaecati veniam optio a maxime neque ratione?</p>
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
                        <h1 class="modal-title fs-5" id="modal_pengiriman"><i class="fa-solid fa-truck"></i> Metode
                            Pengiriman</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6>1. Pickup</h6>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum reprehenderit a voluptatum ab esse
                            ipsum natus obcaecati exercitationem minima! Amet, commodi. Reiciendis voluptatem vero, aliquam
                            itaque magni possimus rem error ut at odit consectetur cupiditate incidunt nulla quis ipsam
                            ullam blanditiis iste similique obcaecati veniam optio a maxime neque ratione?</p>
                        <h6>2. Delivery</h6>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum reprehenderit a voluptatum ab esse
                            ipsum natus obcaecati exercitationem minima! Amet, commodi. Reiciendis voluptatem vero, aliquam
                            itaque magni possimus rem error ut at odit consectetur cupiditate incidunt nulla quis ipsam
                            ullam blanditiis iste similique obcaecati veniam optio a maxime neque ratione?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-batal" data-bs-dismiss="modal">Close</button>
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

        window.addEventListener('beforeunload', function(event) {
            // Lakukan request Ajax untuk membatalkan pesanan
            handleLeavePage();
        });

        window.addEventListener('popstate', function(event) {
            // Panggil fungsi untuk menangani permintaan saat pengguna meninggalkan halaman
            handleLeavePage();
        });

        function handleLeavePage() {
            // Lakukan permintaan AJAX untuk membatalkan pesanan
            $.ajax({
                url: "{{ url('/pemesanan-out') }}", // Ganti dengan URL endpoint yang sesuai
                type: "POST",
                dataType: "JSON",
                processData: false,
                contentType: false,
                success: function(response) {
                    // Handle respons dari server jika diperlukan
                    console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                }
            });
        }

        function reset_form() {
            $('#form_tambah')[0].reset();
        }

        function reset_errors() {
            $('.error-message').empty();
        }

        $('.btn-bayar').click(function(e) {
            e.preventDefault();
            var url = $('#form_tambah').attr('action');
            var formData = new FormData($('#form_tambah')[0]);

            // showLoading();
            $.ajax({
                url: url,
                type: "POST",
                dataType: "JSON",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    $('.error-message').empty();
                    if (data.errors) {
                        $.each(data.errors, function(key, value) {
                            // Menampilkan pesan error di bawah setiap input
                            $('#' + key).next('.error-message').text('*' + value);
                        });
                        Swal.fire("Error", "Datanya ada yang kurang", "error");
                    } else {
                        window.location.href = data.redirect;
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                },
                complete: function() {
                    // hideLoading();
                }
            });
        });
    </script>
@endsection
