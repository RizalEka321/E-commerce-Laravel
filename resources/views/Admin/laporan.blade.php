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
                <form id="form_tambah" action="{{ route('admin.laporan.cetak') }}" method="POST" enctype="multipart/form-data"
                    role="form">
                    @method('post')
                    @csrf
                    <div class="card-body">
                        <div class="row gx-5 mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label for="bulan">Bulan :</label>
                                    <select id="bulan" name="bulan" class="form-control">
                                        <option value="">-- Pilih Bulan --</option>
                                        <option value="1">Januari</option>
                                        <option value="2">Februari</option>
                                        <option value="3">Maret</option>
                                        <option value="4">April</option>
                                        <option value="5">Mei</option>
                                        <option value="6">Juni</option>
                                        <option value="7">Juli</option>
                                        <option value="8">Agustus</option>
                                        <option value="9">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="tahun">Tahun :</label>
                                    <select id="tahun" name="tahun" class="form-control">
                                        <option value="">-- Pilih Tahun --</option>
                                        @foreach ($tahun as $t)
                                            <option value="{{ $t }}">{{ $t }}</option>
                                        @endforeach
                                    </select>
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" id="btn-simpan" class="btn-tambah"><i
                                    class="fa-solid fa-print"></i>&nbsp;&nbsp; CETAK LAPORAN</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
