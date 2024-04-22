@extends('Admin.layout.app')
@section('title', 'Dashboard')
@section('content')
    <div class="card-boxes">
        <a class="kotak" href="#">
            <div class="box">
                <div class="right_side">
                    <div class="numbers">{{ $produk }}</div>
                    <div class="box_topic">Produk</div>
                </div>
                <i class="fa-solid fa-shirt"></i>
            </div>
        </a>
        <a class="kotak" href="#">
            <div class="box">
                <div class="right_side">
                    <div class="numbers">{{ $pesanan }}</div>
                    <div class="box_topic">Pesanan</div>
                </div>
                <i class="fa-solid fa-truck-fast"></i>
            </div>
        </a>
        <a class="kotak" href="#">
            <div class="box">
                <div class="right_side">
                    <div class="numbers">{{ $proyek }}</div>
                    <div class="box_topic">Proyek</div>
                </div>
                <i class="fa-solid fa-cube"></i>
            </div>
        </a>
        {{-- <div class="box">
        <div class="right_side">
            <div class="numbers">0</div>
            <div class="box_topic">Total Pembeli</div>
        </div>
        <i class='bx bx-user'></i>
    </div> --}}
    </div>
@endsection
