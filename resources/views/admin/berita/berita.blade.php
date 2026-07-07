@extends('admin.layouts.app')

@section('title','Berita')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/berita.css') }}">
@endpush

@section('content')

{{-- isi halaman berita nanti --}}

@endsection

@push('scripts')
<script src="{{ asset('js/admin/berita.js') }}"></script>
@endpush
