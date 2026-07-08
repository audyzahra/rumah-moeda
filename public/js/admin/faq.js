// // ==============================
// // FAQ.JS
// // Manajemen FAQ
// // ==============================

// // ===== KONFIGURASI =====
// const API_URL = 'http://localhost:8000/api';
// const API_TOKEN = localStorage.getItem('api_token') || '';

// // ===== VARIABEL GLOBAL =====
// let faqData = [];
// let filteredData = [];
// let currentPage = 1;
// const itemsPerPage = 5;
// let deleteId = null;
// let editId = null;
// let categories = [];

// // ===== DOM ELEMENTS =====
// const list = document.getElementById('faqList');
// const searchInput = document.getElementById('searchInput');
// const filterKategori = document.getElementById('filterKategori');
// const filterStatus = document.getElementById('filterStatus');
// const filterSort = document.getElementById('filterSort');

// // ===== INISIALISASI =====
// document.addEventListener('DOMContentLoaded', () => {
//     loadCategories();
//     loadFaq();

//     searchInput.addEventListener('input', filterData);
//     filterKategori.addEventListener('change', filterData);
//     filterStatus.addEventListener('change', filterData);
//     filterSort.addEventListener('change', filterData);
// });

// // ============================================
// // LOAD DATA
// // ============================================

// function loadCategories() {
//     categories = [
//         { id: 1, name: 'Umum' },
//         { id: 2, name: 'Pendaftaran' },
//         { id: 3, name: 'Akun & Login' },
//         { id: 4, name: 'Pembayaran' },
//         { id: 5, name: 'Layanan' },
//         { id: 6, name: 'Teknis' }
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
    
//     const totalKategori = document.getElementById('totalKategori');
// if (totalKategori) {
//     totalKategori.textContent = categories.length;
// }
// }

// function loadFaq() {
//     // DATA DUMMY
//     faqData = [
//         {
//             id: 1,
//             category_id: 1,
//             category_name: 'Umum',
//             question: 'Apa itu sistem aspirasi?',
//             answer: 'Sistem aspirasi adalah platform yang memungkinkan masyarakat untuk menyampaikan aspirasi, masukan, dan pengaduan secara online. Sistem ini bertujuan untuk memudahkan komunikasi antara masyarakat dengan pemerintah.',
//             status: 'aktif',
//             created_at: '2026-07-05T10:00:00',
//             updated_at: '2026-07-05T10:00:00'
//         },
//         {
//             id: 2,
//             category_id: 2,
//             category_name: 'Pendaftaran',
//             question: 'Bagaimana cara mendaftar sebagai pengguna?',
//             answer: 'Untuk mendaftar sebagai pengguna, Anda dapat mengklik tombol "Daftar" pada halaman utama, mengisi formulir pendaftaran dengan data yang valid, dan melakukan verifikasi email untuk mengaktifkan akun Anda.',
//             status: 'aktif',
//             created_at: '2026-07-04T14:30:00',
//             updated_at: '2026-07-04T14:30:00'
//         },
//         {
//             id: 3,
//             category_id: 3,
//             category_name: 'Akun & Login',
//             question: 'Saya lupa password, bagaimana cara meresetnya?',
//             answer: 'Jika Anda lupa password, silahkan klik "Lupa Password" pada halaman login. Masukkan email yang terdaftar, kami akan mengirimkan link reset password ke email Anda.',
//             status: 'aktif',
//             created_at: '2026-07-03T09:15:00',
//             updated_at: '2026-07-03T09:15:00'
//         },
//         {
//             id: 4,
//             category_id: 4,
//             category_name: 'Pembayaran',
//             question: 'Apakah ada biaya untuk menggunakan layanan ini?',
//             answer: 'Layanan ini gratis untuk semua masyarakat. Tidak ada biaya apapun yang dikenakan untuk menyampaikan aspirasi atau menggunakan fitur-fitur yang tersedia.',
//             status: 'nonaktif',
//             created_at: '2026-07-02T11:45:00',
//             updated_at: '2026-07-02T11:45:00'
//         }
//     ];
// }

// ==============================
// MODAL TAMBAH / EDIT
// ==============================

function openTambahModal() {

    editId = null;

    document.getElementById("formModalTitle").textContent = "Tambah FAQ";

    document.getElementById("faqForm").reset();

    document.getElementById("editId").value = "";

    document.getElementById("formModal").style.display = "flex";
}

function closeFormModal() {

    document.getElementById("formModal").style.display = "none";

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