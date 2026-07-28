@extends('admin.layouts.app')

@section('title', 'FAQ')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/faq.css') }}">
@endpush

@section('content')

    <!-- ================= HEADER ================= -->

    <header class="topbar">

        <div>

            <h1>Manajemen FAQ</h1>

            <p>Kelola pertanyaan yang sering diajukan.</p>

        </div>
         <a href="{{ route('admin.faq.create') }}" class="btn-tambah">

                    <i class="fa-solid fa-plus"></i>

                    Tambah FAQ

                </a>

    </header>

    <!-- ================= CONTENT ================= -->

    <section class="faq-section">

        <div class="settings-card">


            <!-- Card Body -->

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table-admin">

                        <thead>

                            <tr>

                                <th width="90">Urutan</th>

                                <th>Pertanyaan</th>

                                <th>Jawaban</th>

                                <th width="190">Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($faqs as $faq)
                                <tr>

                                    <td>

                                        {{ $faq->display_order }}

                                    </td>

                                    <td>

                                        <strong>{{ $faq->question }}</strong>

                                    </td>

                                    <td>

                                        {{ Str::limit(strip_tags(html_entity_decode($faq->answer)), 80) }}

                                    </td>

                                    <td>

                                        <div class="action-buttons">

                                            <button type="button" class="btn-detail" data-question="{{ $faq->question }}"
                                                data-answer="{{ html_entity_decode($faq->answer) }}">
                                                <i class="fa-solid fa-eye"></i>
                                                Detail
                                            </button>

                                            <a href="{{ route('admin.faq.edit', $faq) }}" class="btn-edit">

                                                <i class="fa-solid fa-pen"></i>

                                                Edit

                                            </a>

                                            <form action="{{ route('admin.faq.destroy', $faq) }}" method="POST"
                                                class="delete-form">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn-delete">

                                                    <i class="fa-solid fa-trash"></i>

                                                    Hapus

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="4" class="text-center">

                                        Belum ada data FAQ.

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>
            <!-- ================= PAGINATION ================= -->

                        <div class="pagination-section">

                            <div class="info-data">

                                Menampilkan

                                <strong>{{ $faqs->firstItem() ?? 0 }}</strong>

                                -

                                <strong>{{ $faqs->lastItem() ?? 0 }}</strong>

                                dari

                                <strong>{{ $faqs->total() }}</strong>

                                data

                            </div>

                            <div class="pagination-controls">

                                {{-- Previous --}}
                                @if ($faqs->onFirstPage())

                                    <button class="page-btn" disabled>
                                        <i class="fa-solid fa-chevron-left"></i>
                                    </button>

                                @else

                                    <a href="{{ $faqs->previousPageUrl() }}" class="page-btn">
                                        <i class="fa-solid fa-chevron-left"></i>
                                    </a>

                                @endif

                                <span id="pageInfo">

                                    Halaman

                                    {{ $faqs->currentPage() }}

                                    dari

                                    {{ $faqs->lastPage() }}

                                </span>

                                {{-- Next --}}
                                @if ($faqs->hasMorePages())

                                    <a href="{{ $faqs->nextPageUrl() }}" class="page-btn">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </a>

                                @else

                                    <button class="page-btn" disabled>
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </button>

                                @endif

                            </div>

                        </div>

                </div>

            </div>

        </div>

    </section>


    <!-- ================= MODAL DETAIL FAQ ================= -->

    <div class="faq-modal" id="faqModal">

        <div class="faq-modal-content">

            <div class="faq-modal-header">

                <h3>
                    <i class="fa-solid fa-circle-question"></i>
                    Detail FAQ
                </h3>

                <button class="faq-close" id="closeFaqModal">
                    &times;
                </button>

            </div>


            <div class="faq-modal-body">


                <div class="detail-item">

                    <label>Pertanyaan</label>

                    <p id="detailQuestion"></p>

                </div>


                <div class="detail-item">

                    <label>Jawaban</label>

                    <div id="detailAnswer"></div>

                </div>


            </div>


        </div>

    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('js/admin/faq.js') }}"></script>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                Swal.fire({
                    icon: 'success',
                    title: '{{ session('title') ?? 'Berhasil!' }}',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#D4AF37',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false
                });

            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#dc3545'
                });

            });
        </script>
    @endif
@endpush
