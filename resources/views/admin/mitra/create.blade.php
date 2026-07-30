@extends('admin.layouts.app')

@section('title', 'Tambah Mitra')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/mitra.css') }}">
@endpush

@section('content')

    <!-- ================= HEADER ================= -->

    <header class="topbar">

        <div>

            <h1>Tambah Mitra</h1>

            <p>
                Tambahkan data mitra baru.
            </p>

        </div>

    </header>

    <!-- ================= BREADCRUMB ================= -->

    <div class="page-breadcrumb">

        <a href="{{ route('admin.partners.index') }}">

            Mitra

        </a>

        <span>></span>

        <span>Tambah Mitra</span>

    </div>

    <!-- ================= FORM ================= -->

    <section class="partner-management-section">

        <div class="settings-card">

            <div class="card-body">

                @if ($errors->any())
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Data belum lengkap',
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
                                confirmButtonColor: '#dc2626'
                            });
                        });
                    </script>
                @endif

                <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    <div class="form-row">

                        <div class="form-group form-group-half">

                            <label>

                                Nama Mitra

                                <span class="required">*</span>

                            </label>

                            <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                placeholder="Masukkan nama mitra" required>

                        </div>

                        <div class="form-group form-group-half">

                            <label>

                                Website

                            </label>

                            <input type="text" name="website" class="form-control" value="{{ old('website') }}"
                                placeholder="https://example.com">

                        </div>

                    </div>
                    <div class="form-row">

                        <div class="form-group form-group-half">

                            <label>

                                Urutan Tampil

                            </label>

                            <input type="number" name="display_order"
                                class="form-control @error('display_order') is-invalid @enderror" min="1"
                                value="{{ old('display_order', $nextOrder) }}">

                        </div>

                        <div class="form-group form-group-half">

                            <label>

                                Logo Mitra

                            </label>

                            <input type="file" name="logo" class="form-control" accept="image/*">

                        </div>

                    </div>
                    <div class="form-group">

                        <label>

                            Deskripsi

                        </label>

                        <textarea name="description" rows="5" class="form-control" placeholder="Masukkan deskripsi mitra">{{ old('description') }}</textarea>

                    </div>

                    <div class="form-actions">

                        <a href="{{ route('admin.partners.index') }}" class="btn-secondary">
                            <i class="fa-solid fa-xmark"></i>
                            Batal
                        </a>

                        <button type="submit" class="btn-primary">
                            <i class="fa-solid fa-floppy-disk"></i>
                            Simpan Mitra
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </section>

@endsection

@push('scripts')
    <script src="{{ asset('js/admin/mitra.js') }}"></script>
@endpush
