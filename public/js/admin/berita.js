// =============================================
// BERITA.JS
// Admin Rumah Moeda
// =============================================
/* ==========================================
   BASE URL (ADMIN / USER)
========================================== */

const isAdmin = window.location.pathname.startsWith("/admin");

const beritaBaseUrl = isAdmin
    ? "/admin/news"
    : "/dashboard/news";

"use strict";

/* ==========================================
   ELEMENT
========================================== */

const formModal = document.getElementById("formModal");
const detailModal = document.getElementById("detailModal");

const beritaForm = document.getElementById("beritaForm");

const preview = document.getElementById("preview");



const searchInput = document.getElementById("searchInput");

const categoryFilter = document.getElementById("categoryFilter");

let currentNews = null;


/* ==========================================
   OPEN MODAL
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

function closeFormModal() {

    closeModal(formModal);

}

function closeDetailModal() {

    closeModal(detailModal);

}



/* ==========================================
   CLICK OUTSIDE MODAL
========================================== */

window.addEventListener("click", function (e) {

    if (e.target === formModal) {

        closeFormModal();

    }

    if (e.target === detailModal) {

        closeDetailModal();

    }



});


/* ==========================================
   ESC CLOSE
========================================== */

document.addEventListener("keydown", function (e) {

    if (e.key === "Escape") {

        closeFormModal();

        closeDetailModal();



    }

});


/* ==========================================
   PREVIEW IMAGE
========================================== */

function previewImage(event) {

    const file = event.target.files[0];

    if (!file) {

        preview.src = "";

        preview.style.display = "none";

        return;

    }

    const reader = new FileReader();

    reader.onload = function (e) {

        preview.src = e.target.result;

        preview.style.display = "block";

    }

    reader.readAsDataURL(file);

}


/* ==========================================
   RESET FORM
========================================== */

function resetBeritaForm() {

    beritaForm.reset();

    currentNews = null;

    preview.src = "";

    preview.style.display = "none";

    document.getElementById("berita_id").value = "";

    const method = document.getElementById("formMethod");

    if (method) {

        method.remove();

    }

    beritaForm.action = beritaBaseUrl;

    document.getElementById("formModalTitle").innerHTML = "Tambah Berita";

}


/* ==========================================
   EDIT BERITA
========================================== */

function openEditModal(news) {

    resetBeritaForm();

    currentNews = news;

    beritaForm.action = beritaBaseUrl + "/" + news.id;

    document.getElementById("formModalTitle").innerHTML = "Edit Berita";

    // Tambahkan method PUT
    const method = document.createElement("input");

    method.type = "hidden";

    method.name = "_method";

    method.value = "PUT";

    method.id = "formMethod";

    beritaForm.appendChild(method);

    // Isi Form
    document.getElementById("title").value =
        news.title ?? "";

    document.getElementById("content").value =
        news.content ?? "";

    document.getElementById("category_id").value =
        news.category_id ?? "";

    if (news.publish_date) {

        document.getElementById("publish_date").value =
            news.publish_date.substring(0, 16);

    }

    // Thumbnail Lama
    if (news.thumbnail) {

        preview.src = news.thumbnail.startsWith("http")
            ? news.thumbnail
            : "/" + news.thumbnail;

        preview.style.display = "block";

    }

    openModal(formModal);

}


/* ==========================================
   ALIAS
========================================== */

/*
Blade sekarang memakai

onclick="editBerita(...)"

jadi kita arahkan ke openEditModal()
*/

function editBerita(news) {

    openEditModal(news);

}


/* ==========================================
   SUBMIT FORM
========================================== */

if (beritaForm) {

    beritaForm.addEventListener("submit", function () {

        const button =
            beritaForm.querySelector("button[type='submit']");

        if (button) {

            button.disabled = true;

            button.innerHTML =
                '<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan...';

        }

    });

}
/* ==========================================
   DETAIL BERITA
========================================== */

function showDetail(news) {

    currentNews = news;

    // Thumbnail
    document.getElementById("detailThumbnail").src =
        news.thumbnail
            ? news.thumbnail
            : "/assets/no-image.png";

    // Judul
    document.getElementById("detailTitle").textContent =
        news.title ?? "-";

    // Kategori
    document.getElementById("detailCategory").textContent =
        news.category ?? "-";

    // Author
    document.getElementById("detailAuthor").textContent =
        news.author ?? "-";

    // Tanggal
    document.getElementById("detailDate").textContent =
        news.publish_date ?? "-";

    // Isi
    document.getElementById("detailContent").innerHTML =
        news.content ?? "-";

    openModal(detailModal);

}


/* ==========================================
   HAPUS BERITA
========================================== */

function deleteBerita(id) {

    Swal.fire({
        title: 'Hapus Berita?',
        text: 'Berita yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {

        if (result.isConfirmed) {

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `${beritaBaseUrl}/${id}`;

            form.innerHTML = `
                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                <input type="hidden" name="_method" value="DELETE">
            `;

            document.body.appendChild(form);
            form.submit();
        }

    });

}

/* ==========================================
   SEARCH & FILTER BERITA
========================================== */

function filterBerita() {

    const keyword = searchInput.value.toLowerCase().trim();
    const selectedCategory = categoryFilter.value;

    const rows = document.querySelectorAll(".berita-table tbody tr");

    rows.forEach(function (row) {

        // Lewati baris empty state
        if (row.querySelector(".empty-state")) return;

        const title = row.dataset.title || "";
        const category = row.dataset.category || "";

        const matchTitle = title.includes(keyword);

        const matchCategory =
            selectedCategory === "" ||
            category === selectedCategory;

        row.style.display = (matchTitle && matchCategory) ? "" : "none";

    });

}

if (searchInput) {

    searchInput.addEventListener("keyup", filterBerita);

}

if (categoryFilter) {

    categoryFilter.addEventListener("change", filterBerita);

}

/* ==========================================
   AUTO HIDE NOTIFICATION
========================================== */

document.addEventListener("DOMContentLoaded", () => {

    const notification = document.getElementById("notification");

    if (!notification) return;

    setTimeout(() => {

        notification.classList.remove("show");

        setTimeout(() => {
            notification.remove();
        }, 350);

    }, 3000);

});
