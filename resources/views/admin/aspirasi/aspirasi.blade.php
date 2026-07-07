@extends('admin.layouts.app')

@section('title','Aspirasi')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/aspirasi.css') }}">
@endpush

@section('content')

{{-- isi halaman aspirasi nanti --}}

@endsection

@push('scripts')
<script src="{{ asset('js/admin/aspirasi.js') }}"></script>
@endpush
