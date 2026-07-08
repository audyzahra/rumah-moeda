@extends('admin.layouts.app')

@section('title','Mitra')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/mitra.css') }}">
@endpush

@section('content')

<div class="wrapper">
    <!-- ================= CONTENT ================= -->
    <main class="content">

        <!-- HEADER -->
        <header class="topbar">
            <div>
                <h1>Manajemen Mitra</h1>
                <p>Kelola data mitra dan kerjasama</p>
            </div>
        </header>

        <!-- ===== FILTER & SEARCH ===== -->
        <section class="filter-section">
            <form method="GET" action="{{ route('admin.mitra.index') }}" class="filter-form">

                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}" 
                    placeholder="Cari mitra..." 
                    class="search-input">
                
                <select name="website" class="filter-select">
                    <option value="">Semua</option>
                    <option value="ada" {{ request('website') == 'ada' ? 'selected' : '' }}>Ada Website</option>
                    <option value="tidak" {{ request('website') == 'tidak' ? 'selected' : '' }}>Tanpa Website</option>
                </select>

                <select name="sort" class="filter-select">
                    <option value="display_order" {{ request('sort') == 'display_order' ? 'selected' : '' }}>
                        Urutan Tampil
                    </option>
                    <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>
                        Nama A-Z
                    </option>
                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>
                        Terbaru
                    </option>
                </select>

                <button type="submit" class="btn-refresh">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
                
            </form>

            <div class="filter-right">
                <button class="btn-tambah" data-bs-toggle="modal" data-bs-target="#formModal" type="button">
                    <i class="fa-solid fa-plus"></i> 
                    Tambah Mitra
                </button>
            </div>
        </section>

        <!-- ===== GRID MITRA ===== -->
        <section class="mitra-grid-section">
            <div class="mitra-grid" id="mitraGrid">
                @if(isset($mitra) && $mitra->count() > 0)
                    @foreach($mitra as $item)
                        <div class="mitra-card">
                            <span class="badge-order">
                                #{{ $item->display_order ?? 0 }}
                            </span>

                            <div class="foto-mitra">
                                @if($item->logo)
                                    <img 
                                        src="{{ asset('storage/' . $item->logo) }}" 
                                        alt="{{ $item->name }}"
                                        class="foto">
                                @else
                                    <div class="foto-placeholder">
                                        <i class="fa-solid fa-building"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="card-body">
                                <div class="card-name">
                                    {{ $item->name }}
                                </div>

                                <div class="card-website">
                                    @if($item->website)
                                        <a href="{{ $item->website }}" target="_blank">
                                            <i class="fa-solid fa-globe"></i> 
                                            {{ Str::limit(str_replace(['https://', 'http://'], '', $item->website), 30) }}
                                        </a>
                                    @else
                                        <span class="no-website">Tidak ada website</span>
                                    @endif
                                </div>

                                <div class="card-description">
                                    {{ $item->description 
                                        ? Str::limit($item->description, 100)
                                        : 'Belum ada deskripsi'
                                    }}
                                </div>

                                <div class="card-actions">
                                    <button type="button"
                                        class="btn-detail"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailModal"
                                        data-id="{{ $item->id }}"
                                        data-name="{{ $item->name }}"
                                        data-website="{{ $item->website }}"
                                        data-description="{{ $item->description }}"
                                        data-order="{{ $item->display_order }}"
                                        data-logo="{{ $item->logo }}">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </button>

                                    <button type="button"
                                        class="btn-edit"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal"
                                        data-id="{{ $item->id }}"
                                        data-name="{{ $item->name }}"
                                        data-website="{{ $item->website }}"
                                        data-description="{{ $item->description }}"
                                        data-order="{{ $item->display_order }}"
                                        data-logo="{{ $item->logo }}">
                                        <i class="fa-solid fa-pen"></i> Edit    
                                    </button>

                                    <button type="button"
                                        class="btn-delete"
                                        data-id="{{ $item->id }}"
                                        data-name="{{ $item->name }}"
                                        onclick="confirmDelete(this)">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="fa-solid fa-users-slash"></i>
                        <h3>Tidak ada data mitra</h3>
                        <p>Belum ada mitra yang ditambahkan.</p>
                    </div>
                @endif
            </div>

            <!-- ===== PAGINATION ===== -->
            @if(isset($mitra) && $mitra->count() > 0)
                <div class="pagination-section">
                    <div class="info-data">
                        Menampilkan
                        {{ $mitra->firstItem() ?? 0 }}
                        -
                        {{ $mitra->lastItem() ?? 0 }}
                        dari
                        {{ $mitra->total() }}
                        mitra
                    </div>
                    <div class="pagination-controls">
                        {{ $mitra->withQueryString()->links() }}
                    </div>
                </div>
            @endif
        </section>

    </main>
</div>

<!-- ===== MODAL TAMBAH ===== -->
<div class="modal fade" id="formModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.mitra.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Mitra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Mitra <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Website</label>
                            <input type="url" name="website" class="form-control" placeholder="https://example.com" value="{{ old('website') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Urutan Tampil</label>
                            <input type="number" name="display_order" min="1" class="form-control" value="{{ old('display_order') }}">
                            <small class="text-muted">Semakin kecil angka, semakin atas tampilnya</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Upload Logo</label>
                            <input type="file" name="logo" accept="image/*" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===== MODAL EDIT ===== -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Edit Mitra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Mitra <span class="text-danger">*</span></label>
                            <input type="text" id="editName" name="name" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Website</label>
                            <input type="url" id="editWebsite" name="website" class="form-control" placeholder="https://example.com">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Urutan Tampil</label>
                            <input type="number" id="editOrder" name="display_order" min="1" class="form-control">
                            <small class="text-muted">Semakin kecil angka, semakin atas tampilnya</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Upload Logo</label>
                            <input type="file" name="logo" accept="image/*" class="form-control">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah logo</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea id="editDescription" name="description" rows="4" class="form-control"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===== MODAL DETAIL ===== -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Mitra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailBody">
                <!-- Isi detail akan diisi oleh JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODAL HAPUS ===== -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus mitra <strong id="deleteName"></strong>?</p>
                <p class="text-muted small">Data akan dihapus secara permanen.</p>
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fa-solid fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ===== NOTIFIKASI ===== -->
<div id="notification" class="notification"></div>
@if(session('success'))
        showNotification('{{ session('success') }}', 'success');
    @endif

    @if(session('error'))
        showNotification('{{ session('error') }}', 'error');
    @endif
@endsection

@push('scripts')
<script src="{{ asset('js/admin/mitra.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // ==========================================
        // 1. EDIT MODAL
        // ==========================================
        const editModal = document.getElementById('editModal');
        if (editModal) {
            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const website = button.getAttribute('data-website');
                const description = button.getAttribute('data-description');
                const order = button.getAttribute('data-order');

                const form = document.getElementById('editForm');
                form.action = '{{ route("admin.mitra.update", ":id") }}'.replace(':id', id);

                document.getElementById('editName').value = name || '';
                document.getElementById('editWebsite').value = website || '';
                document.getElementById('editDescription').value = description || '';
                document.getElementById('editOrder').value = order || '';
            });
        }

        // ==========================================
        // 2. DETAIL MODAL
        // ==========================================
        const detailModal = document.getElementById('detailModal');
        if (detailModal) {
            detailModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const name = button.getAttribute('data-name');
                const website = button.getAttribute('data-website');
                const description = button.getAttribute('data-description');
                const order = button.getAttribute('data-order');
                const logo = button.getAttribute('data-logo');

                const body = document.getElementById('detailBody');
                const logoUrl = logo ? "{{ asset('storage/') }}/" + logo : null;
                
                body.innerHTML = `
                    <div class="text-center mb-3">
                        ${logoUrl ? 
                            `<img src="${logoUrl}" alt="${name}" class="detail-logo" style="max-width: 200px; max-height: 150px; object-fit: contain;">` : 
                            `<div class="detail-logo-placeholder" style="width: 150px; height: 100px; background: #e5e7eb; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fa-solid fa-building" style="font-size: 40px; color: #94a3b8;"></i>
                            </div>`
                        }
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Nama Mitra</span>
                        <span class="detail-value">${name || '-'}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Deskripsi</span>
                        <span class="detail-value">${description || 'Tidak ada deskripsi'}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Website</span>
                        <span class="detail-value">
                            ${website ? 
                                `<a href="${website}" target="_blank" class="website-link">${website}</a>` : 
                                'Tidak ada website'
                            }
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Urutan Tampil</span>
                        <span class="detail-value">${order || 0}</span>
                    </div>
                `;
            });
        }
    });

    // ==========================================
    // 3. CONFIRM DELETE
    // ==========================================
    function confirmDelete(element) {
        const id = element.getAttribute('data-id');
        const name = element.getAttribute('data-name');
        
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        document.getElementById('deleteName').textContent = name;
        
        const form = document.getElementById('deleteForm');
        form.action = '{{ route("admin.mitra.destroy", ":id") }}'.replace(':id', id);
        
        deleteModal.show();
    }

    // ==========================================
    // 4. NOTIFICATION FUNCTION
    // ==========================================
    function showNotification(message, type = 'info') {
        const notification = document.getElementById('notification');
        if (!notification) return;

        notification.textContent = message;
        notification.className = `notification ${type} show`;
        
        setTimeout(() => {
            notification.classList.remove('show');
        }, 3000);
    }

    // ==========================================
    // 5. NOTIFICATION DARI SESSION
    // ==========================================
    
</script>
@endpush