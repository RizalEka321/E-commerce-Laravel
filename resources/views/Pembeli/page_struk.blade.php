<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>INVOICE #YR{{ $transaksi->id }} </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            color: #333;
            text-align: left;
            font-size: 18px;
            margin: 0;
        }

        .container {
            margin: 0 auto;
            margin-top: 35px;
            padding: 40px;
            width: 750px;
            height: auto;
            background-color: #fff;
        }

        caption {
            font-size: 28px;
            margin-bottom: 15px;
        }

        table {
            border: 1px solid #333;
            border-collapse: collapse;
            margin: 0 auto;
            width: 740px;
        }

        td,
        tr,
        th {
            padding: 12px;
            border: 1px solid #333;
            width: 185px;
        }

        th {
            background-color: #f0f0f0;
        }

        h4,
        p {
            margin: 0px;
        }
    </style>
</head>

<body>
    <div class="container">
        <table>
            <caption>
                YokResell Transaksi
            </caption>
            <thead>
                <tr>
                    <th colspan="3">Transaksi <strong>#{{ $transaksi->id }}</strong></th>
                    <th>{{ $transaksi->created_at->format('D, d M Y') }}</th>
                </tr>
                <tr>
                    <td colspan="2">
                        <h4>Perusahaan: </h4>
                        <p>YokResell<br>
                            Jl. Mencari Cuan No. 666, Jakarta Pusat 10110<br>
                            +62 821-2123-4567<br>
                            yokresell@gmail.com
                        </p>
                    </td>
                    <td colspan="2">
                        <h4>Pelanggan: </h4>
                        <p>{{ $transaksi->users->username }}<br>
                            {{ $transaksi->users->alamat }}<br>
                            {{ $transaksi->users->no_hp }} <br>
                            {{ $transaksi->users->email }}
                        </p>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
                @foreach ($transaksi->detail_transaksi as $row)
                    <tr>
                        <td>{{ $row->nama_produk }}</td>
                        <td>Rp {{ number_format($row->harga) }}</td>
                        <td>{{ $row->qty }}</td>
                        <td>Rp {{ number_format($row->sub_total) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="3">Subtotal</th>
                    <td>Rp {{ number_format($transaksi->total) }}</td>
                </tr>
                {{-- <tr>
                    <th>Pajak</th>
                    <td></td>
                    <td>2%</td>
                    <td>Rp {{ number_format($transaksi->tax) }}</td>
                </tr> --}}
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total</th>
                    <td>Rp {{ number_format($transaksi->total) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
