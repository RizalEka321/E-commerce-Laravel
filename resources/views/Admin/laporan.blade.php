@extends('Admin.layout.app')
@section('title', 'Laporan')
@section('content')
    {{-- Data Tabel Katalog --}}
    <div id="tambah_data" class="details">
        <div class="content">
            <div class="card border-0">
                <div class="card_header mx-3 pt-1">
                    <h4 class="judul"><i class="fa-solid fa-book"></i> CETAK LAPORAN</h4>
                    <hr>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="form_tambah" action="{{ route('admin.laporan.cetak') }}" method="POST"
                    enctype="multipart/form-data" role="form">
                    @csrf
                    <div class="card-body">
                        <div class="row gx-5 mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label for="bulan_tahun">Bulan dan Tahun:</label>
                                    <input id="bulan_tahun" type="month" name="bulan_tahun"
                                        value="{{ old('bulan_tahun') }}" class="form-control" placeholder="Bulan dan Tahun"
                                        autofocus>
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" id="btn-simpan" class="btn-tambah">
                                <i class="fa-solid fa-print"></i>&nbsp;&nbsp; CETAK LAPORAN
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <style>
        /* Contoh gaya hover */
        input[type="month"]:hover {
            background-color: #f0f0f0;
        }
    </style>
@endsection
