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

            <div class="card-body">

                @if ($errors->any())
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Periksa kembali data',
                                html: `{!! implode('<br>', $errors->all()) !!}`,
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#d4af37'
                            });
                        });
                    </script>
                @endif

                @if (session('error'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Input Ditolak',
                                text: @json(session('error')),
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#d4af37'
                            });
                        });
                    </script>
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
                        <label for="display_order" class="form-label">
                            Urutan Tampil
                        </label>

                        <input type="number" id="display_order" name="display_order"
                            class="form-control @error('display_order') is-invalid @enderror" min="1"
                            value="{{ old('display_order', $faq->display_order) }}" placeholder="Masukkan urutan tampil">

                        <small class="text-muted">
                            Semakin kecil angka, semakin atas FAQ ditampilkan.
                        </small>

                        @error('display_order')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
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
