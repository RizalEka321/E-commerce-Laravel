@extends('Pembeli.layout.app')
@section('title', 'Detail Produk')
@section('content')
    <style>
        .radio-toolbar input[type="radio"] {
            display: none;
        }

        .radio-toolbar label {
            display: inline-block;
            border: 1px solid #ddd;
            padding: 10px 20px;
            margin-right: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .radio-toolbar input[type="radio"]:checked+label {
            background-color: var(--red);
            color: #fff
        }

        .radio-toolbar input[type="radio"]+label:hover {
            transition: transform .2s;
            color: var(--red);
            border: 1px solid var(--red)
        }

        /*--------------------------*/
        .qty-container {
            display: flex;
            align-items: left;
            justify-content: flex-start;
        }

        .qty-container .input-qty {
            text-align: center;
            padding: 6px 10px;
            border: 1px solid #d4d4d4;
            max-width: 80px;
        }

        .qty-container .qty-btn-minus,
        .qty-container .qty-btn-plus {
            border: 1px solid #d4d4d4;
            padding: 10px 13px;
            font-size: 10px;
            height: 38px;
            width: 38px;
            transition: 0.3s;
        }

        .qty-container .qty-btn-plus {
            margin-left: -1px;
        }

        .qty-container .qty-btn-minus {
            margin-right: -1px;
        }

        .qty-btn-minus:hover {
            transition: transform .2s;
            color: var(--white);
            background: var(--red);
        }

        .qty-btn-plus:hover {
            transition: transform .2s;
            color: var(--white);
            background: var(--red);
        }
    </style>
    {{-- Detail Produk --}}
    <section class="detail-produk">
        <div class="container">
            <hr class="my-2 hr-detail opacity-100" data-aos="flip-right" data-aos-delay="100">
            <div class="row mt-3 py-2">
                <div class="col-md-3 col-lg-5">
                    <img src="{{ asset($produk_detail->foto) }}" class="card-img-top" alt="...">
                </div>
                <div class="col-md-5 col-lg-7 pt-2">
                    <h3 class="title">{{ $produk_detail->judul }}</h3>
                    <div class="price p-4 mb-3">
                        <h2>Rp {{ number_format($produk_detail->harga, 0, '.', '.') }}</h2>
                    </div>
                    <div>
                        <form id="form_tambah" action="{{ url('/keranjang/create') }}" method="POST" role="form">
                            <input type="hidden" name="produk_id" value="{{ $produk_detail->id_produk }}">
                            <div class="mb-3">
                                <label for="ukuran">Ukuran</label>
                                <div class="radio-toolbar">
                                    @foreach ($produk_detail->ukuran as $u)
                                        @if ($u->stok != null)
                                            <input type="radio" id="radio{{ $u->id_ukuran }}" name="ukuran"
                                                value="{{ $u->jenis_ukuran }}">
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
                            <button type="submit" class="btn-keranjang"><i class="fa-solid fa-cart-shopping"></i>
                                Masukkan
                                Keranjang</button>
                            <a href="#" class="btn-beli">Beli Sekarang</a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="description row my-2 py-2">
                <h4 class="title">Deskripsi</h4>
                <div class="mx-2">
                    {!! $produk_detail->deskripsi !!}
                </div>
            </div>
        </div>
    </section>
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

        function reset_errors() {
            $('.error-message').empty();
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

        $(function() {
            $('#form_tambah').submit(function(event) {
                event.preventDefault();
                event.stopImmediatePropagation();
                var url = $(this).attr('action');
                var formData = new FormData($(this)[0]);

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
                            console.log(data)
                            $.each(data.errors, function(key, value) {
                                // Show error message below each input
                                $('#' + key).next('.error-message').text('*' + value);
                            });
                        } else {
                            reset_form();
                            Swal.fire(
                                'Sukses',
                                'Produk Berhasil Dimasukkan Keranjang',
                                'success'
                            );
                            reload_table();
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
        });
    </script>
@endsection
