@extends('admin.layouts.app')

@section('title','FAQ')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/faq.css') }}">
@endpush

@section('content')

<header class="topbar">
    <div>
        <h1>Manajemen FAQ</h1>
        <p>Kelola pertanyaan yang sering diajukan.</p>
    </div>
</header>

<div class="filter-section">

    <button class="btn-tambah"
            data-bs-toggle="modal"
            data-bs-target="#tambahModal">
        <i class="fa-solid fa-plus"></i>
        Tambah FAQ
    </button>

</div>

<table class="table">

    <thead>

        <tr>
            <th>No</th>
            <th>Urutan</th>
            <th>Pertanyaan</th>
            <th>Jawaban</th>
            <th width="170">Aksi</th>
        </tr>

    </thead>

    <tbody>

    @forelse($faqs as $faq)

        <tr>

            <td>{{ $loop->iteration }}</td>

            <td>{{ $faq->display_order }}</td>

            <td>{{ $faq->question }}</td>

            <td>{{ Str::limit($faq->answer,80) }}</td>

            <td>

                <button
                    class="btn btn-warning btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#editModal{{ $faq->id }}">
                    Edit
                </button>

                <form
                    action="{{ route('admin.faq.destroy',$faq) }}"
                    method="POST"
                    style="display:inline">

                    @csrf
                    @method('DELETE')

                    <button
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Hapus FAQ ini?')">

                        Hapus

                    </button>

                </form>

            </td>

        </tr>

        {{-- ================= EDIT MODAL ================= --}}

        <div class="modal fade" id="editModal{{ $faq->id }}">

            <div class="modal-dialog modal-lg">

                <div class="modal-content">

                    <form
                        action="{{ route('admin.faq.update',$faq) }}"
                        method="POST">

                        @csrf
                        @method('PUT')

                        <div class="modal-header">

                            <h5>Edit FAQ</h5>

                            <button
                                class="btn-close"
                                data-bs-dismiss="modal"></button>

                        </div>

                        <div class="modal-body">

                            <div class="mb-3">

                                <label>Pertanyaan</label>

                                <input
                                    type="text"
                                    name="question"
                                    class="form-control"
                                    value="{{ $faq->question }}"
                                    required>

                            </div>

                            <div class="mb-3">

                                <label>Jawaban</label>

                                <textarea
                                    name="answer"
                                    class="form-control"
                                    rows="5"
                                    required>{{ $faq->answer }}</textarea>

                            </div>

                            <div class="mb-3">

                                <label>Urutan</label>

                                <input
                                    type="number"
                                    name="display_order"
                                    class="form-control"
                                    value="{{ $faq->display_order }}">

                            </div>

                        </div>

                        <div class="modal-footer">

                            <button
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">

                                Batal

                            </button>

                            <button class="btn btn-primary">

                                Simpan

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    @empty

        <tr>

            <td colspan="5" align="center">
                Belum ada data FAQ.
            </td>

        </tr>

    @endforelse

    </tbody>

</table>

{{-- ================= TAMBAH MODAL ================= --}}

<div class="modal fade" id="tambahModal">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form
                action="{{ route('admin.faq.store') }}"
                method="POST">

                @csrf

                <div class="modal-header">

                    <h5>Tambah FAQ</h5>

                    <button
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label>Pertanyaan</label>

                        <input
                            type="text"
                            name="question"
                            class="form-control"
                            required>

                    </div>

                    <div class="mb-3">

                        <label>Jawaban</label>

                        <textarea
                            name="answer"
                            class="form-control"
                            rows="5"
                            required></textarea>

                    </div>

                    <div class="mb-3">

                        <label>Urutan</label>

                        <input
                            type="number"
                            name="display_order"
                            class="form-control"
                            value="0">

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button class="btn btn-success">

                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection