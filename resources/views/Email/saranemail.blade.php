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
            <h1>Saran dari Pengguna website</h1>
        </div>
        <table>
            <tr>
                <td class="label">Nama</td>
                <td class="value">: {{ $nama }}</td>
            </tr>
            <tr>
                <td class="label">Email</td>
                <td class="value">: {{ $email }}</td>
            </tr>
            <tr>
                <td class="label">Pesan</td>
                <td class="value">: {{ $pesan }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
