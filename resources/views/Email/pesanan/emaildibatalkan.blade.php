<!DOCTYPE html>
<html>

<head>
    <title>Pesanan Mail</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 20px;
        }


        .header {
            margin-bottom: 20px;
        }

        .header img {
            max-width: 150px;
        }

        .header hr {
            border: none;
            border-top: 2px solid #ccc;
        }

        h1,
        h2 {
            color: #444;
        }

        .details {
            margin-top: 20px;
        }

        .details .detail-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            background: #f9f9f9;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .detail-item img {
            max-width: 100px;
            border-radius: 5px;
            margin-right: 15px;
        }

        .detail-item .item-info {
            flex: 1;
        }

        .item-info p {
            margin: 5px 0;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 0.9em;
            color: #777;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        td {
            padding: 5px 0;
        }

        .label {
            width: 18%;
            font-weight: bold;
        }

        .value {
            width: 82%;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="https://lokalindustri.com{{ asset('assets/pembeli/img/logonavbar_hitam.png') }}" alt="logo">
            <hr>
            <h1>Pesanan Dibatalkan</h1>
        </div>
        <h2>Detail Pesanan Anda</h2>
        <table>
            <tr>
                <td class="label">ID Pesanan</td>
                <td class="value">: {{ $pesanan->id_pesanan }}</td>
            </tr>
            <tr>
                <td class="label">Status</td>
                <td class="value">: {{ $pesanan->status }}</td>
            </tr>
            <tr>
                <td class="label">Metode Pembayaran</td>
                <td class="value">: {{ $pesanan->metode_pembayaran }}</td>
            </tr>
            <tr>
                <td class="label">Metode Pengiriman</td>
                <td class="value">: {{ $pesanan->metode_pengiriman }}</td>
            </tr>
            <tr>
                <td class="label">Total</td>
                <td class="value">: Rp. {{ number_format($pesanan->total, 0, ',', '.') }}</td>
            </tr>
        </table>
        <h2>Detail Produk</h2>
        <div class="details">
            @foreach ($pesanan->detail as $detail)
                <div class="detail-item">
                    <img src="https://lokalindustri.com/{{ $detail->produk->foto }}" alt="{{ $detail->produk->judul }}">
                    <div class="item-info">
                        <p><strong>Produk:</strong> {{ $detail->produk->judul }}</p>
                        <p><strong>Jumlah:</strong> {{ $detail->jumlah }}</p>
                        <p><strong>Ukuran:</strong> {{ $detail->ukuran }}</p>
                        <p><strong>Harga:</strong> Rp. {{ number_format($detail->produk->harga, 0, ',', '.') }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="footer">
            <p>Terima kasih telah berbelanja dengan kami!</p>
        </div>
    </div>
</body>

</html>
