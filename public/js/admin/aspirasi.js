// ==============================
// ASPIRASI.JS
// Manajemen Aspirasi
// ==============================

// ===== DATA DUMMY (Simulasi Database) =====
let aspirasiData = [
    {
        id: 1,
        nama: 'Ahmad Fauzan',
        email: 'ahmad@gmail.com',
        subjek: 'Perbaikan Jalan',
        pesan: 'Jalan di depan rumah saya rusak parah, mohon segera diperbaiki. Sudah 3 bulan tidak ada perbaikan.',
        tanggal: '2026-07-05T10:30:00',
        status: 'baru'
    },
    {
        id: 2,
        nama: 'Siti Nurhaliza',
        email: 'siti@gmail.com',
        subjek: 'Kegiatan Sosial',
        pesan: 'Saya ingin mengusulkan kegiatan sosial untuk anak-anak di sekitar lingkungan.',
        tanggal: '2026-07-04T14:20:00',
        status: 'dibaca'
    },
    {
        id: 3,
        nama: 'Budi Santoso',
        email: 'budi@gmail.com',
        subjek: 'Program UMKM',
        pesan: 'Bagaimana cara mendaftar program bantuan UMKM? Saya memiliki usaha kecil-kecilan.',
        tanggal: '2026-07-03T09:15:00',
        status: 'approved'
    },
    {
        id: 4,
        nama: 'Dewi Anggraini',
        email: 'dewi@gmail.com',
        subjek: 'Sampah Berserakan',
        pesan: 'Sampah di pasar tradisional menumpuk dan bau menyengat. Mohon petugas kebersihan ditambah.',
        tanggal: '2026-07-02T16:45:00',
        status: 'baru'
    },
    {
        id: 5,
        nama: 'Rizky Ramadhan',
        email: 'rizky@gmail.com',
        subjek: 'Penerangan Jalan',
        pesan: 'Lampu jalan di gang belakang mati total, sangat gelap dan rawan kejahatan.',
        tanggal: '2026-07-01T20:10:00',
        status: 'dibaca'
    },
    {
        id: 6,
        nama: 'Maya Sari',
        email: 'maya@gmail.com',
        subjek: 'Bantuan Pendidikan',
        pesan: 'Apakah ada program beasiswa untuk mahasiswa kurang mampu? Saya ingin mendaftar.',
        tanggal: '2026-06-30T08:00:00',
        status: 'approved'
    },
    {
        id: 7,
        nama: 'Andi Wijaya',
        email: 'andi@gmail.com',
        subjek: 'Kebersihan Lingkungan',
        pesan: 'Selokan di depan komplek tersumbat, menyebabkan banjir saat hujan.',
        tanggal: '2026-06-29T11:30:00',
        status: 'baru'
    },
    {
        id: 8,
        nama: 'Rina Kusuma',
        email: 'rina@gmail.com',
        subjek: 'Fasilitas Olahraga',
        pesan: 'Lapangan sepak bola tidak terawat, rumput tinggi dan tidak ada pencahayaan.',
        tanggal: '2026-06-28T07:45:00',
        status: 'dibaca'
    },
    {
        id: 9,
        nama: 'Fajar Nugroho',
        email: 'fajar@gmail.com',
        subjek: 'PKL di Kantor',
        pesan: 'Apakah kantor menerima siswa PKL? Saya siswa SMK jurusan administrasi perkantoran.',
        tanggal: '2026-06-27T13:20:00',
        status: 'approved'
    },
    {
        id: 10,
        nama: 'Lina Herlina',
        email: 'lina@gmail.com',
        subjek: 'Pajak Daerah',
        pesan: 'Bagaimana cara bayar pajak daerah secara online? Website saya coba error terus.',
        tanggal: '2026-06-26T10:00:00',
        status: 'baru'
    }
];

// ===== VARIABEL GLOBAL =====
let currentPage = 1;
const itemsPerPage = 5;
let filteredData = [...aspirasiData];
let deleteId = null;

// ===== DOM ELEMENTS =====
const tbody = document.getElementById('aspirasiBody');
const searchInput = document.getElementById('searchInput');
const filterStatus = document.getElementById('filterStatus');
const filterSort = document.getElementById('filterSort');
const checkAll = document.getElementById('checkAll');
const totalAspirasi = document.getElementById('totalAspirasi');
const totalBaru = document.getElementById('totalBaru');
const totalDibaca = document.getElementById('totalDibaca');
const totalApproved = document.getElementById('totalApproved');

// ===== INISIALISASI =====
document.addEventListener('DOMContentLoaded', () => {
    updateStats();
    renderTable();
    updatePaginationInfo();

    // Event listeners
    searchInput.addEventListener('input', filterData);
    filterStatus.addEventListener('change', filterData);
    filterSort.addEventListener('change', filterData);
});

// ===== FUNGSI UTAMA =====

// Filter Data
function filterData() {
    const keyword = searchInput.value.toLowerCase().trim();
    const status = filterStatus.value;
    const sort = filterSort.value;

    filteredData = aspirasiData.filter(item => {
        const matchKeyword = item.nama.toLowerCase().includes(keyword) ||
                            item.email.toLowerCase().includes(keyword) ||
                            item.subjek.toLowerCase().includes(keyword) ||
                            item.pesan.toLowerCase().includes(keyword);
        const matchStatus = status === 'semua' || item.status === status;
        return matchKeyword && matchStatus;
    });

    // Sorting
    if (sort === 'terbaru') {
        filteredData.sort((a, b) => new Date(b.tanggal) - new Date(a.tanggal));
    } else {
        filteredData.sort((a, b) => new Date(a.tanggal) - new Date(b.tanggal));
    }

    currentPage = 1;
    renderTable();
    updatePaginationInfo();
    updateStats();
}

// Render Table
function renderTable() {
    const start = (currentPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const pageData = filteredData.slice(start, end);

    if (pageData.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="8" style="text-align:center;padding:40px;color:#94a3b8;">
                    <i class="fa-solid fa-inbox" style="font-size:40px;display:block;margin-bottom:10px;"></i>
                    Tidak ada data aspirasi
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = pageData.map(item => `
        <tr data-id="${item.id}">
            <td>
                <input type="checkbox" class="row-checkbox" onchange="updateCheckAll()">
            </td>
            <td><strong>${escapeHtml(item.nama)}</strong></td>
            <td>${escapeHtml(item.email)}</td>
            <td>${escapeHtml(item.subjek)}</td>
            <td>${escapeHtml(item.pesan.substring(0, 50))}${item.pesan.length > 50 ? '...' : ''}</td>
            <td>${formatDate(item.tanggal)}</td>
            <td>
                <span class="status-badge ${item.status}" onclick="changeStatus(${item.id})">
                    ${capitalize(item.status)}
                </span>
            </td>
            <td>
                <div class="action-buttons">
                    <button class="btn-detail" onclick="showDetail(${item.id})">
                        <i class="fa-solid fa-eye"></i> Detail
                    </button>
                    <button class="btn-hapus" onclick="showDeleteModal(${item.id})">
                        <i class="fa-solid fa-trash"></i> Hapus
                    </button>
                </div>
            </td>
        </tr>
    `).join('');

    // Reset checkbox all
    checkAll.checked = false;
}

// Update Stats
function updateStats() {
    const total = aspirasiData.length;
    const baru = aspirasiData.filter(d => d.status === 'baru').length;
    const dibaca = aspirasiData.filter(d => d.status === 'dibaca').length;
    const approved = aspirasiData.filter(d => d.status === 'approved').length;

    totalAspirasi.textContent = total;
    totalBaru.textContent = baru;
    totalDibaca.textContent = dibaca;
    totalApproved.textContent = approved;
}

// Update Pagination Info
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

// ===== PAGINATION =====
function prevPage() {
    if (currentPage > 1) {
        currentPage--;
        renderTable();
        updatePaginationInfo();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

function nextPage() {
    const totalPages = Math.ceil(filteredData.length / itemsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        renderTable();
        updatePaginationInfo();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

// ===== CHECKBOX =====
function toggleAllCheckbox() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(cb => cb.checked = checkAll.checked);
}

function updateCheckAll() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    const checked = document.querySelectorAll('.row-checkbox:checked');
    checkAll.checked = checkboxes.length === checked.length;
}

// ===== DETAIL MODAL =====
function showDetail(id) {
    const item = aspirasiData.find(d => d.id === id);
    if (!item) return;

    const body = document.getElementById('detailBody');
    body.innerHTML = `
        <div class="detail-item">
            <span class="detail-label">Nama</span>
            <span class="detail-value">${escapeHtml(item.nama)}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Email</span>
            <span class="detail-value">${escapeHtml(item.email)}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Subjek</span>
            <span class="detail-value">${escapeHtml(item.subjek)}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Pesan</span>
            <span class="detail-value">${escapeHtml(item.pesan)}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Tanggal</span>
            <span class="detail-value">${formatDate(item.tanggal)}</span>
        </div>
        <div class="detail-item">
            <span class="detail-label">Status</span>
            <span class="detail-value">
                <span class="status-badge ${item.status}">${capitalize(item.status)}</span>
            </span>
        </div>
        <div style="margin-top:20px;display:flex;gap:10px;justify-content:flex-end;">
            <button class="btn-status" onclick="changeStatus(${item.id});closeModal();">
                <i class="fa-solid fa-rotate"></i> Ubah Status
            </button>
            <button class="btn-hapus" onclick="showDeleteModal(${item.id});closeModal();">
                <i class="fa-solid fa-trash"></i> Hapus
            </button>
        </div>
    `;

    document.getElementById('detailModal').style.display = 'block';
}