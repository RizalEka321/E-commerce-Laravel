@extends('Pembeli.layout.app')
@section('title', 'Detail Produk')
@section('content')
    <section class="checkout">
        <div class="container">
            <div class="konten">
                <table id="tabel_keranjang" class="table table-condensed">
                    <thead>
                        <tr>
                            <th width="50%">Produk Dipesan</th>
                            <th width="10%">Harga</th>
                            <th width="8%">Kuantitas</th>
                            <th width="22%">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($checkout as $item)
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-sm-3 hidden-xs"><img src="{{ asset($item->produk->foto) }}"
                                                width="100" height="100" class="img-responsive" /></div>
                                        <div class="col-sm-9">
                                            <h5 class="nomargin">{{ $item->produk->judul }}</h5>
                                            <h6 class="nomargin">Ukuran {{ $item->ukuran }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>Rp {{ number_format($item->produk->harga, 0, '.', '.') }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>Rp {{ number_format($item->produk->harga * $item->jumlah, 0, '.', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-end">
                                <h3><strong>Total <span id="total_keranjang">Rp
                                            {{ number_format($total_harga, 0, '.', '.') }}</span></strong></h3>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="container mb-5">
            <div class="konten">
                <div class="card border-0">
                    <form id="form_tambah" action="{{ url('/pemesanan-store') }}" method="POST"
                        enctype="multipart/form-data" role="form">
                        @csrf
                        @method('post')
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="alamat_pengiriman">Alamat :</label>
                                    <textarea id="alamat_pengiriman" name="alamat_pengiriman" class="form-control" placeholder="Masukkan Alamat"
                                        id="alamat">{{ Auth::user()->alamat }}</textarea>
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="no_hp">No Handphone(HP) :</label>
                                    <input id="no_hp" type="text" name="no_hp" value="{{ Auth::user()->no_hp }}"
                                        class="form-control" placeholder="Masukkan No HP">
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="ukuran">Metode Pembayaran<button type="button" class="btn"
                                        data-bs-toggle="modal" data-bs-target="#info_pembayaran">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </button></label>
                                <div class="radio-toolbar">
                                    <input type="radio" id="radio_cash" name="metode_pembayaran" value="Cash">
                                    <label for="radio_cash">CASH</label>
                                    <input type="radio" id="radio_transfer" name="metode_pembayaran" value="Transfer">
                                    <label for="radio_transfer">TRANSFER</label>
                                </div>
                            </div>
                            <div class="mb-5">
                                <label for="ukuran">Metode Pengiriman<button type="button" class="btn"
                                        data-bs-toggle="modal" data-bs-target="#info_pengiriman">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </button></label>
                                <div class="radio-toolbar">
                                    <input type="radio" id="radio_pickup" name="metode_pengiriman" value="Pickup">
                                    <label for="radio_pickup">PICKUP</label>
                                    <input type="radio" id="radio_delivery" name="metode_pengiriman" value="Delivery">
                                    <label for="radio_delivery">DELIVERY</label>
                                </div>
                            </div>
                            <div class="card-footer mb-3">
                                {{-- <a type="button" id="btn-close" class="btn-batal"><i
                                        class='nav-icon fas fa-arrow-left'></i>&nbsp;&nbsp; BATALKAN</a> --}}
                                <button type="submit" id="btn-simpan" class="btn-buatpesanan"><i
                                        class="nav-icon fas fa-save"></i>&nbsp;&nbsp; BUAT PESANAN</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal Pembayaran -->
        <div class="modal fade" id="info_pembayaran" tabindex="-1" aria-labelledby="modal_pembayaran" aria-hidden="true">
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

        function reset_form() {
            $('#form_tambah')[0].reset();
        }

        function reset_errors() {
            $('.error-message').empty();
        }

        // window.addEventListener('beforeunload', function(event) {
        //     // Lakukan request Ajax untuk membatalkan pesanan
        //     handleLeavePage();
        // });

        // window.addEventListener('popstate', function(event) {
        //     // Panggil fungsi untuk menangani permintaan saat pengguna meninggalkan halaman
        //     handleLeavePage();
        // });

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
    </script>
@endsection
