// =============================================
// ASPIRASI.JS
// Admin Rumah Moeda
// =============================================

/* ==========================================
   BASE URL
========================================== */

const isAdmin = window.location.pathname.startsWith("/admin");

const aspirasiBaseUrl = isAdmin
    ? "/admin/aspirasi"
    : "/dashboard/messages";

"use strict";

/* ==========================================
   ELEMENT
========================================== */

const detailModal = document.getElementById("detailModal");

const detailBody = document.getElementById("detailBody");

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

function showDetail(button) {

    const data = {
        id: button.dataset.id,
        name: button.dataset.name,
        email: button.dataset.email,
        phone: button.dataset.phone,
        message: button.dataset.message,
        status: button.dataset.status,
        created_at: button.dataset.created
    };

    detailBody.innerHTML = `
    <div class="detail-item">
        <div class="detail-label">Nama</div>
        <div class="detail-value">${data.name}</div>
    </div>

    <div class="detail-item">
        <div class="detail-label">Email</div>
        <div class="detail-value">${data.email}</div>
    </div>

    <div class="detail-item">
        <div class="detail-label">No HP</div>
        <div class="detail-value">${data.phone || "-"}</div>
    </div>

    <div class="detail-item">
        <div class="detail-label">Status</div>
        <div class="detail-value">
            ${data.status == "1" ? "Dibaca" : "Belum Dibaca"}
        </div>
    </div>

    <div class="detail-item">
        <div class="detail-label">Tanggal</div>
        <div class="detail-value">${data.created_at}</div>
    </div>

    <div class="detail-item">
        <div class="detail-label">Pesan</div>
        <div class="detail-value">${data.message}</div>
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

    Swal.fire({
        title: 'Hapus Aspirasi?',
        text: 'Aspirasi yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fa-solid fa-trash"></i> Ya, Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {

        if (result.isConfirmed) {

            const form = document.createElement('form');

            form.method = 'POST';
            form.action = `/admin/messages/${id}`;

            form.innerHTML = `
                <input type="hidden" name="_token" content="${document.querySelector('meta[name="csrf-token"]').content}" value="${document.querySelector('meta[name="csrf-token"]').content}">
                <input type="hidden" name="_method" value="DELETE">
            `;

            document.body.appendChild(form);
            form.submit();

        }

    });

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

    form.action = aspirasiBaseUrl;

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



    // Ambil keyword pencarian
    function filterData() {

        const keyword = searchInput
            ? searchInput.value.trim().toLowerCase()
            : "";

        const status = filterStatus
            ? filterStatus.value
            : "";

        const rows =
            document.querySelectorAll("#aspirasiBody tr");

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
            if (
                filterStatus &&
                status !== "" &&
                isRead !== status
            ) {

                tampil = false;

            }

            // Tampilkan / Sembunyikan
            row.style.display = tampil ? "" : "none";

        });

    }
