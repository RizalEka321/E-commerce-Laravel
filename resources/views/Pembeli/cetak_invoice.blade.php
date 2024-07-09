<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice CV. Lokal Industri</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .pembayaran-cash {
            color: #000;
            margin-top: 50px;
            margin-bottom: 50px;
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
            page-break-inside: avoid;
        }

        .card-image {
            background-color: #000;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            padding: 10px;
        }

        .card-image img {
            margin-left: 10px;
            width: 150px;
            height: 50px;
        }

        .header-kiri h5,
        .header-kanan h5,
        .header-kiri p {
            font-size: 18px;
        }

        .header-kanan {
            text-align: end;
        }

        .produk {
            margin-left: 40px;
            margin-right: 40px;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-table th,
        .invoice-table td {
            border-bottom: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .invoice-table th {
            background-color: #AAAAAA;
        }

        .invoice-summary {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
        }

        .summary-table {
            width: 380px;
            border-collapse: collapse;
            margin-left: 450px;
        }

        .summary-table td {
            padding: 2px;
        }

        .summary-table .description {
            text-align: left;
            width: 70%;
        }

        .summary-table .amount {
            text-align: right;
            width: 30%;
            font-weight: 700;
        }

        .summary-table .total {
            font-weight: bold;
            background-color: #D9D9D9;
            padding: 2px;
        }

        @page {
            size: A4 landscape;
            margin: 0;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .card {
                box-shadow: none;
                border: none;
                margin: 0;
            }

            .header-kanan {
                text-align: left;
            }

            .produk,
            .summary-table {
                margin: 0;
            }

            .pembayaran-cash {
                margin-top: 0;
                margin-bottom: 0;
                width: 100%;
                max-width: 100%;
                margin: 0 auto;
            }
        }
    </style>
</head>

<body>
    <section class="pembayaran-cash">
        <div class="container">
            <div class="card">
                <div class="card-image">
                    <img src="https://lokalindustri.com/assets/pembeli/img/logo_auth.png" alt="logo lokal industri">
                </div>
                <div class="card-body mb-4">
                    <div class="row">
                        <div class="col-lg-6 header-kiri">
                            <h5>ID Pesanan : {{ $pesanan->id_pesanan }}</h5>
                            <h5>Nota Untuk:</h5>
                            <h5>{{ $pesanan->user->nama_lengkap }}</h5>
                            <h5>{{ $pesanan->user->email }}</h5>
                            <p>{{ $pesanan->alamat_pengiriman }}</p>
                        </div>
                    </div>
                    <div class="produk">
                        <div class="invoice-details">
                            <table class="invoice-table">
                                <thead>
                                    <tr>
                                        <th style="width: 40%;">Produk</th>
                                        <th style="width: 20%;">Size</th>
                                        <th style="width: 10%;">Jumlah</th>
                                        <th style="width: 15%;">Harga</th>
                                        <th style="width: 15%;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detail as $d)
                                        <tr>
                                            <td>{{ $d->produk }}</td>
                                            <td>{{ $d->ukuran }}</td>
                                            <td>{{ $d->jumlah }}</td>
                                            <td>Rp. {{ number_format($d->harga, 0, '.', '.') }}</td>
                                            <td>Rp. {{ number_format($d->jumlah * $d->harga, 0, '.', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="invoice-summary">
                            <table class="summary-table">
                                <tbody>
                                    @if ($pesanan->metode_pembayaran == 'Cash')
                                        <tr>
                                            <td class="description">Total Harga ({{ $jml_barang }})</td>
                                            <td class="amount">Rp. {{ number_format($pesanan->total, 0, '.', '.') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="description total">Total Belanja</td>
                                            <td class="amount total">Rp.
                                                {{ number_format($pesanan->total, 0, '.', '.') }}</td>
                                        </tr>
                                    @elseif($pesanan->metode_pembayaran == 'Transfer')
                                        <tr>
                                            <td class="description">Biaya Admin</td>
                                            <td class="amount">Rp.
                                                {{ number_format($admin, 0, '.', '.') }}</td>
                                        </tr>
                                        @if ($pesanan->metode_pengiriman == 'Pickup')
                                            <tr>
                                                <td class="description total">Total Belanja</td>
                                                <td class="amount total">Rp.
                                                    {{ number_format($pesanan->total, 0, '.', '.') }}
                                                </td>
                                            </tr>
                                        @elseif($pesanan->metode_pengiriman == 'Transfer')
                                            <tr>
                                                <td class="description">Ongkos Kirim</td>
                                                <td class="amount">
                                                    {{ number_format($ongkir, 0, '.', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="description total">Total Belanja</td>
                                                <td class="amount total">Rp.
                                                    {{ number_format($pesanan->totald, 0, '.', '.') }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
