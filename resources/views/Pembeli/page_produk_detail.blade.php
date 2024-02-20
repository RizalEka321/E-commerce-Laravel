@extends('layouts_reseller.app')
@section('title', 'Detail Produk')
@section('content')
    <style>
        #lokasi {
            border-radius: 5px;
            height: 600px;
            width: 100%;
        }
    </style>
    {{-- Detail Produk --}}
    <section class="detail-produk">
        <div class="container">
            <hr class="my-2 hr-detail opacity-100" data-aos="flip-right" data-aos-delay="100">
            <div class="row mt-3 py-2">
                <div class="col-md-3 col-lg-5">
                    <img src="{{ asset('assets/users/' . $produk->users->role . '/' . $produk->users_id . '/' . $produk->foto) }}"
                        class="card-img-top" alt="...">
                </div>
                <div class="col-md-5 col-lg-7 pt-2">
                    <h3 class="title">{{ $produk->nama_produk }}</h3>
                    <table class="mb-3">
                        <tbody class="rating">
                            <tr>
                                <td>
                                    @if ($rating == null)
                                        0
                                    @else
                                        <u>{{ str_replace('...', '', Str::limit($rating, 3)) }}</u>
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $rating)
                                                <i class="fa fa-star checked"></i>
                                            @endif
                                        @endfor
                                    @endif
                                </td>
                                <td>&nbsp|&nbsp</td>
                                <td>{{ $nilai }} Penilaian</td>
                                <td>&nbsp|&nbsp</td>
                                <td>{{ $terjual }} Terjual</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="price p-4">
                        <h2>Rp {{ number_format($produk->harga, 0, '.', '.') }}</h2>
                    </div>
                    <div class="my-3">
                        <!-- Button trigger modal -->
                        @if ($produk->jenis == 'paket_usaha')
                            <button type="button" class="btn-resell" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fa-solid fa-location-dot"></i> Lihat Lokasi
                            </button>
                        @endif
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Lokasi Anda</h1>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table text-center">
                                            <tr>
                                                <td>
                                                    <p><img src="{{ asset('assets/img/icon/user_lokasi.png') }}"> : Lokasi
                                                        Anda</p>
                                                </td>
                                                <td>
                                                    @if ($produk->users->latitude)
                                                        <p><img src="{{ asset('assets/img/icon/lokasi_pengusaha.png') }}"> :
                                                            Pemilik Usaha</p>
                                                    @endif
                                                    <p id="latitude" hidden>{{ $produk->users->latitude }}</p>
                                                    <p id="longitude" hidden>{{ $produk->users->longitude }}</p>
                                                </td>
                                                <td>
                                                    <p><img src="{{ asset('assets/img/icon/shop_lokasi.png') }}"> : Usaha
                                                        terdekat yang sama</p>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="location" id="lokasi"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn-resell" data-bs-dismiss="modal">Kembali</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('keranjang.add', $produk->id) }}" class="btn-resell"><i
                                class="fa-solid fa-cart-shopping"></i> Masukkan Keranjang</a>
                    </div>
                </div>
            </div>

            <style>
                .checked {
                    color: #CE3ABDe;
                }
            </style>

            <div class="description row my-2 py-2">
                <h4 class="title">Deskripsi</h4>
                <div class="mx-2">
                    {!! $produk->deskripsi !!}
                </div>
            </div>

            <div class="review row mb-3 py-2">
                <h4>Penilaian Produk</h4>

                @livewire('review', ['produk_id' => $produk->id])

            </div>
        </div>
    </section>
    {{-- End Detail Produk --}}
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoNyOpCm5oQ4vlUSfaQX5_dDd06ZNGQR4&libraries=places">
    </script>
    <script>
        function initMap() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert('Geolocation is not supported by this browser.');
            }

            function showPosition(position) {
                var latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                var reseller_lat = position.coords.latitude;
                var reseller_long = position.coords.longitude;

                var map = new google.maps.Map(document.getElementById('lokasi'), {
                    center: latLng,
                    zoom: 13
                });
                // Reseller
                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    icon: '{{ asset('assets/img/icon/user_lokasi.png') }}',
                    animation: google.maps.Animation.BOUNCE,
                    title: 'Lokasi Saya'
                });
                var circle = new google.maps.Circle({
                    strokeColor: '#CE3ABD',
                    strokeOpacity: 0.5,
                    strokeWeight: 2,
                    fillColor: '#CE3ABD',
                    fillOpacity: 0.1,
                    map: map,
                    center: latLng,
                    radius: 5000 // Radius dalam meter (5 km)
                });

                var request = {
                    location: latLng,
                    radius: 4000, // Radius dalam meter (4 km)
                    keyword: '{{ $produk->nama_produk }}' // Kata kunci yang ingin dicari
                };

                // Pengusaha
                var pengusaha_lat = parseFloat(document.getElementById('latitude').innerHTML);
                var pengusaha_long = parseFloat(document.getElementById('longitude').innerHTML);

                var marker = new google.maps.Marker({
                    position: {
                        lat: pengusaha_lat,
                        lng: pengusaha_long
                    },
                    map: map,
                    icon: '{{ asset('assets/img/icon/lokasi_pengusaha.png') }}',
                    title: 'Lokasi Pengusaha'
                });
                var circle = new google.maps.Circle({
                    strokeColor: 'red',
                    strokeOpacity: 0.5,
                    strokeWeight: 2,
                    fillColor: '#CE3ABD',
                    fillOpacity: 0.2,
                    map: map,
                    center: {
                        lat: pengusaha_lat,
                        lng: pengusaha_long
                    },
                    radius: 1000 // Radius dalam meter (5 km)
                });

                // Garis Penghubung Reseller dan Pengusaha
                var startPoint = {
                    lat: reseller_lat,
                    lng: reseller_long
                };
                var endPoint = {
                    lat: pengusaha_lat,
                    lng: pengusaha_long
                };

                var lineCoordinates = [startPoint, endPoint];

                var line = new google.maps.Polyline({
                    path: lineCoordinates,
                    geodesic: true,
                    strokeColor: '#CE3ABD',
                    strokeOpacity: 1.0,
                    strokeWeight: 2
                });

                line.setMap(map);

                // Nearby Location
                var service = new google.maps.places.PlacesService(map);
                service.nearbySearch(request, callback);

                function callback(results, status) {
                    if (status == google.maps.places.PlacesServiceStatus.OK) {
                        for (var i = 0; i < results.length; i++) {
                            createMarker(results[i]);
                        }
                    }
                }

                function createMarker(place) {
                    var marker = new google.maps.Marker({
                        map: map,
                        position: place.geometry.location,
                        icon: '{{ asset('assets/img/icon/shop_lokasi.png') }}',
                        title: place.name
                    });

                    var infowindow = new google.maps.InfoWindow({
                        content: place.name
                    });

                    marker.addListener('click', function() {
                        infowindow.open(map, marker);
                    });
                }
            }
        }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCoNyOpCm5oQ4vlUSfaQX5_dDd06ZNGQR4&libraries=places&callback=initMap&t={{ time() }}">
    </script>
@endsection
