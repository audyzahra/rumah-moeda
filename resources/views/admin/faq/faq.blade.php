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

    {{-- FILTER --}}
    <form method="GET" id="faqFilter">
        
        <input
            type="hidden"
            name="per_page"
            value="{{ request('per_page',5) }}">
            
        <input
            id="searchInput"
            type="text"
            name="search"
            value="{{ request('search') }}"
            class="search-input"
            placeholder="Cari FAQ...">

        <select
            id="sortFaq"
            name="sort"
            class="filter-select">

            <option value="">Urutkan</option>

            <option value="oldest"
                {{ request('sort')=='oldest' ? 'selected' : '' }}>
                Terlama
            </option>

            <option value="question_asc"
                {{ request('sort')=='question_asc' ? 'selected' : '' }}>
                Pertanyaan A-Z
            </option>

            <option value="question_desc"
                {{ request('sort')=='question_desc' ? 'selected' : '' }}>
                Pertanyaan Z-A
            </option>

        </select>

    </form>

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

                        <div class="custom-pagination">

                            {{-- ==========================================
                                SHOW ENTRIES
                            ========================================== --}}
                            <div class="pagination-left">

                                <form method="GET" id="perPageForm">

                                    @foreach(request()->except('per_page','page') as $key => $value)

                                        <input
                                            type="hidden"
                                            name="{{ $key }}"
                                            value="{{ $value }}">

                                    @endforeach

                                    <span>Tampilkan</span>

                                    <select
                                        name="per_page"
                                        id="perPageSelect"
                                        onchange="this.form.submit()">

                                        <option value="5" {{ request('per_page',5)==5 ? 'selected' : '' }}>
                                            5
                                        </option>

                                        <option value="10" {{ request('per_page')==10 ? 'selected' : '' }}>
                                            10
                                        </option>

                                        <option value="20" {{ request('per_page')==20 ? 'selected' : '' }}>
                                            20
                                        </option>

                                        <option value="50" {{ request('per_page')==50 ? 'selected' : '' }}>
                                            50
                                        </option>

                                    </select>

                                    <span>FAQ</span>

                                </form>

                            </div>


                            {{-- ==========================================
                                INFO DATA
                            ========================================== --}}
                            <div class="pagination-center">

                                <span>Menampilkan</span>

                                <strong>{{ $faqs->firstItem() ?? 0 }}</strong>

                                <span>-</span>

                                <strong>{{ $faqs->lastItem() ?? 0 }}</strong>

                                <span>dari</span>

                                <strong>{{ $faqs->total() }}</strong>

                                <span>data</span>

                            </div>


                            {{-- ==========================================
                                PAGINATION
                            ========================================== --}}
                            <div class="pagination-right">

                                {{-- Previous --}}
                                @if($faqs->onFirstPage())

                                    <button class="page-btn" disabled>

                                        <i class="fa-solid fa-chevron-left"></i>

                                    </button>

                                @else

                                    <a
                                        href="{{ $faqs->previousPageUrl() }}"
                                        class="page-btn">

                                        <i class="fa-solid fa-chevron-left"></i>

                                    </a>

                                @endif


                                @php

                                    $start = max($faqs->currentPage() - 1, 1);

                                    $end = min($start + 1, $faqs->lastPage());

                                    if($end - $start < 1){

                                        $start = max($end - 1, 1);

                                    }

                                @endphp


                                @for($page = $start; $page <= $end; $page++)

                                    @if($page == $faqs->currentPage())

                                        <span class="page-number active">

                                            {{ $page }}

                                        </span>

                                    @else

                                        <a
                                            href="{{ $faqs->url($page) }}"
                                            class="page-number">

                                            {{ $page }}

                                        </a>

                                    @endif

                                @endfor


                                {{-- Next --}}
                                @if($faqs->hasMorePages())

                                    <a
                                        href="{{ $faqs->nextPageUrl() }}"
                                        class="page-btn">

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
