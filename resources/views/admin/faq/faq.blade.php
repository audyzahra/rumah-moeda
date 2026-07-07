@extends('admin.layouts.app')

@section('title','FAQ')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/faq.css') }}">
@endpush

@section('content')

{{-- isi halaman FAQ nanti --}}

@endsection

@push('scripts')
<script src="{{ asset('js/admin/faq.js') }}"></script>
@endpush
