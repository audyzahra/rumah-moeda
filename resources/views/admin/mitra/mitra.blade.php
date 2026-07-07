@extends('admin.layouts.app')

@section('title','Mitra')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/mitra.css') }}">
@endpush

@section('content')

{{-- isi halaman mitra nanti --}}

@endsection

@push('scripts')
<script src="{{ asset('js/admin/mitra.js') }}"></script>
@endpush
