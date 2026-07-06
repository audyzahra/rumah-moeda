// ==============================
// PENGATURAN.JS
// Manajemen Pengaturan
// ==============================

// ===== KONFIGURASI =====
const API_URL = 'http://localhost:8000/api';
const API_TOKEN = localStorage.getItem('api_token') || '';

// ===== VARIABEL GLOBAL =====
let adminData = [];
let filteredAdminData = [];
let adminCurrentPage = 1;
const adminItemsPerPage = 5;
let deleteAdminId = null;
let editAdminId = null;

// ===== DOM ELEMENTS =====
const tabBtns = document.querySelectorAll('.tab-btn');
const tabContents = document.querySelectorAll('.tab-content');

// ============================================
// TAB NAVIGATION
// ============================================

document.addEventListener('DOMContentLoaded', () => {

    // Tab navigation
    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const tabId = btn.dataset.tab;

            // Update active tab
            tabBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // Show active content
            tabContents.forEach(content => {
                content.classList.remove('active');

                if (content.id === `tab-${tabId}`) {
                    content.classList.add('active');
                }
            });
        });
    });

    // Visi & Misi sekarang dari Blade Laravel
    // loadVisiMisi();

    loadLogo();
    loadProfile();
    loadHero();
    loadAdmin();
});

document.getElementById('visiText').value = visiData.visi;

// Render misi
const container = document.getElementById('misiContainer');
container.innerHTML = '';
visiData.misi.forEach((misi, index) => {
    const misiItem = document.createElement('div');
    misiItem.className = 'misi-item';
    misiItem.innerHTML = `
            <textarea class="form-control misi-text" rows="2" placeholder="Masukkan misi ke-${index + 1}" required>${misi}</textarea>
            <button type="button" class="btn-remove-misi" onclick="removeMisi(this)">
                <i class="fa-solid fa-times"></i>
            </button>
        `;
    container.appendChild(misiItem);
});


function addMisi() {

    const container = document.getElementById('misiContainer');
    const count = container.querySelectorAll('.misi-item').length + 1;

    const misiItem = document.createElement('div');

    misiItem.className = 'misi-item';

    misiItem.innerHTML = `
        <textarea
            class="form-control misi-text"
            name="missions[]"
            rows="2"
            placeholder="Masukkan misi ke-${count}"
            required></textarea>

        <button
            type="button"
            class="btn-remove-misi"
            onclick="removeMisi(this)">

            <i class="fa-solid fa-times"></i>

        </button>
    `;

    container.appendChild(misiItem);
}

function removeMisi(button) {
    const container = document.getElementById('misiContainer');
    if (container.querySelectorAll('.misi-item').length > 1) {
        button.closest('.misi-item').remove();
    } else {
        showNotification('Minimal harus ada 1 misi!', 'error');
    }
}

function saveVisiMisi(event) {

    const visi = document.getElementById('visiText').value.trim();
    const misiTexts = document.querySelectorAll('.misi-text');
    const misi = [];
    let valid = true;

    misiTexts.forEach(textarea => {
        const value = textarea.value.trim();
        if (!value) {
            valid = false;
        }
        misi.push(value);
    });

    if (!visi || !valid) {
        showNotification('Semua field visi dan misi wajib diisi!', 'error');
        return;
    }

    // Simpan ke API
    /*
    fetch(`${API_URL}/settings/visi-misi`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${API_TOKEN}`
        },
        body: JSON.stringify({ visi, misi })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Visi & Misi berhasil disimpan!', 'success');
        } else {
            showNotification(data.message || 'Gagal menyimpan', 'error');
        }
    })
    .catch(error => {
        showNotification('Gagal menyimpan', 'error');
        console.error(error);
    });
    */

    showNotification('Visi & Misi berhasil disimpan!', 'success');
}

// ============================================
// TAB: LOGO
// ============================================

function loadLogo() {
    // Logo saat ini akan ditampilkan
    const currentLogo = document.querySelector('#currentLogo img');
    if (currentLogo) {
        currentLogo.src = 'https://via.placeholder.com/200x80/3b82f6/ffffff?text=Logo+Perusahaan';
    }
}

function previewLogo(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (e) {
        const preview = document.getElementById('logoPreview');
        preview.innerHTML = `<img src="${e.target.result}" alt="Logo Preview">`;
    };
    reader.readAsDataURL(file);
}

function saveLogo(event) {
    event.preventDefault();

    const preview = document.getElementById('logoPreview');
    const hasImage = preview.querySelector('img') !== null;

    if (!hasImage) {
        showNotification('Silahkan upload logo terlebih dahulu!', 'error');
        return;
    }

    // Simpan ke API
    /*
    const formData = new FormData();
    const file = document.getElementById('formLogo').files[0];
    formData.append('logo', file);

    fetch(`${API_URL}/settings/logo`, {
        method: 'POST',
        headers: {
            'Authorization': `Bearer ${API_TOKEN}`
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Logo berhasil disimpan!', 'success');
            loadLogo();
        } else {
            showNotification(data.message || 'Gagal menyimpan', 'error');
        }
    })
    .catch(error => {
        showNotification('Gagal menyimpan', 'error');
        console.error(error);
    });
    */

    showNotification('Logo berhasil disimpan!', 'success');
}

// ============================================
// TAB: PROFILE PERUSAHAAN
// ============================================

function loadProfile() {
    // DATA DUMMY
    const profileData = {
        nama: 'PT. Teknologi Nusantara',
        deskripsi: 'Perusahaan teknologi terkemuka di Indonesia yang bergerak di bidang pengembangan software, solusi digital, dan konsultasi IT. Berdiri sejak 2010 dan telah melayani lebih dari 500 klien.',
        alamat: 'Jl. Sudirman No. 123, Jakarta Selatan 12190',
        telepon: '(021) 1234-5678',
        email: 'info@teknologi-nusantara.com',
        jam: 'Senin - Jumat, 08:00 - 17:00',
        facebook: 'https://facebook.com/teknologi-nusantara',
        instagram: 'https://instagram.com/teknologi_nusantara',
        youtube: 'https://youtube.com/teknologi-nusantara'
    };

    document.getElementById('profileNama').value = profileData.nama;
    document.getElementById('profileDeskripsi').value = profileData.deskripsi;
    document.getElementById('profileAlamat').value = profileData.alamat;
    document.getElementById('profileTelepon').value = profileData.telepon;
    document.getElementById('profileEmail').value = profileData.email;
    document.getElementById('profileJam').value = profileData.jam;
    document.getElementById('profileFacebook').value = profileData.facebook;
    document.getElementById('profileInstagram').value = profileData.instagram;
    document.getElementById('profileYoutube').value = profileData.youtube;
}

function saveProfile(event) {
    event.preventDefault();

    const nama = document.getElementById('profileNama').value.trim();
    const deskripsi = document.getElementById('profileDeskripsi').value.trim();
    const alamat = document.getElementById('profileAlamat').value.trim();
    const telepon = document.getElementById('profileTelepon').value.trim();
    const email = document.getElementById('profileEmail').value.trim();

    if (!nama || !deskripsi || !alamat) {
        showNotification('Field yang wajib diisi harus dilengkapi!', 'error');
        return;
    }

    const profileData = {
        nama,
        deskripsi,
        alamat,
        telepon,
        email,
        jam: document.getElementById('profileJam').value,
        facebook: document.getElementById('profileFacebook').value,
        instagram: document.getElementById('profileInstagram').value,
        youtube: document.getElementById('profileYoutube').value
    };

    // Simpan ke API
    /*
    fetch(`${API_URL}/settings/profile`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${API_TOKEN}`
        },
        body: JSON.stringify(profileData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Profile perusahaan berhasil disimpan!', 'success');
        } else {
            showNotification(data.message || 'Gagal menyimpan', 'error');
        }
    })
    .catch(error => {
        showNotification('Gagal menyimpan', 'error');
        console.error(error);
    });
    */

    showNotification('Profile perusahaan berhasil disimpan!', 'success');
}

// ============================================
// TAB: HERO SECTION
// ============================================

function loadHero() {
    // DATA DUMMY
    const heroData = {
        judul: 'Selamat Datang di Website Kami',
        sub_judul: 'Kami hadir untuk memberikan solusi terbaik bagi kebutuhan Anda',
        btn_text: 'Lihat Selengkapnya',
        btn_link: '#'
    };

    document.getElementById('heroJudul').value = heroData.judul;
    document.getElementById('heroSubJudul').value = heroData.sub_judul;
    document.getElementById('heroBtnText').value = heroData.btn_text;
    document.getElementById('heroBtnLink').value = heroData.btn_link;
}

function previewHero(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (e) {
        const preview = document.getElementById('heroPreview');
        preview.innerHTML = `<img src="${e.target.result}" alt="Hero Preview">`;
    };
    reader.readAsDataURL(file);
}

function saveHero(event) {
    event.preventDefault();

    const judul = document.getElementById('heroJudul').value.trim();
    const preview = document.getElementById('heroPreview');
    const hasImage = preview.querySelector('img') !== null;

    if (!judul) {
        showNotification('Judul hero wajib diisi!', 'error');
        return;
    }

    if (!hasImage) {
        showNotification('Silahkan upload gambar hero terlebih dahulu!', 'error');
        return;
    }

    const heroData = {
        judul,
        sub_judul: document.getElementById('heroSubJudul').value,
        btn_text: document.getElementById('heroBtnText').value,
        btn_link: document.getElementById('heroBtnLink').value
    };

    // Simpan ke API
    /*
    const formData = new FormData();
    formData.append('judul', heroData.judul);
    formData.append('sub_judul', heroData.sub_judul);
    formData.append('btn_text', heroData.btn_text);
    formData.append('btn_link', heroData.btn_link);
    formData.append('hero_image', document.getElementById('formHero').files[0]);

    fetch(`${API_URL}/settings/hero`, {
        method: 'POST',
        headers: {
            'Authorization': `Bearer ${API_TOKEN}`
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Hero section berhasil disimpan!', 'success');
            loadHero();
        } else {
            showNotification(data.message || 'Gagal menyimpan', 'error');
        }
    })
    .catch(error => {
        showNotification('Gagal menyimpan', 'error');
        console.error(error);
    });
    */

    showNotification('Hero section berhasil disimpan!', 'success');
}

// ============================================
// TAB: AKUN ADMIN
// ============================================

function loadAdmin() {
    // DATA DUMMY
    adminData = [
        {
            id: 1,
            nama: 'Admin Utama',
            email: 'admin@teknologi-nusantara.com',
            role: 'superadmin',
            status: 'aktif',
            last_login: '2026-07-05 14:30:00',
            created_at: '2026-01-01 00:00:00'
        },
        {
            id: 2,
            nama: 'Editor Content',
            email: 'editor@teknologi-nusantara.com',
            role: 'editor',
            status: 'aktif',
            last_login: '2026-07-04 10:15:00',
            created_at: '2026-06-01 08:00:00'
        },
        {
            id: 3,
            nama: 'Admin Marketing',
            email: 'marketing@teknologi-nusantara.com',
            role: 'admin',
            status: 'nonaktif',
            last_login: '2026-06-28 16:45:00',
            created_at: '2026-05-15 09:30:00'
        }
    ];

    filteredAdminData = [...adminData];
    renderAdminTable();
    updateAdminPagination();
}

function renderAdminTable() {
    const start = (adminCurrentPage - 1) * adminItemsPerPage;
    const end = start + adminItemsPerPage;
    const pageData = filteredAdminData.slice(start, end);

    const tbody = document.getElementById('adminTableBody');

    if (pageData.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" style="text-align:center;padding:40px;color:#94a3b8;">
                    <i class="fa-solid fa-users" style="font-size:40px;display:block;margin-bottom:10px;"></i>
                    Tidak ada data admin
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = pageData.map((admin, index) => `
        <tr>
            <td>${start + index + 1}</td>
            <td><strong>${escapeHtml(admin.nama)}</strong></td>
            <td>${escapeHtml(admin.email)}</td>
            <td><span class="admin-role ${admin.role}">${capitalize(admin.role)}</span></td>
            <td><span class="admin-status ${admin.status}">${capitalize(admin.status)}</span></td>
            <td>${formatDate(admin.last_login)}</td>
            <td>
                <div class="admin-actions-btn">
                    <button class="btn-edit-admin" onclick="openEditAdminModal(${admin.id})">
                        <i class="fa-solid fa-pen"></i>
                    </button>
                    <button class="btn-delete-admin" onclick="showDeleteAdminModal(${admin.id})">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

function updateAdminPagination() {
    const total = filteredAdminData.length;
    const totalPages = Math.ceil(total / adminItemsPerPage);
    const start = total === 0 ? 0 : (adminCurrentPage - 1) * adminItemsPerPage + 1;
    const end = Math.min(adminCurrentPage * adminItemsPerPage, total);

    document.getElementById('adminStart').textContent = start;
    document.getElementById('adminEnd').textContent = end;
    document.getElementById('adminTotal').textContent = total;
    document.getElementById('adminPage  Info').textContent = `Halaman ${adminCurrentPage} dari ${totalPages || 1}`;
}
