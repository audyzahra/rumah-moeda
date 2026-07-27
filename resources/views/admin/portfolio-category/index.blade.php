@extends('admin.layouts.app')

@section('content')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/portfolio_category.css') }}">
@endpush


<div class="content">

    <header class="topbar">

        <div>
            <h1>Kategori Portofolio</h1>
            <p>Kelola kategori portofolio</p>
        </div>


        <a href="{{ route('admin.portfolio-categories.create') }}" class="btn-add">
            <i class="fa-solid fa-plus"></i>
            Tambah Kategori
        </a>

    </header>



    <div class="portfolio-category-table">


        <table>

            <thead>

                <tr>
                    <th>Aksi</th>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th>Dibuat</th>
                </tr>

            </thead>


            <tbody>


            @forelse($categories as $category)

                <tr>


                    <td>

                        <div class="portfolio-category-action">


                            {{-- Detail --}}

                            <button
                                class="btn-action detail"
                                data-bs-toggle="modal"
                                data-bs-target="#detailModal{{ $category->id }}">

                                <i class="fa-solid fa-eye"></i>

                            </button>



                            {{-- Edit --}}

                            <a href="{{ route('admin.portfolio-categories.edit', $category->id) }}"
                               class="btn-action edit">

                                <i class="fa-solid fa-pen"></i>

                            </a>



                            {{-- Delete --}}

                            <form action="{{ route('admin.portfolio-categories.destroy', $category->id) }}"
      method="POST"
      class="delete-form">

    @csrf
    @method('DELETE')

    <button type="submit" class="btn-delete">
        <i class="fa-solid fa-trash"></i>
    </button>

</form>

                        </div>


                    </td>



                    <td>
                        {{ $loop->iteration }}
                    </td>



                    <td>
                        {{ $category->name }}
                    </td>



                    <td>
                        {{ $category->slug }}
                    </td>



                    <td>
                        {{ $category->created_at->format('d M Y') }}
                    </td>



                </tr>





                {{-- MODAL DETAIL --}}

                <div class="modal fade"
                     id="detailModal{{ $category->id }}"
                     tabindex="-1">


                    <div class="modal-dialog modal-dialog-centered">


                        <div class="modal-content">


                            <div class="modal-header">


                                <h5 class="modal-title">
                                    Detail Kategori Portofolio
                                </h5>


                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal">
                                </button>


                            </div>



                            <div class="modal-body">


                                <div class="detail-item">

                                    <label>
                                        Nama Kategori
                                    </label>

                                    <p>
                                        {{ $category->name }}
                                    </p>

                                </div>



                                <div class="detail-item">

                                    <label>
                                        Slug
                                    </label>

                                    <p>
                                        {{ $category->slug }}
                                    </p>

                                </div>



                                <div class="detail-item">

                                    <label>
                                        Dibuat
                                    </label>

                                    <p>
                                        {{ $category->created_at->format('d M Y H:i') }}
                                    </p>

                                </div>



                                <div class="detail-item">

                                    <label>
                                        Update Terakhir
                                    </label>

                                    <p>
                                        {{ $category->updated_at->format('d M Y H:i') }}
                                    </p>

                                </div>


                            </div>


                            <div class="modal-footer">


                                <button
                                    class="btn-close-modal"
                                    data-bs-dismiss="modal">

                                    Tutup

                                </button>


                            </div>


                        </div>


                    </div>


                </div>


            @empty


                <tr>

                    <td colspan="5" class="empty-data">

                        Belum ada kategori portofolio

                    </td>

                </tr>


            @endforelse



            </tbody>


        </table>


    </div>


</div>


@endsection

@push('scripts')
<script src="{{ asset('js/admin/portfolio_category.js') }}"></script>
<link rel="stylesheet" href="{{ asset('css/admin/portfolio-category/index.css') }}">
@endpush
