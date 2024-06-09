@extends('Pembeli.layout.app')
@section('title', 'Detail Produk')
@section('content')
    <section class="pembayaran-transfer">
        <div class="container mb-5">
            <div class="card" id="snap">
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var snapToken = "{{ $pesanan->snaptoken }}";
            window.snap.embed(snapToken, {
                embedId: 'snap',
                onSuccess: function(result) {
                    window.location.href = '/pesanan-saya';
                    console.log(result);
                },
                onPending: function(result) {
                    alert("waiting your payment!");
                    console.log(result);
                },
                onError: function(result) {
                    alert("payment failed!");
                    console.log(result);
                },
                onClose: function() {
                    alert('you closed the popup without finishing the payment');
                }
            });
        });
    </script>
@endsection
