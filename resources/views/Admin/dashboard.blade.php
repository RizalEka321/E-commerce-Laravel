@extends('Admin.Layout.app')
@section('title', 'Dashboard')
@section('content')
    <div class="card-boxes">
        <a class="kotak" href="#">
            <div class="box">
                <div class="right_side">
                    {{-- <div class="numbers">{{ $mobil }}</div> --}}
                    <div class="box_topic">Kendaraan</div>
                </div>
                <i class="fa-solid fa-car"></i>
            </div>
        </a>
        <a class="kotak" href="#">
            <div class="box">
                <div class="right_side">
                    {{-- <div class="numbers">{{ $user }}</div> --}}
                    <div class="box_topic">User</div>
                </div>
                <i class="fa-solid fa-users"></i>
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
