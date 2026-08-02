// =============================================
// BERITA.JS
// Admin Rumah Moeda
// =============================================

/* ==========================================
   BASE URL
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

let searchTimer = null;

let currentRequest = null;


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

    };

    reader.readAsDataURL(file);

}


/* ==========================================
   RESET FORM
========================================== */

function resetBeritaForm() {

    if (!beritaForm) return;

    beritaForm.reset();

    currentNews = null;

    if (preview) {

        preview.src = "";

        preview.style.display = "none";

    }

    const beritaId =
        document.getElementById("berita_id");

    if (beritaId) {

        beritaId.value = "";

    }

    const method =
        document.getElementById("formMethod");

    if (method) {

        method.remove();

    }

    beritaForm.action = beritaBaseUrl;

    const formModalTitle =
        document.getElementById(
            "formModalTitle"
        );

    if (formModalTitle) {

        formModalTitle.innerHTML =
            "Tambah Berita";

    }

}


/* ==========================================
   EDIT BERITA
========================================== */

function openEditModal(news) {

    if (!beritaForm) return;

    resetBeritaForm();

    currentNews = news;

    beritaForm.action =
        beritaBaseUrl + "/" + news.id;


    const formModalTitle =
        document.getElementById(
            "formModalTitle"
        );

    if (formModalTitle) {

        formModalTitle.innerHTML =
            "Edit Berita";

    }


    /* ==========================================
       METHOD PUT
    ========================================== */

    const method =
        document.createElement("input");

    method.type = "hidden";

    method.name = "_method";

    method.value = "PUT";

    method.id = "formMethod";

    beritaForm.appendChild(method);


    /* ==========================================
       ISI FORM
    ========================================== */

    const titleInput =
        document.getElementById("title");

    if (titleInput) {

        titleInput.value =
            news.title ?? "";

    }


    const contentInput =
        document.getElementById("content");

    if (contentInput) {

        contentInput.value =
            news.content ?? "";

    }


    const categoryInput =
        document.getElementById("category_id");

    if (categoryInput) {

        categoryInput.value =
            news.category_id ?? "";

    }


    const publishDateInput =
        document.getElementById(
            "publish_date"
        );

    if (
        publishDateInput &&
        news.publish_date
    ) {

        publishDateInput.value =
            news.publish_date.substring(
                0,
                16
            );

    }


    /* ==========================================
       THUMBNAIL LAMA
    ========================================== */

    if (
        news.thumbnail &&
        preview
    ) {

        preview.src =
            news.thumbnail.startsWith("http")
                ? news.thumbnail
                : "/" + news.thumbnail;

        preview.style.display =
            "block";

    }


    openModal(formModal);

}


/* ==========================================
   ALIAS EDIT
========================================== */

function editBerita(news) {

    openEditModal(news);

}


/* ==========================================
   SUBMIT FORM
========================================== */

if (beritaForm) {

    beritaForm.addEventListener(
        "submit",
        function () {

            const button =
                beritaForm.querySelector(
                    "button[type='submit']"
                );

            if (button) {

                button.disabled =
                    true;

                button.innerHTML =
                    '<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan...';

            }

        }
    );

}


/* ==========================================
   DETAIL BERITA
========================================== */

function showDetail(news) {

    currentNews = news;


    /* ==========================================
       THUMBNAIL
    ========================================== */

    const detailThumbnail =
        document.getElementById(
            "detailThumbnail"
        );

    if (detailThumbnail) {

        detailThumbnail.src =
            news.thumbnail
                ? news.thumbnail
                : "/assets/no-image.png";

    }


    /* ==========================================
       JUDUL
    ========================================== */

    const detailTitle =
        document.getElementById(
            "detailTitle"
        );

    if (detailTitle) {

        detailTitle.textContent =
            news.title ?? "-";

    }


    /* ==========================================
       KATEGORI
    ========================================== */

    const detailCategory =
        document.getElementById(
            "detailCategory"
        );

    if (detailCategory) {

        detailCategory.textContent =
            news.category ?? "-";

    }


    /* ==========================================
       AUTHOR
    ========================================== */

    const detailAuthor =
        document.getElementById(
            "detailAuthor"
        );

    if (detailAuthor) {

        detailAuthor.textContent =
            news.author ?? "-";

    }


    /* ==========================================
       TANGGAL
    ========================================== */

    const detailDate =
        document.getElementById(
            "detailDate"
        );

    if (detailDate) {

        detailDate.textContent =
            news.publish_date ?? "-";

    }


    /* ==========================================
       CONTENT
    ========================================== */

    const detailContent =
        document.getElementById(
            "detailContent"
        );

    if (detailContent) {

        detailContent.innerHTML =
            news.content ?? "-";

    }


    openModal(detailModal);

}


/* ==========================================
   HAPUS BERITA
========================================== */

function deleteBerita(id) {

    Swal.fire({

        title: "Hapus Berita?",

        text:
            "Berita yang dihapus tidak dapat dikembalikan.",

        icon: "warning",

        showCancelButton: true,

        confirmButtonColor: "#dc2626",

        cancelButtonColor: "#6b7280",

        confirmButtonText: "Ya, Hapus",

        cancelButtonText: "Batal",

        reverseButtons: true

    }).then(function (result) {

        if (!result.isConfirmed) {

            return;

        }


        const csrfToken =
            document.querySelector(
                'meta[name="csrf-token"]'
            );

        if (!csrfToken) {

            console.error(
                "CSRF token tidak ditemukan."
            );

            return;

        }


        const form =
            document.createElement("form");


        form.method = "POST";

        form.action =
            `${beritaBaseUrl}/${id}`;


        form.innerHTML = `

            <input
                type="hidden"
                name="_token"
                value="${csrfToken.content}">

            <input
                type="hidden"
                name="_method"
                value="DELETE">

        `;


        document.body.appendChild(form);

        form.submit();

    });

}


/* ==========================================
   LIVE SEARCH
========================================== */

if (searchInput) {

    searchInput.addEventListener(
        "input",
        function () {

            clearTimeout(searchTimer);


            const keyword =
                searchInput.value.trim();


            /*
            |--------------------------------------------------------------------------
            | Kalau kosong, langsung tampilkan semua
            |--------------------------------------------------------------------------
            */

            if (keyword === "") {

                applyServerFilter();

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | Debounce 150ms
            |--------------------------------------------------------------------------
            */

            searchTimer = setTimeout(
                function () {

                    applyServerFilter();

                },
                150
            );

        }
    );

}


/* ==========================================
   CATEGORY FILTER
========================================== */

if (categoryFilter) {

    categoryFilter.addEventListener(
        "change",
        function () {

            applyServerFilter();

        }
    );

}


/* ==========================================
   APPLY SERVER FILTER
========================================== */

function applyServerFilter() {

    const keyword =
        searchInput
            ? searchInput.value.trim()
            : "";


    const category =
        categoryFilter
            ? categoryFilter.value
            : "";


    const url =
        new URL(
            window.location.href
        );


    /* ==========================================
       SEARCH
    ========================================== */

    if (keyword !== "") {

        url.searchParams.set(
            "search",
            keyword
        );

    } else {

        url.searchParams.delete(
            "search"
        );

    }


    /* ==========================================
       CATEGORY
    ========================================== */

    if (category !== "") {

        url.searchParams.set(
            "category",
            category
        );

    } else {

        url.searchParams.delete(
            "category"
        );

    }


    /* ==========================================
       RESET PAGE
    ========================================== */

    url.searchParams.delete(
        "page"
    );


    loadNewsPage(url);

}


/* ==========================================
   AJAX PAGINATION CLICK
========================================== */

document.addEventListener(
    "click",
    function (e) {

        const pageLink =
            e.target.closest(
                ".custom-pagination a"
            );


        if (!pageLink) {

            return;

        }


        e.preventDefault();


        const url =
            new URL(
                pageLink.href
            );


        loadNewsPage(url);

    }
);


/* ==========================================
   PER PAGE
========================================== */

document.addEventListener(
    "change",
    function (e) {

        if (
            e.target.id !==
            "perPageSelect"
        ) {

            return;

        }


        const url =
            new URL(
                window.location.href
            );


        url.searchParams.set(
            "per_page",
            e.target.value
        );


        url.searchParams.delete(
            "page"
        );


        loadNewsPage(url);

    }
);


/* ==========================================
   LOAD NEWS PAGE AJAX
========================================== */

function loadNewsPage(url) {

    /*
    |--------------------------------------------------------------------------
    | Pertahankan search
    |--------------------------------------------------------------------------
    */

    const keyword =
        searchInput
            ? searchInput.value.trim()
            : "";


    if (keyword !== "") {

        url.searchParams.set(
            "search",
            keyword
        );

    } else {

        url.searchParams.delete(
            "search"
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Pertahankan kategori
    |--------------------------------------------------------------------------
    */

    const category =
        categoryFilter
            ? categoryFilter.value
            : "";


    if (category !== "") {

        url.searchParams.set(
            "category",
            category
        );

    } else {

        url.searchParams.delete(
            "category"
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Batalkan request sebelumnya
    |--------------------------------------------------------------------------
    */

    if (currentRequest) {

        currentRequest.abort();

    }


    currentRequest =
        new AbortController();


    fetch(
        url.toString(),
        {

            method: "GET",

            signal:
                currentRequest.signal,

            headers: {

                "X-Requested-With":
                    "XMLHttpRequest",

                "Accept":
                    "text/html"

            }

        }
    )

    .then(function (response) {

        if (!response.ok) {

            throw new Error(
                "Gagal memuat data berita."
            );

        }

        return response.text();

    })

    .then(function (html) {

        const parser =
            new DOMParser();


        const doc =
            parser.parseFromString(
                html,
                "text/html"
            );


        /*
        |--------------------------------------------------------------------------
        | UPDATE TABLE
        |--------------------------------------------------------------------------
        */

        const newTableBody =
            doc.querySelector(
                "#newsTableBody"
            );


        const currentTableBody =
            document.querySelector(
                "#newsTableBody"
            );


        if (
            newTableBody &&
            currentTableBody
        ) {

            currentTableBody.innerHTML =
                newTableBody.innerHTML;

        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE PAGINATION
        |--------------------------------------------------------------------------
        */

        const newPagination =
            doc.querySelector(
                ".custom-pagination"
            );


        const currentPagination =
            document.querySelector(
                ".custom-pagination"
            );


        if (
            newPagination &&
            currentPagination
        ) {

            currentPagination.innerHTML =
                newPagination.innerHTML;

        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE URL
        |--------------------------------------------------------------------------
        */

        window.history.replaceState(
            {},
            "",
            url.toString()
        );


        currentRequest = null;

    })

    .catch(function (error) {

        if (
            error.name ===
            "AbortError"
        ) {

            return;

        }


        console.error(
            "Pagination/Search error:",
            error
        );


        currentRequest = null;

    });

}


/* ==========================================
   AUTO HIDE NOTIFICATION
========================================== */

document.addEventListener(
    "DOMContentLoaded",
    function () {

        const notification =
            document.getElementById(
                "notification"
            );


        if (!notification) {

            return;

        }


        setTimeout(
            function () {

                notification.classList.remove(
                    "show"
                );


                setTimeout(
                    function () {

                        notification.remove();

                    },
                    350
                );

            },
            3000
        );

    }
);