@extends('Pembeli.layout.app')
@section('title', 'Profile')
@section('content')
    {{-- Paket Usaha --}}
    <section class="profile">
        <div class="container">
            <div class="row">
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="container pt-4">
                        <div class="col-lg-20">
                            <div class="row bg-white rounded">
                                <div class="col-md-4 col-lg-4 order-md-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-4">
                                                <div class="text-center px-5">
                                                    @if (Auth::user()->foto == null)
                                                        <img src="{{ asset('assets/pembeli/img/default.png') }}"
                                                            id="preview" class="rounded img-fluid"
                                                            style="width: 100%; height: 250px; object-fit: cover" />
                                                    @else
                                                        <img src="{{ asset('assets/users/' . Auth::user()->role . '/' . Auth::user()->id . '/foto/' . Auth::user()->foto) }}"
                                                            id="preview" class="rounded img-fluid"
                                                            style="width: 100%; height: 250px; object-fit: cover" />
                                                    @endif
                                                    <h5 class="my-3">{{ Auth::user()->nama_depan }}</h5>
                                                    <p class="text-muted text-center mb-3">
                                                        {{ '@' . Auth::user()->username }}
                                                    </p>
                                                    <div class="d-flex justify-content-center mb-2">
                                                        <input type="file" accept="image/*"
                                                            class="form-control text-muted @error('foto') is-invalid @enderror"
                                                            name="foto" id="foto" aria-describedby="avatarHelp"
                                                            style="display: none" onchange="PreviewImage()">
                                                        <input type="button" value="Ubah Avatar" class="btn-profile ms-1"
                                                            onclick="document.getElementById('foto').click();" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-8 order-md-1">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="mb-4">
                                                <div>
                                                    <div class="mb-4">
                                                        <label for="nama" class="form-label"
                                                            style="font-weight: 700">Nama</label>
                                                        <input type="text" class="form-control" name="nama"
                                                            id="nama" aria-describedby="namaHelp"
                                                            value="{{ Auth::user()->nama_lengkap }}">
                                                    </div>

                                                    <div class="mb-4">
                                                        <label for="username" class="form-label"
                                                            style="font-weight: 700">Username</label>
                                                        <input type="text" class="form-control" name="username"
                                                            id="username" aria-describedby="usernameHelp"
                                                            value="{{ Auth::user()->username }}" disabled>
                                                    </div>

                                                    <div class="mb-4">
                                                        <label for="email" class="form-label"
                                                            style="font-weight: 700">Email</label>
                                                        <input type="email" class="form-control" name="email"
                                                            id="email" aria-describedby="emailHelp"
                                                            value="{{ Auth::user()->email }}" disabled>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="no_hp" class="form-label"
                                                            style="font-weight: 700">Telepon</label>
                                                        <input type="no_hp" class="form-control" name="no_hp"
                                                            id="no_hp" value="{{ Auth::user()->no_hp }}">
                                                    </div>
                                                    <button type="submit" class="btn-profile">
                                                        <i class="nav-icon fas fa-save"></i>
                                                        Simpan
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script type="text/javascript" src="{{ asset('assets/js/reseller/alamat-autocomplete-profile.js') }}"></script>
    {{-- ./Paket Usaha --}}
@endsection
