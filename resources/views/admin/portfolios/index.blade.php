@extends('admin.layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/portfolio/index.css') }}">
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



        <div class="card">


            <table class="table">

                <thead>

                    <tr>

                        <th>No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Mitra</th>
                        <th>Deskripsi</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>

                    </tr>

                </thead>


                <tbody>


                    @foreach ($portfolios as $portfolio)
                        <tr>

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
                                    data-participants="{{ $portfolio->participants ?? 0 }}"
                                    data-description='@json($portfolio->description)'>

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

                        <label class="fw-bold">
                            Jumlah Peserta
                        </label>

                        <p id="detailParticipants"></p>

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
@endsection



@push('scripts')
    <script src="{{ asset('js/admin/portfolio.js') }}"></script>
@endpush
