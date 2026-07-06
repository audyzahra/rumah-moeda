// ==============================
// BERITA.JS
// Manajemen Berita dengan API
// ==============================

// ===== KONFIGURASI =====
const API_URL = 'http://localhost:8000/api';
const API_TOKEN = localStorage.getItem('api_token') || '';

// ===== VARIABEL GLOBAL =====
let beritaData = [];
let filteredData = [];
let currentPage = 1;
const itemsPerPage = 6;
let deleteId = null;
let editId = null;
let categories = [];

// ===== DOM ELEMENTS =====
const grid = document.getElementById('beritaGrid');
const searchInput = document.getElementById('searchInput');
const filterCategory = document.getElementById('filterCategory');
const filterStatus = document.getElementById('filterStatus');
const filterSort = document.getElementById('filterSort');

// ===== INISIALISASI =====
document.addEventListener('DOMContentLoaded', () => {
    loadCategories();
    loadBerita();

    searchInput.addEventListener('input', filterData);
    filterCategory.addEventListener('change', filterData);
    filterStatus.addEventListener('change', filterData);
    filterSort.addEventListener('change', filterData);
});

// ============================================
// LOAD DATA
// ============================================

// Load Kategori
function loadCategories() {
    // Ambil dari API (aktifkan jika sudah ada backend)
    /*
    fetch(`${API_URL}/categories`, {
        headers: { 'Authorization': `Bearer ${API_TOKEN}` }
    })
    .then(response => response.json())
    .then(data => {
        categories = data.data;
        populateCategoryDropdowns();
    })
    .catch(error => console.error('Error loading categories:', error));
    */

    // DATA DUMMY KATEGORI
    categories = [
        { id: 1, name: 'Politik' },
        { id: 2, name: 'Ekonomi' },
        { id: 3, name: 'Sosial' },
        { id: 4, name: 'Kesehatan' },
        { id: 5, name: 'Pendidikan' },
        { id: 6, name: 'Teknologi' },
        { id: 7, name: 'Lingkungan' },
        { id: 8, name: 'Budaya' }
    ];
    populateCategoryDropdowns();
}

function populateCategoryDropdowns() {
    const selects = [filterCategory, document.getElementById('formKategori')];
    selects.forEach(select => {
        if (!select) return;
        select.innerHTML = '<option value="">Pilih Kategori</option>';
        categories.forEach(cat => {
            select.innerHTML += `<option value="${cat.id}">${cat.name}</option>`;
        });
    });
    
    document.getElementById('totalCategories').textContent = categories.length;
}

// Load Berita
function loadBerita() {
    // Ambil dari API (aktifkan jika sudah ada backend)
    /*
    fetch(`${API_URL}/news`, {
        headers: { 'Authorization': `Bearer ${API_TOKEN}` }
    })
    .then(response => response.json())
    .then(data => {
        beritaData = data.data;
        filteredData = [...beritaData];
        updateStats();
        renderGrid();
        updatePaginationInfo();
        updateBadge();
    })
    .catch(error => {
        showNotification('Gagal memuat data berita', 'error');
        console.error(error);
    });
    */

    // DATA DUMMY
    beritaData = [
        {
            id: 1,
            title: 'Program Pembangunan Infrastruktur 2026',
            thumbnail: 'https://via.placeholder.com/400x200/3b82f6/ffffff?text=Infrastruktur',
            content: 'Pemerintah mengumumkan program pembangunan infrastruktur skala besar untuk tahun 2026. Program ini mencakup pembangunan jalan tol, jembatan, dan pelabuhan di berbagai wilayah. Total anggaran mencapai Rp 500 triliun.',
            category_id: 2,
            category_name: 'Ekonomi',
            slug: 'program-pembangunan-infrastruktur-2026',
            publish_date: '2026-07-05T10:00:00',
            author_name: 'Admin',
            status: 'published',
            created_at: '2026-07-05T10:00:00'
        },
        {
            id: 2,
            title: 'Vaksinasi Massal di 10 Kota Besar',
            thumbnail: 'https://via.placeholder.com/400x200/10b981/ffffff?text=Vaksinasi',
            content: 'Program vaksinasi massal akan digelar di 10 kota besar mulai bulan depan. Target vaksinasi mencapai 5 juta orang dalam satu bulan. Masyarakat diimbau untuk mendaftar melalui aplikasi resmi.',
            category_id: 4,
            category_name: 'Kesehatan',
            slug: 'vaksinasi-massal-di-10-kota-besar',
            publish_date: '2026-07-04T08:30:00',
            author_name: 'Admin',
            status: 'published',
            created_at: '2026-07-04T08:30:00'
        },
        {
            id: 3,
            title: 'Beasiswa Pendidikan untuk 1000 Mahasiswa',
            thumbnail: 'https://via.placeholder.com/400x200/8b5cf6/ffffff?text=Pendidikan',
            content: 'Pemerintah menyediakan beasiswa pendidikan untuk 1000 mahasiswa berprestasi dari keluarga kurang mampu. Pendaftaran dibuka mulai 15 Juli 2026. Program ini mencakup biaya kuliah dan uang saku.',
            category_id: 5,
            category_name: 'Pendidikan',
            slug: 'beasiswa-pendidikan-untuk-1000-mahasiswa',
            publish_date: '2026-07-03T14:15:00',
            author_name: 'Admin',
            status: 'published',
            created_at: '2026-07-03T14:15:00'
        },
        {
            id: 4,
            title: 'Draft: Rencana Program Sosial Baru',
            thumbnail: 'https://via.placeholder.com/400x200/f59e0b/ffffff?text=Draft',
            content: 'Ini adalah draft rencana program sosial yang akan diluncurkan tahun depan. Program ini bertujuan untuk meningkatkan kesejahteraan masyarakat di daerah terpencil.',
            category_id: 3,
            category_name: 'Sosial',
            slug: 'rencana-program-sosial-baru',
            publish_date: '2026-07-02T09:00:00',
            author_name: 'Admin',
            status: 'draft',
            created_at: '2026-07-02T09:00:00'
        },
        {
            id: 5,
            title: 'Inovasi Teknologi Hijau di Indonesia',
            thumbnail: 'https://via.placeholder.com/400x200/ef4444/ffffff?text=Teknologi',
            content: 'Indonesia meluncurkan inovasi teknologi hijau untuk mengatasi masalah lingkungan. Teknologi ini menggunakan energi terbarukan dan ramah lingkungan.',
            category_id: 6,
            category_name: 'Teknologi',
            slug: 'inovasi-teknologi-hijau-di-indonesia',
            publish_date: '2026-07-01T11:45:00',
            author_name: 'Admin',
            status: 'published',
            created_at: '2026-07-01T11:45:00'
        },
        {
            id: 6,
            title: 'Festival Budaya Nusantara 2026',
            thumbnail: 'https://via.placeholder.com/400x200/ec4899/ffffff?text=Budaya',
            content: 'Festival Budaya Nusantara 2026 akan diselenggarakan di Jakarta pada bulan Agustus. Acara ini akan menampilkan berbagai pertunjukan seni dan kuliner tradisional.',
            category_id: 8,
            category_name: 'Budaya',
            slug: 'festival-budaya-nusantara-2026',
            publish_date: '2026-06-30T16:20:00',
            author_name: 'Admin',
            status: 'published',
            created_at: '2026-06-30T16:20:00'
        },
        {
            id: 7,
            title: 'Draft: Program Pengembangan UMKM',
            thumbnail: 'https://via.placeholder.com/400x200/f59e0b/ffffff?text=UMKM',
            content: 'Draft program pengembangan UMKM untuk meningkatkan daya saing produk lokal di pasar global.',
            category_id: 2,
            category_name: 'Ekonomi',
            slug: 'program-pengembangan-umkm',
            publish_date: '2026-06-29T13:00:00',
            author_name: 'Admin',
            status: 'draft',
            created_at: '2026-06-29T13:00:00'
        },
        {
            id: 8,
            title: 'Penghijauan di 100 Kota',
            thumbnail: 'https://via.placeholder.com/400x200/10b981/ffffff?text=Lingkungan',
            content: 'Program penghijauan akan dilakukan di 100 kota di seluruh Indonesia. Target penanaman 1 juta pohon dalam setahun.',
            category_id: 7,
            category_name: 'Lingkungan',
            slug: 'penghijauan-di-100-kota',
            publish_date: '2026-06-28T09:30:00',
            author_name: 'Admin',
            status: 'published',
            created_at: '2026-06-28T09:30:00'
        }
    ];
    
    filteredData = [...beritaData];
    updateStats();
    renderGrid();
    updatePaginationInfo();
    updateBadge();
}

// ============================================
// RENDER FUNCTIONS
// ============================================

// Render Grid
function renderGrid() {
    const start = (currentPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const pageData = filteredData.slice(start, end);

    if (pageData.length === 0) {
        grid.innerHTML = `
            <div class="empty-state">
                <i class="fa-solid fa-newspaper"></i>
                <h3>Tidak Ada Berita</h3>
                <p>Belum ada berita yang ditambahkan. Klik tombol "Tambah Berita" untuk membuat berita baru.</p>
            </div>
        `;
        return;
    }

    grid.innerHTML = pageData.map(item => `
        <div class="berita-card" data-id="${item.id}">
            <img src="${item.thumbnail}" alt="${item.title}" class="thumbnail" 
                 onerror="this.src='https://via.placeholder.com/400x200/cccccc/ffffff?text=No+Image'">
            <div class="card-body">
                <div class="card-title">${escapeHtml(item.title)}</div>
                <div class="card-meta">
                    <span><i class="fa-solid fa-tag"></i> ${escapeHtml(item.category_name)}</span>
                    <span><i class="fa-solid fa-calendar"></i> ${formatDate(item.publish_date)}</span>
                    <span><i class="fa-solid fa-user"></i> ${escapeHtml(item.author_name)}</span>
                </div>
                <div class="card-excerpt">${escapeHtml(item.content.substring(0, 120))}${item.content.length > 120 ? '...' : ''}</div>
                <div class="card-actions">
                    <button class="btn-detail" onclick="showDetail(${item.id})">
                        <i class="fa-solid fa-eye"></i> Detail
                    </button>
                    <button class="btn-edit" onclick="openEditModal(${item.id})">
                        <i class="fa-solid fa-pen"></i> Edit
                    </button>
                    <button class="btn-delete" onclick="showDeleteModal(${item.id})">
                        <i class="fa-solid fa-trash"></i> Hapus
                    </button>
                    <button class="btn-status-badge ${item.status}" onclick="toggleStatus(${item.id})">
                        ${item.status === 'published' ? 'Dipublikasikan' : 'Draft'}
                    </button>
                </div>
            </div>
        </div>
    `).join('');
}

// Update Stats
function updateStats() {
    const total = beritaData.length;
    const published = beritaData.filter(d => d.status === 'published').length;
    const draft = beritaData.filter(d => d.status === 'draft').length;

    document.getElementById('totalBerita').textContent = total;
    document.getElementById('totalPublished').textContent = published;
    document.getElementById('totalDraft').textContent = draft;
}

// Update Pagination
function updatePaginationInfo() {
    const total = filteredData.length;
    const totalPages = Math.ceil(total / itemsPerPage);
    const start = total === 0 ? 0 : (currentPage - 1) * itemsPerPage + 1;
    const end = Math.min(currentPage * itemsPerPage, total);

    document.getElementById('startData').textContent = start;
    document.getElementById('endData').textContent = end;
    document.getElementById('totalData').textContent = total;
    document.getElementById('pageInfo').textContent = `Halaman ${currentPage} dari ${totalPages || 1}`;

    document.getElementById('prevBtn').disabled = currentPage === 1;
    document.getElementById('nextBtn').disabled = currentPage === totalPages || totalPages === 0;
}

// Update Badge di Sidebar
function updateBadge() {
    const badge = document.getElementById('totalBeritaBadge');
    if (badge) {
        badge.textContent = beritaData.length;
    }
}

// ============================================
// FILTER & SEARCH
// ============================================

function filterData() {
    const keyword = searchInput.value.toLowerCase().trim();
    const category = filterCategory.value;
    const status = filterStatus.value;
    const sort = filterSort.value;

    filteredData = beritaData.filter(item => {
        const matchKeyword = item.title.toLowerCase().includes(keyword) ||
                            item.content.toLowerCase().includes(keyword) ||
                            item.category_name.toLowerCase().includes(keyword);
        const matchCategory = category === 'semua' || item.category_id == category;
        const matchStatus = status === 'semua' || item.status === status;
        return matchKeyword && matchCategory && matchStatus;
    });

    // Sorting
    if (sort === 'terbaru') {
        filteredData.sort((a, b) => new Date(b.publish_date) - new Date(a.publish_date));
    } else if (sort === 'terlama') {
        filteredData.sort((a, b) => new Date(a.publish_date) - new Date(b.publish_date));
    } else if (sort === 'judul') {
        filteredData.sort((a, b) => a.title.localeCompare(b.title));
    }

    currentPage = 1;
    renderGrid();
    updatePaginationInfo();
}

// ============================================
// PAGINATION
// ============================================

function prevPage() {
    if (currentPage > 1) {
        currentPage--;
        renderGrid();
        updatePaginationInfo();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

function nextPage() {
    const totalPages = Math.ceil(filteredData.length / itemsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        renderGrid();
        updatePaginationInfo();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

// ============================================
// CRUD OPERATIONS
// ============================================

// Tambah Berita
function openTambahModal() {
    editId = null;
    document.getElementById('formModalTitle').textContent = 'Tambah Berita Baru';
    document.getElementById('beritaForm').reset();
    document.getElementById('editId').value = '';
    document.getElementById('thumbnailPreview').innerHTML = `
        <i class="fa-solid fa-image"></i>
        <p>Klik untuk upload gambar</p>
    `;
    document.getElementById('formModal').style.display = 'block';
}

// Edit Berita
function openEditModal(id) {
    const item = beritaData.find(d => d.id === id);
    if (!item) return;

    editId = id;
    document.getElementById('formModalTitle').textContent = 'Edit Berita';
    document.getElementById('editId').value = id;
    document.getElementById('formJudul').value = item.title;
    document.getElementById('formKategori').value = item.category_id;
    document.getElementById('formKonten').value = item.content;
    document.getElementById('formStatus').value = item.status;
    
    // Set tanggal
    const date = new Date(item.publish_date);
    const formattedDate = date.toISOString().slice(0, 16);
    document.getElementById('formPublishDate').value = formattedDate;
    
    // Preview thumbnail
    const preview = document.getElementById('thumbnailPreview');
    preview.innerHTML = `<img src="${item.thumbnail}" alt="Thumbnail">`;
    
    document.getElementById('formModal').style.display = 'block';
}

// Save Berita
function saveBerita(event) {
    event.preventDefault();
    
    const id = document.getElementById('editId').value;
    const judul = document.getElementById('formJudul').value.trim();
    const kategori = document.getElementById('formKategori').value;
    const konten = document.getElementById('formKonten').value.trim();
    const publishDate = document.getElementById('formPublishDate').value;
    const status = document.getElementById('formStatus').value;
    
    // Validasi
    if (!judul || !kategori || !konten || !publishDate) {
        showNotification('Semua field wajib diisi!', 'error');
        return;
    }
    
    // Cek thumbnail (untuk tambah baru wajib ada)
    const thumbnailPreview = document.getElementById('thumbnailPreview');
    const hasThumbnail = thumbnailPreview.querySelector('img') !== null;
    
    if (!id && !hasThumbnail) {
        showNotification('Thumbnail wajib diupload!', 'error');
        return;
    }
    
    // Buat data berita
    const category = categories.find(c => c.id == kategori);
    const berita = {
        title: judul,
        category_id: parseInt(kategori),
        category_name: category ? category.name : '',
        content: konten,
        publish_date: publishDate,
        status: status,
        author_name: 'Admin',
        slug: judul.toLowerCase().replace(/[^a-z0-9]+/g, '-')
    };
    
    // Jika edit, tambahkan thumbnail yang sudah ada
    if (id) {
        const existing = beritaData.find(d => d.id === id);
        if (existing) {
            berita.thumbnail = existing.thumbnail;
        }
    } else {
        // Untuk tambah baru, gunakan thumbnail placeholder
        berita.thumbnail = 'https://via.placeholder.com/400x200/3b82f6/ffffff?text=' + encodeURIComponent(judul.substring(0, 20));
    }
    
    // Simpan ke API (aktifkan jika sudah ada backend)
    /*
    const method = id ? 'PUT' : 'POST';
    const url = id ? `${API_URL}/news/${id}` : `${API_URL}/news`;
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${API_TOKEN}`
        },
        body: JSON.stringify(berita)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(id ? 'Berita berhasil diupdate!' : 'Berita berhasil ditambahkan!', 'success');
            closeFormModal();
            loadBerita();
        } else {
            showNotification(data.message || 'Gagal menyimpan data', 'error');
        }
    })
    .catch(error => {
        showNotification('Gagal menyimpan data', 'error');
        console.error(error);
    });
    */
    
    // SIMULASI SAVE (untuk testing tanpa backend)
    if (id) {
        // Edit
        const index = beritaData.findIndex(d => d.id === id);
        if (index !== -1) {
            beritaData[index] = { ...beritaData[index], ...berita };
            showNotification('Berita berhasil diupdate!', 'success');
        }
    } else {
        // Tambah baru
        const newId = Math.max(...beritaData.map(d => d.id)) + 1;
        berita.id = newId;
        berita.created_at = new Date().toISOString();
        beritaData.push(berita);
        showNotification('Berita berhasil ditambahkan!', 'success');
    }
    
    closeFormModal();
    filteredData = [...beritaData];
    updateStats();
    renderGrid();
    updatePaginationInfo();
    updateBadge();
}

// ============================================
// DETAIL
// ============================================

function showDetail(id) {
    const item = beritaData.find(d => d.id === id);
    if (!item) return;

    const body = document.getElementById('detailBody');
    body.innerHTML = `
        <img src="${item.thumbnail}" alt="${item.title}" class="detail-thumbnail"
             onerror="this.src='https://via.placeholder.com/400x200/cccccc/ffffff?text=No+Image'">
        <div class="detail-item">
            <span class="detail-label">Judul</span>
            <span class="detail-value"><strong>${escapeHtml(item.title)}</strong></span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Kategori</span>
            <span class="detail-value">${escapeHtml(item.category_name)}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Penulis</span>
            <span class="detail-value">${escapeHtml(item.author_name)}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Tanggal Publikasi</span>
            <span class="detail-value">${formatDate(item.publish_date)}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Status</span>
            <span class="detail-value">
                <span class="status-badge ${item.status}">
                    ${item.status === 'published' ? 'Dipublikasikan' : 'Draft'}
                </span>
            </span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Konten</span>
            <span class="detail-value">${escapeHtml(item.content)}</span>
        </div>
        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px;padding-top:15px;border-top:1px solid #e5e7eb;">
            <button class="btn-edit" onclick="openEditModal(${item.id});closeDetailModal();">
                <i class="fa-solid fa-pen"></i> Edit
            </button>
            <button class="btn-delete" onclick="showDeleteModal(${item.id});closeDetailModal();">
                <i class="fa-solid fa-trash"></i> Hapus
            </button>
        </div>
    `;

    document.getElementById('detailModal').style.display = 'block';
}

// ============================================
// DELETE
// ============================================

function showDeleteModal(id) {
    deleteId = id;
    const item = beritaData.find(d => d.id === id);
    if (item) {
        document.getElementById('deleteInfo').textContent = `Menghapus berita: "${item.title}"`;
    }
    document.getElementById('deleteModal').style.display = 'block';
}

function confirmDelete() {
    if (!deleteId) return;
    
    // Hapus dari API (aktifkan jika sudah ada backend)
    /*
    fetch(`${API_URL}/news/${deleteId}`, {
        method: 'DELETE',
        headers: {
            'Authorization': `Bearer ${API_TOKEN}`
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Berita berhasil dihapus!', 'success');
            closeDeleteModal();
            loadBerita();
        } else {
            showNotification(data.message || 'Gagal menghapus data', 'error');
        }
    })
    .catch(error => {
        showNotification('Gagal menghapus data', 'error');
        console.error(error);
    });
    */
    
    // SIMULASI HAPUS (untuk testing tanpa backend)
    const index = beritaData.findIndex(d => d.id === deleteId);
    if (index !== -1) {
        beritaData.splice(index, 1);
        showNotification('Berita berhasil dihapus!', 'success');
        closeDeleteModal();
        filteredData = [...beritaData];
        updateStats();
        renderGrid();
        updatePaginationInfo();
        updateBadge();
    }
}

// ============================================
// TOGGLE STATUS
// ============================================

function toggleStatus(id) {
    const item = beritaData.find(d => d.id === id);
    if (!item) return;
    
    const newStatus = item.status === 'published' ? 'draft' : 'published';
    const statusText = newStatus === 'published' ? 'Dipublikasikan' : 'Draft';
    
    // Update ke API (aktifkan jika sudah ada backend)
    /*
    fetch(`${API_URL}/news/${id}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${API_TOKEN}`
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(`Status berubah menjadi ${statusText}`, 'success');
            loadBerita();
        } else {
            showNotification(data.message || 'Gagal mengubah status', 'error');
        }
    })
    .catch(error => {
        showNotification('Gagal mengubah status', 'error');
        console.error(error);
    });
    */
    
    // SIMULASI (untuk testing tanpa backend)
    item.status = newStatus;
    showNotification(`Status berubah menjadi ${statusText}`, 'success');
    filteredData = [...beritaData];
    updateStats();
    renderGrid();
    updatePaginationInfo();
}

// ============================================
// THUMBNAIL PREVIEW
// ============================================

function previewThumbnail(event) {
    const file = event.target.files[0];
    if (!file) return;
    
    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('thumbnailPreview');
        preview.innerHTML = `<img src="${e.target.result}" alt="Thumbnail Preview">`;
    };
    reader.readAsDataURL(file);
}

// ============================================
// MODAL CONTROLS
// ============================================

function closeFormModal() {
    document.getElementById('formModal').style.display = 'none';
}

function closeDetailModal() {
    document.getElementById('detailModal').style.display = 'none';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
    deleteId = null;
}

// Tutup modal jika klik di luar
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
        if (event.target.id === 'deleteModal') {
            deleteId = null;
        }
    }
}

// ============================================
// NOTIFICATION
// ============================================

function showNotification(message, type = 'info') {
    const notification = document.getElementById('notification');
    notification.textContent = message;
    notification.className = `notification ${type} show`;
    
    setTimeout(() => {
        notification.classList.remove('show');
    }, 3000);
}

// ============================================
// UTILITY FUNCTIONS
// ============================================

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    const options = { 
        day: 'numeric', 
        month: 'long', 
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    return date.toLocaleDateString('id-ID', options);
}

function refreshData() {
    showNotification('Memuat ulang data...', 'info');
    loadBerita();
}

function logout() {
    if (confirm('Apakah Anda yakin ingin logout?')) {
        localStorage.removeItem('api_token');
        window.location.href = 'login.html';
    }
}

// ============================================
// KEYBOARD SHORTCUTS
// ============================================

document.addEventListener('keydown', function(e) {
    // Escape untuk menutup modal
    if (e.key === 'Escape') {
        closeFormModal();
        closeDetailModal();
        closeDeleteModal();
    }
    
    // Ctrl + N untuk tambah berita
    if (e.ctrlKey && e.key === 'n') {
        e.preventDefault();
        openTambahModal();
    }
    
    // Ctrl + R untuk refresh
    if (e.ctrlKey && e.key === 'r') {
        e.preventDefault();
        refreshData();
    }
});

console.log('📰 Manajemen Berita siap digunakan!');
console.log(`📊 Total berita: ${beritaData.length}`);
console.log('ℹ️ Gunakan Ctrl+N untuk tambah berita, Ctrl+R untuk refresh');