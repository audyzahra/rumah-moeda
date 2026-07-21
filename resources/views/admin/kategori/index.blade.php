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

            <form action="{{ route('admin.categories.index') }}" method="GET" class="search-form">

                <input type="text" name="search" class="search-input" placeholder="Cari kategori..."
                    value="{{ request('search') }}">

            </form>

            <a href="{{ route('admin.categories.create') }}" class="btn-primary">

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
                                    <a href="{{ route('admin.categories.show', $category->id) }}" class="btn-detail">

                                        <i class="fa-solid fa-eye"></i>

                                    </a>

                                    {{-- EDIT --}}
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn-edit">

                                        <i class="fa-solid fa-pen"></i>

                                    </a>

                                    {{-- DELETE --}}
                                    <button type="button" class="btn-delete" onclick="deleteKategori({{ $category->id }})">

                                        <i class="fa-solid fa-trash"></i>

                                    </button>

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
@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {

    Swal.fire({
        icon: 'success',
        title: '{{ session("title") ?? "Berhasil!" }}',
        text: '{{ session("success") }}',
        confirmButtonColor: '#D4AF37',
        timer: 2000,
        timerProgressBar: true,
        showConfirmButton: false
    });

});
</script>
@endif

@if(session('error'))
<script>
document.addEventListener('DOMContentLoaded', function () {

    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session("error") }}',
        confirmButtonColor: '#dc2626'
    });

});
</script>
@endif

<script>

function deleteKategori(id) {

    Swal.fire({
        title: 'Hapus Kategori?',
        text: 'Kategori yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {

        if (result.isConfirmed) {

            const form = document.createElement('form');

            form.method = 'POST';
            form.action = `/admin/categories/${id}`;

            form.innerHTML = `
                <input type="hidden" name="_token"
                    value="${document.querySelector('meta[name="csrf-token"]').content}">
                <input type="hidden" name="_method" value="DELETE">
            `;

            document.body.appendChild(form);
            form.submit();

        }

    });

}

</script>

@endpush
