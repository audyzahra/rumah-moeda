// ==============================
// STRUKTUR.JS
// Manajemen Struktur Organisasi
// ==============================

// ===== KONFIGURASI =====
const API_URL = 'http://localhost:8000/api';
const API_TOKEN = localStorage.getItem('api_token') || '';

// ===== VARIABEL GLOBAL =====
let strukturData = [];
let filteredData = [];
let currentPage = 1;
const itemsPerPage = 8;
let deleteId = null;
let editId = null;

// ===== DOM ELEMENTS =====
const grid = document.getElementById('strukturGrid');
const searchInput = document.getElementById('searchInput');
const filterJabatan = document.getElementById('filterJabatan');
const filter