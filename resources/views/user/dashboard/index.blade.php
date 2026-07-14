@extends('user.layouts.app')

@section('title', 'Dashboard User')

@section('content')

<div class="dashboard-page">

    <div class="dashboard-cards">

        <div class="dashboard-card">

            <h3>Total Berita</h3>

            <h1>{{ $totalNews }}</h1>

        </div>

        <div class="dashboard-card">

            <h3>Total Dokumentasi</h3>

            <h1>{{ $totalDocumentation }}</h1>

        </div>

        <div class="dashboard-card">

            <h3>Total Aspirasi</h3>

            <h1>{{ $totalAspirasi }}</h1>

        </div>

    </div>

</div>

@endsection
