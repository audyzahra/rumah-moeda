@extends('admin.layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/portfolio/index.css') }}">

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
@endpush

@section('content')
    <div class="content">



        <div class="d-flex justify-content-between mb-4">

            <div>
                <h1>Portfolio</h1>
                <p>Daftar kerja sama dan kegiatan perusahaan</p>
            </div>


            <a href="{{ route('admin.portfolios.create') }}" class="btn btn-primary">
                Tambah Portfolio
            </a>

        </div>

        <form id="portfolioFilter" method="GET" action="{{ route('admin.portfolios.index') }}" class="mb-4">

            <div class="row g-2">

                <div class="col-md-6">

                    <input type="text" id="searchPortfolio" name="search" class="form-control"
                        placeholder="Cari judul, kategori, mitra, author..." value="{{ request('search') }}">

                </div>


                <div class="col-md-3">

                    <select id="sortPortfolio" name="sort" class="form-control">

                        <option value="">
                            Terbaru
                        </option>

                        <option value="oldest">
                            Terlama
                        </option>

                        <option value="title_asc">
                            Judul A-Z
                        </option>

                        <option value="title_desc">
                            Judul Z-A
                        </option>

                    </select>

                </div>


                <div class="col-md-3">

                    <a href="{{ route('admin.portfolios.index') }}" class="btn btn-secondary">
                        Reset
                    </a>

                </div>

            </div>

        </form>


        <div class="card">


            <table class="table">

                <thead>

                    <tr>

                        <th>No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Mitra</th>
                        <th>Media</th>
                        <th>Author</th>
                        <th>Deskripsi</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>

                    </tr>

                </thead>


                <tbody id="portfolioTable">

                    @if ($portfolios->count())
                        @foreach ($portfolios as $portfolio)
                            <tr data-title="{{ strtolower($portfolio->title) }}"
                                data-category="{{ strtolower($portfolio->category->name ?? '') }}"
                                data-partner="{{ strtolower($portfolio->partner->name ?? '') }}"
                                data-author="{{ strtolower($portfolio->author->name ?? '') }}">

                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    {{ $portfolio->title }}
                                </td>


                                <td>
                                    {{ $portfolio->category->name ?? '-' }}
                                </td>


                                <td>
                                    {{ $portfolio->partner->name ?? '-' }}
                                </td>

                                <td>

                                    @if ($portfolio->media->count())
                                        <span class="badge bg-success">
                                            {{ $portfolio->media->count() }} Media
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Tidak Ada
                                        </span>
                                    @endif

                                </td>

                                <td>
                                    {{ $portfolio->author->name ?? '-' }}
                                </td>

                                <td>
                                    {!! Str::limit(strip_tags($portfolio->description), 80) !!}
                                </td>


                                <td>
                                    {{ date('d M Y', strtotime($portfolio->activity_date)) }}
                                </td>


                                <td>


                                    <button class="btn btn-info btn-sm btn-detail" data-bs-toggle="modal"
                                        data-bs-target="#detailPortfolioModal" data-title="{{ $portfolio->title }}"
                                        data-category="{{ $portfolio->category->name ?? '-' }}"
                                        data-partner="{{ $portfolio->partner->name ?? '-' }}"
                                        data-date="{{ date('d M Y', strtotime($portfolio->activity_date)) }}"
                                        data-location="{{ $portfolio->location ?? '-' }}"
                                        data-lat="{{ $portfolio->latitude }}" data-lng="{{ $portfolio->longitude }}"
                                        data-participants="{{ $portfolio->participants ?? 0 }}"
                                        data-author="{{ $portfolio->author->name ?? '-' }}"
                                        data-description='@json($portfolio->description)'
                                        data-media='@json($portfolio->media)'>

                                        <i class="fa fa-eye"></i>

                                    </button>



                                    <a href="{{ route('admin.portfolios.edit', $portfolio->id) }}"
                                        class="btn btn-warning btn-sm">

                                        <i class="fa fa-edit"></i>

                                    </a>



                                    <form action="{{ route('admin.portfolios.destroy', $portfolio->id) }}" method="POST"
                                        class="d-inline delete-form">

                                        @csrf
                                        @method('DELETE')


                                        <button class="btn btn-danger btn-sm">

                                            <i class="fa fa-trash"></i>

                                        </button>


                                    </form>


                                </td>


                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9" class="text-center py-4">

                                Data portfolio tidak ditemukan

                            </td>
                        </tr>
                    @endif


                </tbody>


            </table>


        </div>


    </div>



    <!-- Detail Portfolio Modal -->

    <div class="modal fade" id="detailPortfolioModal" tabindex="-1">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">


                <div class="modal-header">

                    <h5 class="modal-title">
                        Detail Portfolio
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>



                <div class="modal-body">


                    <div class="mb-3">

                        <label class="fw-bold">
                            Judul
                        </label>

                        <p id="detailTitle"></p>

                    </div>



                    <div class="row">


                        <div class="col-md-6">

                            <label class="fw-bold">
                                Kategori
                            </label>

                            <p id="detailCategory"></p>

                        </div>



                        <div class="col-md-6">

                            <label class="fw-bold">
                                Mitra
                            </label>

                            <p id="detailPartner"></p>

                        </div>


                    </div>




                    <div class="row">


                        <div class="col-md-6">

                            <label class="fw-bold">
                                Tanggal Kegiatan
                            </label>

                            <p id="detailDate"></p>

                        </div>



                        <div class="col-md-6">

                            <label class="fw-bold">
                                Lokasi
                            </label>

                            <p id="detailLocation"></p>

                        </div>


                    </div>


                    <div class="mb-3">

                        <div id="detail-map" style="height:350px" class="rounded border">
                        </div>


                        <a id="googleMapsButton" target="_blank" class="btn btn-primary w-100 mt-3">

                            Buka di Google Maps

                        </a>

                        <div class="mb-3">

                            <label class="fw-bold">
                                Jumlah Peserta
                            </label>

                            <p id="detailParticipants"></p>

                        </div>

                        <div class="col-md-6">

                            <label class="fw-bold">
                                Author
                            </label>

                            <p id="detailAuthor"></p>

                        </div>


                        <div class="mb-3">

                            <label class="fw-bold">
                                Media
                            </label>


                            <div id="detailMedia" class="row g-3">

                            </div>

                        </div>




                        <div class="mb-3">

                            <label class="fw-bold">
                                Deskripsi
                            </label>

                            <div id="detailDescription" class="border rounded p-3 bg-light">

                            </div>

                        </div>


                    </div>


                    <div class="modal-footer">

                        <button class="btn btn-secondary" data-bs-dismiss="modal">

                            Tutup

                        </button>

                    </div>
                </div>


            </div>

        </div>

    </div>
@endsection



@push('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script src="{{ asset('js/admin/portfolio.js') }}"></script>
@endpush
