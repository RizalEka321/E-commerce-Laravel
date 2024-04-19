@extends('Pembeli.layout.app')
@section('title', 'Detail Produk')
@section('content')
    <section class="checkout">
        <div class="container mb-5">
            <div class="konten">
                <div class="card">
                    <h1>Pembayaran Online</h1>
                    <div class="card-body">
                        <div class="row">
                            <button id="pay-button" class="btn-buatpesanan">Bayar Sekarang</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Sesuaikan dengan ukuran modal yang diinginkan -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Proses Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="snap-container" style="width:100%;height:100%;"></div>
                    <!-- Tetapkan lebar dan tinggi Snap container -->
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        // For example trigger on button clicked, or any time you need
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token.
            // Also, use the embedId that you defined in the div above, here.
            window.snap.embed('{{ $snapToken }}', {
                embedId: 'snap-container',
                onSuccess: function(result) {
                    /* You may add your own implementation here */
                    alert("payment success!");
                    console.log(result);
                },
                onPending: function(result) {
                    /* You may add your own implementation here */
                    alert("waiting your payment!");
                    console.log(result);
                },
                onError: function(result) {
                    /* You may add your own implementation here */
                    alert("payment failed!");
                    console.log(result);
                },
                onClose: function() {
                    /* You may add your own implementation here */
                    alert('you closed the popup without finishing the payment');
                }
            });

            // Show the modal after embedding the snap container
            $('#paymentModal').modal('show');
        });
    </script>
@endsection
