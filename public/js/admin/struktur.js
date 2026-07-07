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
// const filter



document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('formModal');
    const btnTambah = document.querySelector('.btn-tambah');
    const btnClose = document.querySelector('.modal-close');

    btnTambah.addEventListener('click', function () {
        modal.classList.add('show');
    });

    btnClose.addEventListener('click', function () {
        modal.classList.remove('show');
    });

    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            modal.classList.remove('show');
        }
    });

});



document.querySelectorAll('.btn-edit').forEach(button => {

    button.addEventListener('click', function(){

        let id = this.dataset.id;


        document.getElementById('editName').value =
            this.dataset.name;


        document.getElementById('editPosition').value =
            this.dataset.position;


        document.getElementById('editOrder').value =
            this.dataset.order;


        document.getElementById('editDescription').value =
            this.dataset.description ?? '';


        document.getElementById('editForm').action =
            "/admin/struktur/" + id;

    });

});

