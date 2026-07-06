// ==============================
// MITRA.JS
// Manajemen Mitra
// ==============================

// ===== KONFIGURASI =====
const API_URL = 'http://localhost:8000/api';
const API_TOKEN = localStorage.getItem('api_token') || '';

// ===== VARIABEL GLOBAL =====
let mitraData = [];
let filteredData = [];
let currentPage = 1;
const itemsPerPage = 8;
let deleteId = null;
let editId = null;

// ===== DOM ELEMENTS =====
const grid = document.getElementById('mitraGrid');
const searchInput = document.getElementById('searchInput');
const filterWebsite = document.getElementById('filterWebsite');
const filterSort = document.getElementById('filterSort');

// ===== INISIALISASI =====
document.addEventListener('DOMContentLoaded', () => {
    loadMitra();

    searchInput.addEventListener('input', filterData);
    filterWebsite.addEventListener('change', filterData);
    filterSort.addEventListener('change', filterData);
});

// ============================================
// LOAD DATA
// ============================================

function loadMitra() {
    // DATA DUMMY
    mitraData = [
        {
            id: 1,
            name: 'PT. Teknologi Nusantara',
            logo: 'https://via.placeholder.com/200x100/3b82f6/ffffff?text=PT+Teknologi',
            description: 'Perusahaan teknologi terkemuka di Indonesia yang bergerak di bidang pengembangan software dan solusi digital.',
            website: 'https://teknologi-nusantara.com',
            display_order: 1,
            created_at: '2026-07-05T10:00:00',
            updated_at: '2026-07-05T10:00:00'
        },
        {
            id: 2,
            name: 'CV. Kreatif Mandiri',
            logo: 'https://via.placeholder.com/200x100/10b981/ffffff?text=Kreatif+Mandiri',
            description: 'Perusahaan kreatif yang fokus pada desain grafis, branding, dan pemasaran digital.',
            website: 'https://kreatif-mandiri.com',
            display_order: 2,
            created_at: '2026-07-04T14:30:00',
            updated_at: '2026-07-04T14:30:00'
        },
        {
            id: 3,
            name: 'Yayasan Peduli Anak',
            logo: 'https://via.placeholder.com/200x100/f59e0b/ffffff?text=Yayasan+Peduli',
            description: 'Yayasan yang bergerak di bidang pendidikan dan kesejahteraan anak-anak kurang mampu.',
            website: null,
            display_order: 3,
            created_at: '2026-07-03T09:15:00',
            updated_at: '2026-07-03T09:15:00'
        },
        {
            id: 4,
            name: 'PT. Agro Mandiri Sejahtera',
            logo: 'https://via.placeholder.com/200x100/8b5cf6/ffffff?text=Agro+Mandiri',
            description: 'Perusahaan agribisnis yang mengelola perkebunan dan produksi hasil pertanian organik.',
            website: 'https://agro-mandiri.com',
            display_order: 4,
            created_at: '2026-07-02T11:45:00',
            updated_at: '2026-07-02T11:45:00'   
        }
    ];
}