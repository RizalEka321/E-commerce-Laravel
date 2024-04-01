<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eloquent Relationships : Relasi One to One & Many To Many</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="card mt-5">
            <div class="card-body">
                <h3 class="text-center"><a href="https://santrikoding.com">www.santrikoding.com</a></h3>
                <h5 class="text-center my-4">Laravel Eloquent Relationship : One To One & Many To Many</h5>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Ukuran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                            <tr>
                                <td>{{ $d->judul }}</td>
                                <td>{{ $d->ukuran }}</td>
                                <td>
                                    @foreach ($d->ukuran()->get() as $r)
                                        <button class="btn btn-sm btn-primary me-2">{{ $r->jenis_ukuran }}</button>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
