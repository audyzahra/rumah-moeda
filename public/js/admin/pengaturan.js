// ==============================
// PENGATURAN.JS
// Rumah Moeda
// ==============================

// =====================================
// DOM ELEMENT
// =====================================

const tabBtns = document.querySelectorAll('.tab-btn');
const tabContents = document.querySelectorAll('.tab-content');

// =====================================
// DOM READY
// =====================================

document.addEventListener('DOMContentLoaded', function () {

    initTabs();

});

// =====================================
// TAB NAVIGATION
// =====================================

function initTabs() {

    tabBtns.forEach(function (btn) {

        btn.addEventListener('click', function () {

            const tabId = this.dataset.tab;

            tabBtns.forEach(function (item) {

                item.classList.remove('active');

            });

            this.classList.add('active');

            tabContents.forEach(function (content) {

                content.classList.remove('active');

                if (content.id === 'tab-' + tabId) {

                    content.classList.add('active');

                }

            });

        });

    });

}

// =====================================
// NOTIFICATION
// =====================================

function showNotification(message, type = 'success') {

    let notification = document.querySelector('.notification');

    if (!notification) {

        notification = document.createElement('div');

        notification.className = 'notification';

        document.body.appendChild(notification);

    }

    notification.className = 'notification ' + type;

    notification.innerHTML = message;

    notification.classList.add('show');

    setTimeout(function () {

        notification.classList.remove('show');

    }, 3000);

}

// =====================================
// ESCAPE HTML
// =====================================

function escapeHtml(text) {

    const div = document.createElement('div');

    div.textContent = text;

    return div.innerHTML;

}

// =====================================
// CAPITALIZE
// =====================================

function capitalize(text) {

    if (!text) return '';

    return text.charAt(0).toUpperCase() + text.slice(1);

}
// =====================================
// VISI & MISI
// =====================================

function addMisi() {

    const container = document.getElementById('misiContainer');

    const count = container.querySelectorAll('.misi-item').length + 1;

    const item = document.createElement('div');

    item.className = 'misi-item';

    item.innerHTML = `
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

    container.appendChild(item);

}

function removeMisi(button) {

    const container = document.getElementById('misiContainer');

    if (container.querySelectorAll('.misi-item').length <= 1) {

        showNotification(
            'Minimal harus ada satu misi.',
            'error'
        );

        return;

    }

    button.closest('.misi-item').remove();

}

// =====================================
// PREVIEW LOGO
// =====================================

function previewLogo(event) {

    const file = event.target.files[0];

    if (!file) return;

    const reader = new FileReader();

    reader.onload = function (e) {

        document.getElementById('logoPreview').innerHTML = `
            <img
                src="${e.target.result}"
                alt="Preview Logo">
        `;

    };

    reader.readAsDataURL(file);

}

// =====================================
// PREVIEW HERO
// =====================================

function previewHero(event) {

    const file = event.target.files[0];

    if (!file) return;

    const reader = new FileReader();

    reader.onload = function (e) {

        document.getElementById('heroPreview').innerHTML = `
            <img
                src="${e.target.result}"
                alt="Preview Hero">
        `;

    };

    reader.readAsDataURL(file);

}

// =====================================
// RESET PREVIEW LOGO
// =====================================

function resetLogoPreview() {

    document.getElementById('logoPreview').innerHTML = `

        <i class="fa-solid fa-cloud-upload-alt"></i>

        <p>

            Klik untuk upload logo

        </p>

        <small>

            Format :
            JPG, PNG, SVG

            <br>

            Maksimal 2 MB

            <br>

            Rekomendasi ukuran
            200 × 80 px

        </small>

    `;

}

// =====================================
// RESET PREVIEW HERO
// =====================================

function resetHeroPreview() {

    document.getElementById('heroPreview').innerHTML = `

        <i class="fa-solid fa-cloud-upload-alt"></i>

        <p>

            Klik untuk memilih gambar

        </p>

        <small>

            Format :
            JPG, JPEG, PNG

            <br>

            Maksimal 5 MB

            <br>

            Disarankan ukuran
            1920 × 1080 px

        </small>

    `;

}

// =====================================
// CLOSE MODAL SAAT KLIK DI LUAR
// =====================================

window.addEventListener('click', function (e) {

    const modals = [

        'modalTambahAdmin',
        'modalEditAdmin',
        'modalHapusAdmin'

    ];

    modals.forEach(function (id) {

        const modal = document.getElementById(id);

        if (!modal) return;

        if (e.target === modal) {

            modal.classList.remove('show');

        }

    });

});

// =====================================
// TOMBOL ESC
// =====================================

document.addEventListener('keydown', function (e) {

    if (e.key === 'Escape') {

        closeModalTambahAdmin();

        closeModalEditAdmin();

        closeModalHapusAdmin();

    }

});

// =====================================
// RESET FORM TAMBAH AKUN
// =====================================

function resetTambahAdminForm() {

    const form = document.querySelector('#modalTambahAdmin form');

    if (form) {

        form.reset();

    }

}

// =====================================
// RESET FORM EDIT AKUN
// =====================================

function resetEditAdminForm() {

    const form = document.getElementById('formEditAdmin');

    if (form) {

        form.reset();

    }

}

// =====================================
// OVERRIDE OPEN MODAL
// =====================================
function openModalTambahAdmin() {

    const modal = document.getElementById('modalTambahAdmin');

    if (!modal) return;

    modal.classList.add('show');

}
function openModalEditAdmin(button) {

    const modal = document.getElementById('modalEditAdmin');

    if (!modal) return;

    const id = button.dataset.id;
    const name = button.dataset.name;
    const email = button.dataset.email;
    const role = button.dataset.role;

    document.getElementById('edit_name').value = name;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_role').value = role;

    document.getElementById('formEditAdmin').action =
        '/admin/pengaturan/user/' + id;

    modal.classList.add('show');

}
function openModalHapusAdmin(button) {

    const modal = document.getElementById('modalHapusAdmin');

    if (!modal) return;

    document.getElementById('formDeleteAdmin').action =
        '/admin/pengaturan/user/' + button.dataset.id;

    modal.classList.add('show');

}

// =====================================
// OVERRIDE CLOSE MODAL
// =====================================

function closeModalTambahAdmin() {

    document
        .getElementById('modalTambahAdmin')
        .classList.remove('show');

    resetTambahAdminForm();

}

function closeModalEditAdmin() {

    document
        .getElementById('modalEditAdmin')
        .classList.remove('show');

    resetEditAdminForm();

}

function closeModalHapusAdmin() {

    document
        .getElementById('modalHapusAdmin')
        .classList.remove('show');

}
