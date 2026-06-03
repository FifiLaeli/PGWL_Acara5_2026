@extends('layouts.template')

@section('styles')
<style>
    body {
        margin: 0;
        background-color: #f8f5f1;
    }

    .main-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }

    .main-header {
        background-color: #8B5E3C;
        color: white;
        padding: 20px;
    }

    .main-header h3 {
        margin: 0;
        font-weight: bold;
    }

    .main-body {
        padding: 25px;
        background-color: #ffffff;
    }

    .main-body p {
        text-align: justify;
        color: #555;
        line-height: 1.8;
    }

    .stats-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .stats-header {
        background-color: #A67B5B;
        color: white;
        text-align: center;
        padding: 15px;
    }

    .stats-header h5 {
        margin: 0;
        font-weight: 600;
    }

    .stats-body {
        background-color: white;
        text-align: center;
        padding: 25px;
    }

    .stats-body h1 {
        margin: 0;
        font-size: 40px;
        font-weight: bold;
        color: #6F4E37;
    }
</style>
@endsection

@section('content')

<div class="container mt-4">

    {{-- Card Utama --}}
    <div class="card main-card shadow-sm mb-4">

        <div class="main-header">
            <h3>Aplikasi Geospasial CRUD</h3>
        </div>

        <div class="main-body">
            <p>
                Selamat datang di halaman utama Aplikasi Geospasial CRUD.
                Aplikasi ini dirancang untuk membantu pengguna dalam mengelola
                dan menampilkan data geospasial secara interaktif dan informatif.
            </p>

            <p>
                Melalui fitur peta interaktif, Anda dapat melihat berbagai lokasi,
                menambahkan titik, garis (polyline), maupun polygon sesuai kebutuhan.
                Selain itu, tersedia juga tabel data untuk mempermudah pengelolaan
                serta pencarian informasi secara detail.
            </p>

            <p>
                Silakan jelajahi fitur-fitur yang tersedia dan manfaatkan aplikasi ini
                untuk mendukung kebutuhan pemetaan dan pengolahan data geospasial Anda.
            </p>
        </div>

    </div>

    {{-- Statistik --}}
    <div class="row g-4">

        {{-- Point --}}
        <div class="col-md-4">
            <div class="card stats-card">
                <div class="stats-header">
                    <h5>Jumlah Point</h5>
                </div>

                <div class="stats-body">
                    <h1>{{ $points_count }}</h1>
                </div>
            </div>
        </div>

        {{-- Polyline --}}
        <div class="col-md-4">
            <div class="card stats-card">
                <div class="stats-header">
                    <h5>Jumlah Polyline</h5>
                </div>

                <div class="stats-body">
                    <h1>{{ $polylines_count }}</h1>
                </div>
            </div>
        </div>

        {{-- Polygon --}}
        <div class="col-md-4">
            <div class="card stats-card">
                <div class="stats-header">
                    <h5>Jumlah Polygon</h5>
                </div>

                <div class="stats-body">
                    <h1>{{ $polygons_count }}</h1>
                </div>
            </div>
        </div>

        {{-- User --}}
        <div class="col-md-4">
            <div class="card stats-card">
                <div class="stats-header">
                    <h5>Jumlah User</h5>
                </div>

                <div class="stats-body">
                    <h1>{{ $users_count }}</h1>
                </div>
            </div>
        </div>



    </div>

</div>

@endsection

@section('scripts')
@endsection
