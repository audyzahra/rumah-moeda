// // ==============================
// // DOKUMENTASI.JS
// // Manajemen Dokumentasi
// // ==============================

// // ===== KONFIGURASI =====
// const API_URL = 'http://localhost:8000/api';
// const API_TOKEN = localStorage.getItem('api_token') || '';

// // ===== VARIABEL GLOBAL =====
// let dokumentasiData = [];
// let filteredData = [];
// let currentPage = 1;
// const itemsPerPage = 8;
// let deleteId = null;
// let editId = null;
// let categories = [];

// // ===== DOM ELEMENTS =====
// const grid = document.getElementById('dokumentasiGrid');
// const searchInput = document.getElementById('searchInput');
// const filterKategori = document.getElementById('filterKategori');
// const filterStatus = document.getElementById('filterStatus');
// const filterSort = document.getElementById('filterSort');

// // ===== INISIALISASI =====
// document.addEventListener('DOMContentLoaded', () => {
//     loadCategories();
//     loadDokumentasi();

//     searchInput.addEventListener('input', filterData);
//     filterKategori.addEventListener('change', filterData);
//     filterStatus.addEventListener('change', filterData);
//     filterSort.addEventListener('change', filterData);
// });

// // ============================================
// // LOAD DATA
// // ============================================

// // Load Kategori
// function loadCategories() {
//     categories = [
//         { id: 1, name: 'Kegiatan Sosial' },
//         { id: 2, name: 'Kegiatan Ekonomi' },
//         { id: 3, name: 'Kegiatan Pendidikan' },
//         { id: 4, name: 'Kegiatan Kesehatan' },
//         { id: 5, name: 'Kegiatan Olahraga' },
//         { id: 6, name: 'Kegiatan Seni Budaya' },
//         { id: 7, name: 'Kegiatan Lingkungan' },
//         { id: 8, name: 'Kegiatan Keagamaan' }
//     ];
//     populateCategoryDropdowns();
// }

// function populateCategoryDropdowns() {
//     const selects = [filterKategori, document.getElementById('formKategori')];
//     selects.forEach(select => {
//         if (!select) return;
//         select.innerHTML = '<option value="">Pilih Kategori</option>';
//         categories.forEach(cat => {
//             select.innerHTML += `<option value="${cat.id}">${cat.name}</option>`;
//         });
//     });
    
//     document.getElementById('totalKategori').textContent = categories.length;
// }

// // Load Dokumentasi
// function loadDokumentasi() {
//     // DATA DUMMY
//     dokumentasiData = [
//         {
//             id: 1,
//             judul: 'Kegiatan Gotong Royong Bersama Warga',
//             foto: 'https://via.placeholder.com/400x300/8b5cf6/ffffff?text=Gotong+Royong',
//             deskripsi: 'Kegiatan gotong royong membersihkan lingkungan bersama warga sekitar. Dilaksanakan pada hari Minggu pagi.',
//             kategori_id: 1,
//             kategori_name: 'Kegiatan Sosial',
//             status: 'aktif',
//             created_at: '2026-07-05T10:00:00'
//         },
//         {
//             id: 2,
//             judul: 'Pelatihan UMKM untuk Warga Desa',
//             foto: 'https://via.placeholder.com/400x300/10b981/ffffff?text=Pelatihan+UMKM',
//             deskripsi: 'Pelatihan untuk meningkatkan keterampilan warga dalam mengelola usaha mikro, kecil, dan menengah (UMKM).',              
//             kategori_id: 2,
//             kategori_name: 'Kegiatan Ekonomi',
//             status: 'aktif',
//             created_at: '2026-07-06T14:30:00'
//         },]}


function editGallery(id, title, date, description)
{
    document.getElementById('edit_title').value = title;
    document.getElementById('edit_activity_date').value = date;
    document.getElementById('edit_description').value = description;

    document.getElementById('editForm').action =
        '/admin/gallery/' + id;

    document.getElementById('editModal').style.display = 'flex';
}

function closeEditModal()
{
    document.getElementById('editModal').style.display = 'none';
}

function openCreateModal(){
    document.getElementById('createModal').style.display='flex';
}

function closeCreateModal(){
    document.getElementById('createModal').style.display='none';
}

setTimeout(() => {
    const alert = document.querySelector('.alert-success');

    if (alert) {
        alert.style.transition = "all .5s ease";
        alert.style.opacity = "0";
        alert.style.transform = "translateY(-10px)";

        setTimeout(() => {
            alert.remove();
        }, 500);
    }
}, 3000);