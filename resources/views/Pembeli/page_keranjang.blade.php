@extends('Pembeli.layout.app')
@section('title', 'Keranjang')
@section('content')
    {{-- Keranjang --}}
    <section class="detail-produk">
        <div class="container">
            <hr class="my-2 hr-detail opacity-100" data-aos="flip-right" data-aos-delay="100">
            <table id="cart" class="table table-hover table-condensed mt-5">
                <thead>
                    <tr>
                        <th style="width:50%">Produk</th>
                        <th style="width:10%">Harga</th>
                        <th style="width:8%">Jumlah</th>
                        <th style="width:22%" class="text-center">Subtotal</th>
                        <th style="width:10%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($keranjang as $k)
                        <tr data-id="{{ $k->id }}">
                            <td data-th="Product">
                                <div class="row">
                                    <div class="col-sm-3 hidden-xs"><img src="{{ asset($k->produk->foto) }}" width="100"
                                            height="100" class="img-responsive" /></div>
                                    <div class="col-sm-9">
                                        <h4 class="nomargin">{{ $k->produk->judul }}</h4>
                                    </div>
                                </div>
                            </td>
                            <td data-th="Price">Rp. {{ $k->produk->harga }}</td>
                            <td data-th="Quantity">
                                <input type="number" value="{{ $k->jumlah }}"
                                    class="form-control quantity update-cart" />
                            </td>
                            <td data-th="Subtotal" class="text-center">Rp. {{ $k->jumlah * $k->produk->harga }}</td>
                            <td class="actions" data-th="">
                                <button class="btn btn-danger btn-sm remove-from-cart">hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-right">
                            <h3><strong>Total Rp. <span id="total"></span></strong></h3>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right">
                            <button class="btn btn-success">Checkout</button>
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
        $(document).ready(function() {
            function updateTotal() {
                $.ajax({
                    url: '{{ route('keranjang.total') }}',
                    method: "GET",
                    success: function(response) {
                        $('#total').text(response.total);
                    }
                });
            }

            $(".update-cart").change(function() {
                var id = $(this).closest('tr').data('id');
                var quantity = $(this).val();
                $.ajax({
                    url: '{{ route('keranjang.update') }}',
                    method: "patch",
                    data: {
                        id: id,
                        quantity: quantity
                    },
                    success: function(response) {
                        updateTotal();
                    }
                });
            });
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
    </script>
@endsection
