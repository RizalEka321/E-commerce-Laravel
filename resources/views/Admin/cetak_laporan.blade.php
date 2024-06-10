<head>
    <title>Laporan CV. Lokal Industri</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }

        .total_semuanya tr td {
            font-size: 15px;
        }

        .signature {
            display: flex;
            justify-content: flex-end;
            margin-left: 240px;
            margin-top: 20px;
        }
    </style>
    <center>
        <h5>LAPORAN OMSET CV. LOKAL INDUSTRI</h5>
        <h6>BULAN {{ $bulan_huruf }} TAHUN {{ $tahun }}</h6>
    </center>
    <hr>
    <br>
    <h6>A. Data Proyek Besar</h6>
    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>No</th>
                <th>Instansi</th>
                <th>Item</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach ($proyek as $pro)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $pro->instansi }}</td>
                    <td>{{ $pro->item }}</td>
                    <td>{{ $pro->jumlah }}</td>
                    <td>Rp {{ number_format($pro->harga_satuan, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($pro->jumlah * $pro->harga_satuan, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h6>B. Data Pesanan Produk</h6>
    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>No</th>
                <th>Id Pesanan</th>
                <th>Pemesan</th>
                <th>Produk</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1 @endphp
            @foreach ($pesanan as $pe)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $pe->id_pesanan }}</td>
                    <td>{{ $pe->user->nama_lengkap }}</td>
                    <td>
                        <ul>
                            @foreach ($pe->detail as $detail)
                                <li>{{ $detail->produk->judul }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>Rp {{ number_format($pe->total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table>
        <tr>
            <td>
                <h5>Total Omset Bulan ini</h5>
                <table class="total_semuanya">
                    <tr>
                        <td>Total Omset Proyek Besar</td>
                        <td> : </td>
                        <td><b>Rp {{ number_format($total_omset_proyek, 0, ',', '.') }}</b></td>
                    </tr>
                    <tr>
                        <td>Total Omset Pesanan Produk</td>
                        <td> : </td>
                        <td><b>Rp {{ number_format($total_omset_pesanan, 0, ',', '.') }}</b></td>
                    </tr>
                    <tr>
                        <td>Total Keseluruhan</td>
                        <td> : </td>
                        <td><b>Rp {{ number_format($total_keseluruhan, 0, ',', '.') }}</b></td>
                    </tr>
                </table>
            </td>
            <td>
                <div class="signature">
                    <p>Mengetahui,</p>
                    <br>
                    <br>
                    <br>
                    <hr style="margin: 0%">
                    <p style="margin: 0%">(Thorik Kurnia Rahman)</p>
                    <p>Pemlik CV. Lokal Industri</p>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
