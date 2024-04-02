@extends('Pembeli.layout.app')
@section('title', 'Profile')
@section('content')
    {{-- Paket Usaha --}}
    <section class="profile">
        <div class="container">
            <hr class="my-2 hr-profile opacity-100" data-aos="flip-right" data-aos-delay="100">
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
                                                    @if (Auth::user()->avatar == null)
                                                        <img src="{{ asset('assets/img/icon/admin.png') }}" id="preview"
                                                            class="rounded img-fluid"
                                                            style="width: 100%; height: 250px; object-fit: cover" />
                                                    @else
                                                        <img src="{{ asset('assets/users/' . Auth::user()->role . '/' . Auth::user()->id . '/avatar/' . Auth::user()->avatar) }}"
                                                            id="preview" class="rounded img-fluid"
                                                            style="width: 100%; height: 250px; object-fit: cover" />
                                                    @endif
                                                    <h5 class="my-3">{{ Auth::user()->nama_depan }}</h5>
                                                    <p class="text-muted text-center mb-3">
                                                        {{ '@' . Auth::user()->username }}
                                                    </p>
                                                    <div class="d-flex justify-content-center mb-2">
                                                        <input type="file" accept="image/*"
                                                            class="form-control text-muted @error('avatar') is-invalid @enderror"
                                                            name="avatar" id="avatar" aria-describedby="avatarHelp"
                                                            style="display: none" onchange="PreviewImage()">
                                                        <input type="button" value="Ubah Avatar" class="btn-profile ms-1"
                                                            onclick="document.getElementById('avatar').click();" />
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
                                                            style="color:#CE3ABD; font-weight: 700">Nama</label>
                                                        <input type="text"
                                                            class="form-control text-muted @error('nama') is-invalid @enderror"
                                                            name="nama" id="nama" aria-describedby="namaHelp"
                                                            value="{{ Auth::user()->nama_depan }}">
                                                        @error('nama')
                                                            <div id="namaHelp" class="form-text">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-4">
                                                        <label for="username" class="form-label"
                                                            style="color:#CE3ABD; font-weight: 700">Username</label>
                                                        <input type="text"
                                                            class="form-control text-muted @error('username') is-invalid @enderror"
                                                            name="username" id="username" aria-describedby="usernameHelp"
                                                            value="{{ Auth::user()->username }}" disabled>
                                                        @error('username')
                                                            <div id="usernameHelp" class="form-text">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-4">
                                                        <label for="email" class="form-label"
                                                            style="color:#CE3ABD; font-weight: 700">Email</label>
                                                        <input type="email"
                                                            class="form-control text-muted @error('email') is-invalid @enderror"
                                                            name="email" id="email" aria-describedby="emailHelp"
                                                            value="{{ Auth::user()->email }}" disabled>
                                                        @error('email')
                                                            <div id="emailHelp" class="form-text">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>



                                                    {{-- <div class="mb-4">
                                                                <label for="jenisKelamin" class="form-label" style="color:#CE3ABD; font-weight: 700">Jenis Kelamin</label>
                                                                <select class="form-select"
                                                                    class="form-control text-muted @error('jenisKelamin') is-invalid @enderror"
                                                                    name="jenisKelamin" id="jenisKelamin"
                                                                    aria-label="Default select example">
                                                                    @if (Auth::user()->first_name == 'laki-laki')
                                                                        <option selected value="{{ Auth::user()->jenis_kelamin }}">
                                                                            Laki - laki</option>
                                                                        <option value="perempuan">Perempuan</option>
                                                                    @else
                                                                        <option value="laki-laki">
                                                                            Laki - laki</option>
                                                                        <option selected value="{{ Auth::user()->jenis_kelamin }}">Perempuan
                                                                        </option>
                                                                    @endif
                                                                </select>
                                                                @error('jenisKelamin')
                                                                    <div id="namaprodukHelp" class="form-text">{{ $message }}</div>
                                                                @enderror
                                                            </div> --}}

                                                    <div class="mb-4">
                                                        <label for="no_hp" class="form-label"
                                                            style="color:#CE3ABD; font-weight: 700">Telepon</label>
                                                        <input type="no_hp"
                                                            class="form-control text-muted @error('no_hp') is-invalid @enderror"
                                                            name="no_hp" id="no_hp"
                                                            value="{{ Auth::user()->no_hp }}">
                                                        @error('no_hp')
                                                            <div id="no_hpHelp" class="form-text">{{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-4">
                                                        <div class="autocomplete-container" id="autocomplete-container">
                                                            <label for="alamat" class="form-label">Alamat</label>
                                                            <div id="temp" hidden>{{ Auth::user()->alamat }}</div>
                                                        </div>
                                                        @error('alamat')
                                                            <div id="alamatHelp" class="form-text">
                                                                {{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <input type="hidden" id="latitude" name="latitude">
                                                    <input type="hidden" id="longitude" name="longitude">

                                                    <div class="mb-4">
                                                        <label for="berkas" class="form-label"
                                                            style="color:#CE3ABD; font-weight: 700">KTP</label>
                                                        <div class="row mb-3">
                                                            <div class="col-md-9">
                                                                <div class="file-upload">
                                                                    <div class="file-select">
                                                                        <div class="file-select-button" id="fileName">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="16" height="16"
                                                                                fill="currentColor"
                                                                                class="bi bi-upload fa-7x"
                                                                                viewBox="0 0 16 16">
                                                                                <path
                                                                                    d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                                                                <path
                                                                                    d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                                                                            </svg>
                                                                        </div>
                                                                        <div class="file-select-name" id="noFile">
                                                                            {{ Auth::user()->berkas }}</div>
                                                                        <input type="file"
                                                                            class="form-control @error('berkas') is-invalid @enderror"
                                                                            name="berkas" aria-describedby="berkasHelp"
                                                                            id="chooseFile" onchange="PreviewBerkas()">
                                                                        @error('berkas')
                                                                            <div id="namaprodukHelp" class="form-text">
                                                                                {{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <button type="button" class="btn text-light"
                                                                    id="button_berkas_user" data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModal">
                                                                    Lihat Berkas
                                                                </button>
                                                            </div>
                                                            <div class="modal fade" id="exampleModal" tabindex="-1"
                                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title fs-5"
                                                                                id="exampleModalLabel">Berkas KTP</h1>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            @if (Auth::user()->berkas == null)
                                                                                <h3>Berkas KTP Masih Kosong</h3>
                                                                            @else
                                                                                <embed type="application/pdf"
                                                                                    src="{{ asset('assets/users/' . Auth::user()->role . '/' . Auth::user()->id . '/berkasprofil/' . Auth::user()->berkas) }}"
                                                                                    width="100%" height="400"></embed>
                                                                            @endif
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-4">
                                                        <label for="password" class="form-label"
                                                            style="color:#CE3ABD; font-weight: 700">Password
                                                            Baru</label>
                                                        <input type="password"
                                                            class="form-control text-muted @error('password') is-invalid @enderror"
                                                            name="password" id="password">
                                                        @error('password')
                                                            <div id="passwordHelp" class="form-text">
                                                                {{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="password_confirmation" class="form-label"
                                                            style="color:#CE3ABD; font-weight: 700">Password
                                                            Konfirmasi</label>
                                                        <input type="password"
                                                            class="form-control text-muted @error('password_confirmation') is-invalid @enderror"
                                                            name="password_confirmation" id="password_confirmation">
                                                        @error('password_confirmation')
                                                            <div id="passwordConfirmationHelp" class="form-text">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
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
