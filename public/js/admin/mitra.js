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

// ===== INISIALISASI =====
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

        document.getElementById('editLogo').value =
            this.dataset.logo;

        document.getElementById('editDescription').value =
            this.dataset.description ?? '';

        document.getElementById('editWebsite').value =
            this.dataset.website;

        document.getElementById('editForm').action = 
            `/admin/mitra/${id}`;

    });
});

function confirmDelete(element) {
    const id = element.getAttribute('data-id');
    const name = element.getAttribute('data-name');
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    document.getElementById('deleteName').textContent = name;
    
    const form = document.getElementById('deleteForm');
    form.action = '{{ route("admin.mitra.destroy", ":id") }}'.replace(':id', id);
    
    deleteModal.show();
}