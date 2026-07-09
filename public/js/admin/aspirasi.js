// =============================================
// ASPIRASI.JS
// Admin Rumah Moeda
// Rewrite Version
// =============================================

"use strict";

/* ==========================================
   ELEMENT
========================================== */

const detailModal = document.getElementById("detailModal");

const deleteModal = document.getElementById("deleteModal");

const detailBody = document.getElementById("detailBody");

const deleteForm = document.getElementById("deleteForm");

const searchInput = document.getElementById("searchInput");

const filterStatus = document.getElementById("filterStatus");

const checkAll = document.getElementById("checkAll");

const bulkDeleteBtn = document.querySelector(".btn-hapus-bulk");

let currentId = null;


/* ==========================================
   MODAL
========================================== */

function openModal(modal) {

    if (!modal) return;

    modal.classList.add("show");

}

function closeModal(modal) {

    if (!modal) return;

    modal.classList.remove("show");

}


/* ==========================================
   CLOSE MODAL
========================================== */

function closeDetailModal() {

    closeModal(detailModal);

}

function closeDeleteModal() {

    closeModal(deleteModal);

}


/* ==========================================
   CLICK OUTSIDE
========================================== */

window.addEventListener("click", function (e) {

    if (e.target === detailModal) {

        closeDetailModal();

    }

    if (e.target === deleteModal) {

        closeDeleteModal();

    }

});


/* ==========================================
   ESC CLOSE
========================================== */

document.addEventListener("keydown", function (e) {

    if (e.key === "Escape") {

        closeDetailModal();

        closeDeleteModal();

    }

});


/* ==========================================
   CHECKBOX
========================================== */

function toggleAllCheckbox() {

    const rows = document.querySelectorAll(".row-checkbox");

    rows.forEach(function (item) {

        item.checked = checkAll.checked;

    });

}


function updateCheckAll() {

    const rows = document.querySelectorAll(".row-checkbox");

    const checked = document.querySelectorAll(".row-checkbox:checked");

    checkAll.checked = (rows.length === checked.length);

}

/* ==========================================
   DETAIL ASPIRASI
========================================== */

function showDetail(data) {

    detailBody.innerHTML = `
        <div class="detail-item">
            <strong>Nama</strong><br>
            ${data.name}
        </div>

        <div class="detail-item">
            <strong>Email</strong><br>
            ${data.email}
        </div>

        <div class="detail-item">
            <strong>No HP</strong><br>
            ${data.phone ?? "-"}
        </div>

        <div class="detail-item">
            <strong>Status</strong><br>
            ${data.status ? "Dibaca" : "Belum Dibaca"}
        </div>

        <div class="detail-item">
            <strong>Tanggal</strong><br>
            ${data.created_at}
        </div>

        <div class="detail-item">
            <strong>Pesan</strong><br><br>
            ${data.message}
        </div>
    `;

    openModal(detailModal);

}
/* ==========================================
   GET SELECTED IDS
========================================== */

function getSelectedIds() {

    return [...document.querySelectorAll(".row-checkbox:checked")]

        .map(function (item) {

            return item.value;

        });

}


/* ==========================================
   BULK BUTTON
========================================== */

document.addEventListener("change", function (e) {

    if (e.target.classList.contains("row-checkbox")) {

        updateCheckAll();

        const total = getSelectedIds().length;

        if (bulkDeleteBtn) {

            bulkDeleteBtn.disabled = (total === 0);

        }

    }

});

/* ==========================================
   HAPUS ASPIRASI
========================================== */

function deleteAspirasi(id) {

    currentId = id;

    deleteForm.action = "/admin/aspirasi/" + id;

    openModal(deleteModal);

}


/* ==========================================
   SUBMIT DELETE
========================================== */

if (deleteForm) {

    deleteForm.addEventListener("submit", function () {

        const btn = deleteForm.querySelector("button[type='submit']");

        if (btn) {

            btn.disabled = true;

            btn.innerHTML =
                '<i class="fa-solid fa-spinner fa-spin"></i> Menghapus...';

        }

    });

}


/* ==========================================
   BULK DELETE
========================================== */

function bulkDelete() {

    const ids = getSelectedIds();

    if (ids.length === 0) {

        alert("Pilih minimal satu aspirasi.");

        return;

    }

    if (!confirm("Yakin ingin menghapus " + ids.length + " data?")) {

        return;

    }

    const form = document.createElement("form");

    form.method = "POST";

    form.action = "/admin/aspirasi";

    form.innerHTML = `

        <input
            type="hidden"
            name="_token"
            value="${document.querySelector('meta[name="csrf-token"]').content}">

        <input
            type="hidden"
            name="_method"
            value="DELETE">

    `;

    ids.forEach(function (id) {

        form.innerHTML += `

            <input
                type="hidden"
                name="ids[]"
                value="${id}">

        `;

    });

    document.body.appendChild(form);

    form.submit();

}


/* ==========================================
   BULK BUTTON
========================================== */

if (bulkDeleteBtn) {

    bulkDeleteBtn.addEventListener("click", bulkDelete);

}
/* ==========================================
   FILTER STATUS
========================================== */

if (filterStatus) {

    filterStatus.addEventListener("change", filterData);

}

if (searchInput) {

    searchInput.addEventListener("input", filterData);

}

/* ==========================================
   FILTER DATA
========================================== */

function filterData() {

    // Ambil keyword pencarian
    const keyword = searchInput.value
        .trim()
        .toLowerCase();

    // Ambil status
    const status = filterStatus.value;

    // Semua baris tabel
    const rows = document.querySelectorAll("#aspirasiBody tr");

    rows.forEach(function (row) {

        // Skip baris "Belum ada aspirasi"
        if (!row.dataset.name) return;

        const nama = (row.dataset.name || "").toLowerCase();
        const email = (row.dataset.email || "").toLowerCase();
        const isRead = row.dataset.status || "";

        let tampil = true;

        // ===============================
        // FILTER NAMA / EMAIL
        // ===============================
        if (keyword !== "") {

            const cocokNama = nama.includes(keyword);
            const cocokEmail = email.includes(keyword);

            if (!cocokNama && !cocokEmail) {
                tampil = false;
            }

        }

        // ===============================
        // FILTER STATUS
        // ===============================
        if (status !== "" && isRead !== status) {

            tampil = false;

        }

        // Tampilkan / Sembunyikan
        row.style.display = tampil ? "" : "none";

    });

}
