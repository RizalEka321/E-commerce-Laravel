@extends('Pembeli.layout.app')
@section('title', 'Detail Produk')
@section('content')
    <section class="pemesanan">
        <div class="container mb-5">
            <div class="konten">
                <div class="card" id="snap"> <!-- Perbaiki penulisan ID di sini -->
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var snapToken = "{{ $pesanan->snaptoken }}";
            window.snap.embed(snapToken, {
                embedId: 'snap', // Tetapkan embedId ke ID div di mana Anda ingin menyematkan Snap
                onSuccess: function(result) {
                    window.location.href = '/pesanan-saya';
                    console.log(result);
                },
                onPending: function(result) {
                    /* Anda dapat menambahkan implementasi khusus Anda di sini */
                    alert("waiting your payment!");
                    console.log(result);
                },
                onError: function(result) {
                    /* Anda dapat menambahkan implementasi khusus Anda di sini */
                    alert("payment failed!");
                    console.log(result);
                },
                onClose: function() {
                    /* Anda dapat menambahkan implementasi khusus Anda di sini */
                    alert('you closed the popup without finishing the payment');
                }
            });
        });
    </script>
@endsection
