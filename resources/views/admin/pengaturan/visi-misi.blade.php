@extends('admin.layouts.app')

@section('title', 'Visi & Misi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/visi-misi.css') }}">
@endpush

@section('content')

<section class="visi-misi-section">

    <div class="settings-card">

        <div class="card-header">

            <h3>
                <i class="fa-solid fa-bullseye"></i>
                Visi & Misi
            </h3>

            <p>
                Kelola visi dan misi perusahaan
            </p>

        </div>

        <div class="card-body">

            <form id="visiMisiForm" action="{{ route('admin.visimisi.update') }}" method="POST">

                @csrf

                <!-- VISI -->
                <div class="form-group">

                    <label>
                        Visi
                        <span class="required">*</span>
                    </label>

                    <textarea
                        id="visiText"
                        name="vision"
                        class="form-control"
                        rows="4"
                        placeholder="Masukkan visi perusahaan..."
                        required>{{ old('vision', $vision->vision ?? '') }}</textarea>

                    <small class="form-help">
                        Tuliskan visi perusahaan secara jelas dan inspiratif.
                    </small>

                </div>

                <hr>

                <!-- MISI -->
                <div class="form-group">

                    <div class="misi-header">

                        <div>

                            <label>
                                Misi
                                <span class="required">*</span>
                            </label>

                            <small class="form-help">
                                Tambahkan satu atau lebih misi perusahaan.
                            </small>

                        </div>

                        <button
                            type="button"
                            class="btn-add-misi"
                            onclick="addMisi()">

                            <i class="fa-solid fa-plus"></i>
                            Tambah Misi

                        </button>

                    </div>

                    <div id="misiContainer">

                        @forelse($missions as $mission)

                            <div class="misi-item">

                                <textarea
                                    class="form-control misi-text"
                                    name="missions[]"
                                    rows="3"
                                    placeholder="Masukkan misi perusahaan..."
                                    required>{{ old('missions.' . $loop->index, $mission->mission) }}</textarea>

                                <button
                                    type="button"
                                    class="btn-remove-misi"
                                    onclick="removeMisi(this)">

                                    <i class="fa-solid fa-trash"></i>

                                </button>

                            </div>

                        @empty

                            <div class="misi-item">

                                <textarea
                                    class="form-control misi-text"
                                    name="missions[]"
                                    rows="3"
                                    placeholder="Masukkan misi perusahaan..."
                                    required></textarea>

                                <button
                                    type="button"
                                    class="btn-remove-misi"
                                    onclick="removeMisi(this)">

                                    <i class="fa-solid fa-trash"></i>

                                </button>

                            </div>

                        @endforelse

                    </div>

                </div>

                <div class="form-actions">

                    <button type="submit" class="btn-simpan">

                        <i class="fa-solid fa-save"></i>

                        Simpan Visi & Misi

                    </button>

                </div>

            </form>

        </div>

    </div>

</section>

@endsection

@push('scripts')
    <script src="{{ asset('js/admin/visi-misi.js') }}"></script>
@endpush