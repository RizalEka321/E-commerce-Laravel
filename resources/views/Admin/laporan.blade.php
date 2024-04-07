@extends('admin.layout.app')
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
                                    <input id="bulan" type="text" name="bulan" value="{{ old('bulan') }}"
                                        class="form-control" placeholder="Bulan" autofocus>
                                    <span class="form-text text-danger error-message"></span>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="tahun">Tahun :</label>
                                    <input id="tahun" type="text" name="tahun" value="{{ old('tahun') }}"
                                        class="form-control" placeholder="Tahun">
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
@section('script')
    <script>
        $(function() {
            $("#tahun").datepicker({
                format: 'yyyy',
                autoclose: true,
                todayHighlight: true,
            });
        });
    </script>
@endsection
