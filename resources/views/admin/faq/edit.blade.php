@extends('admin.layouts.app')

@section('title', 'Edit FAQ')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/faq.css') }}">
@endpush

@section('content')

    <!-- ================= HEADER ================= -->

    <header class="topbar">

        <div>

            <h1>Edit FAQ</h1>

            <p>
                Perbarui pertanyaan dan jawaban FAQ.
            </p>

        </div>

    </header>

    <!-- ================= BREADCRUMB ================= -->

    <div class="page-breadcrumb">

        <a href="{{ route('admin.faq.index') }}">
            FAQ
        </a>

        <span>></span>

        <span>Edit FAQ</span>

    </div>

    <!-- ================= FORM ================= -->

    <section>

        <div class="settings-card">

            <div class="card-header">

                <div>

                    <h3>

                        <i class="fa-solid fa-pen-to-square"></i>

                        Edit FAQ

                    </h3>

                    <p>

                        Perbarui data FAQ di bawah ini.

                    </p>

                </div>

                <a href="{{ route('admin.faq.index') }}" class="btn-secondary">

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

                <form action="{{ route('admin.faq.update', $faq) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <!-- Pertanyaan -->

                    <div class="form-group">

                        <label>

                            Pertanyaan

                            <span class="required">*</span>

                        </label>

                        <input type="text" name="question" class="form-control"
                            value="{{ old('question', $faq->question) }}" placeholder="Masukkan pertanyaan" required>

                    </div>

                    <!-- Jawaban -->

                    <div class="form-group">

                        <label>

                            Jawaban

                            <span class="required">*</span>

                        </label>

                        <x-tiptap name="answer" :value="old('answer', $faq->answer)" placeholder="Masukkan jawaban..." :image="false" />

                        @error('answer')
                            <small class="text-danger">

                                {{ $message }}

                            </small>
                        @enderror

                    </div>

                    <!-- Urutan -->

                    <div class="form-group">

                        <label>

                            Urutan Tampil

                        </label>

                        <input type="number" name="display_order" class="form-control" min="0"
                            value="{{ old('display_order', $faq->display_order) }}">

                        <small>
                            Semakin kecil angka, semakin atas FAQ ditampilkan.
                        </small>

                    </div>

                    <!-- BUTTON -->

                    <div class="form-actions">

                        <a href="{{ route('admin.faq.index') }}" class="btn-secondary">

                            Batal

                        </a>

                        <button type="submit" class="btn-primary">

                            <i class="fa-solid fa-floppy-disk"></i>

                            Update FAQ

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
