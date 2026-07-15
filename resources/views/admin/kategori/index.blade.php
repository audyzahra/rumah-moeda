@extends('admin.layouts.app')

@section('title', 'Kategori')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/kategori.css') }}">
@endpush

@section('content')

    <div class="kategori-container">

        {{-- ================= HEADER ================= --}}
        <div class="kategori-header">

            <div>

                <h1>Kategori</h1>

                <p>Kelola kategori berita Rumah Moeda.</p>

            </div>

        </div>  


        {{-- ================= TOOLBAR ================= --}}
        <div class="kategori-toolbar">

            <form action="{{ route('admin.kategori.index') }}" method="GET" class="search-form">

                <input type="text" name="search" class="search-input" placeholder="Cari kategori..."
                    value="{{ request('search') }}">

            </form>

            <a href="{{ route('admin.kategori.create') }}" class="btn-primary">

                <i class="fa-solid fa-plus"></i>

                Tambah Kategori

            </a>

        </div>

        {{-- ================= TABLE ================= --}}
        <div class="table-wrapper">

            <table class="kategori-table">

                <thead>

                    <tr>

                        <th width="70">No</th>

                        <th>Nama Kategori</th>

                        <th width="170">Jumlah Berita</th>

                        <th width="220">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($categories as $category)
                        <tr>

                            <td>

                                {{ $categories->firstItem() + $loop->index }}

                            </td>

                            <td>

                                {{ $category->name }}

                            </td>

                            <td>

                                <span class="badge-news">

                                    {{ $category->news_count }}

                                </span>

                            </td>

                            <td>

                                <div class="action-group">

                                    {{-- DETAIL --}}
                                    <a href="{{ route('admin.kategori.show', $category->id) }}" class="btn-detail">

                                        <i class="fa-solid fa-eye"></i>

                                    </a>

                                    {{-- EDIT --}}
                                    <a href="{{ route('admin.kategori.edit', $category->id) }}" class="btn-edit">

                                        <i class="fa-solid fa-pen"></i>

                                    </a>

                                    {{-- DELETE --}}
                                    <form action="{{ route('admin.kategori.destroy', $category->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn-delete">

                                            <i class="fa-solid fa-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4">

                                <div class="empty-state">

                                    <i class="fa-solid fa-folder-open"></i>

                                    <h3>

                                        Belum ada kategori

                                    </h3>

                                    <p>

                                        Tambahkan kategori pertama.

                                    </p>

                                </div>

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- ================= PAGINATION ================= --}}
        <div class="pagination-wrapper">

            {{ $categories->links() }}

        </div>

    </div>

@endsection
