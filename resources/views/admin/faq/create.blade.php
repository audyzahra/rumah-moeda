@extends('admin.layouts.app')

@section('title', 'Tambah FAQ')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/faq.css') }}">
@endpush

@section('content')

<!-- ================= HEADER ================= -->

<header class="topbar">

    <div>

        <h1>Tambah FAQ</h1>

        <p>
            Tambahkan pertanyaan dan jawaban baru.
        </p>

    </div>

</header>

<!-- ================= BREADCRUMB ================= -->

<div class="page-breadcrumb">

    <a href="{{ route('admin.faq.index') }}">
        FAQ
    </a>

    <span>></span>

    <span>Tambah FAQ</span>

</div>

<!-- ================= FORM ================= -->

<section>

    <div class="settings-card">

        <div class="card-header">

            <div>

                <h3>

                    <i class="fa-solid fa-circle-question"></i>

                    Tambah FAQ

                </h3>

                <p>

                    Isi data FAQ di bawah ini.

                </p>

            </div>

            <a href="{{ route('admin.faq.index') }}"
               class="btn-secondary">

                <i class="fa-solid fa-arrow-left"></i>

                Kembali

            </a>

        </div>

        <div class="card-body">

            @if ($errors->any())

                <div class="alert alert-danger">

                    <ul>

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form
                action="{{ route('admin.faq.store') }}"
                method="POST">

                @csrf

                <div class="form-group">

                    <label>

                        Pertanyaan

                        <span class="required">*</span>

                    </label>

                    <input
                        type="text"
                        name="question"
                        class="form-control"
                        placeholder="Masukkan pertanyaan"
                        value="{{ old('question') }}"
                        required>

                </div>

                <div class="form-group">

                    <label>

                        Jawaban

                        <span class="required">*</span>

                    </label>

                    <textarea
                        name="answer"
                        rows="6"
                        class="form-control"
                        placeholder="Masukkan jawaban"
                        required>{{ old('answer') }}</textarea>

                </div>

                <div class="form-group">

                    <label>

                        Urutan Tampil

                    </label>

                    <input
                        type="number"
                        name="display_order"
                        class="form-control"
                        min="0"
                        value="{{ old('display_order', 0) }}">

                    <small>
                        Semakin kecil angka, semakin atas FAQ ditampilkan.
                    </small>

                </div>

                <div class="form-actions">

                    <a href="{{ route('admin.faq.index') }}"
                       class="btn-secondary">

                        Batal

                    </a>

                    <button
                        type="submit"
                        class="btn-primary">

                        <i class="fa-solid fa-floppy-disk"></i>

                        Simpan FAQ

                    </button>

                </div>

            </form>

        </div>

    </div>

</section>

@endsection

@push('scripts')
<script src="{{ asset('js/admin/faq.js') }}"></script>
@endpush