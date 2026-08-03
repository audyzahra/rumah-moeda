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

                <form action="{{ route('admin.faq.store') }}" method="POST">

                    @csrf

                    <div class="form-group">

                        <label>

                            Pertanyaan

                            <span class="required">*</span>

                        </label>

                        <input type="text" name="question" class="form-control" placeholder="Masukkan pertanyaan"
                            value="{{ old('question') }}" required>

                    </div>

                    <div class="form-group">

                        <label>

                            Jawaban

                            <span class="required">*</span>

                        </label>

                        <x-tiptap name="answer" :value="old('answer')" placeholder="Masukkan jawaban..." :image="false" />

                        @error('answer')
                            <small class="text-danger">

                                {{ $message }}

                            </small>
                        @enderror

                    </div>

                    <div class="form-group">

                        <label>

                            Urutan Tampil

                        </label>

                        <input type="number" name="display_order"
                            class="form-control @error('display_order') is-invalid @enderror" min="1"
                            value="{{ old('display_order', $nextOrder) }}">

                        @error('display_order')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <small>
                            Semakin kecil angka, semakin atas FAQ ditampilkan.
                        </small>

                    </div>

                    <div class="form-actions">

                        <a href="{{ route('admin.faq.index') }}" class="btn-secondary">

                            Batal

                        </a>

                        <button type="submit" class="btn-primary">

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
