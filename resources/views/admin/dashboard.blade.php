@extends('admin.layouts.app')

@section('title','Dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
@endpush

@section('content')

<!-- Isi Dashboard -->

@endsection

@push('scripts')
<script src="{{ asset('js/admin/dashboard.js') }}"></script>
@endpush
