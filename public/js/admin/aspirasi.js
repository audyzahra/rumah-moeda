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
let searchTimer = null;


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
   CLOSE DETAIL MODAL
========================================== */

function closeDetailModal() {

    closeModal(detailModal);

}


/* ==========================================
   CLICK OUTSIDE MODAL
========================================== */

window.addEventListener("click", function (e) {

    if (e.target === detailModal) {

        closeDetailModal();

    }

});


/* ==========================================
   ESC CLOSE MODAL
========================================== */

document.addEventListener("keydown", function (e) {

    if (e.key === "Escape") {

        closeDetailModal();

    }

});


/* ==========================================
   CHECKBOX
========================================== */

function toggleAllCheckbox() {

    if (!checkAll) return;

    const rows = document.querySelectorAll(".row-checkbox");

    rows.forEach(function (item) {

        item.checked = checkAll.checked;

    });

    updateBulkDeleteButton();

}


/* ==========================================
   UPDATE CHECK ALL
========================================== */

function updateCheckAll() {

    if (!checkAll) return;

    const rows = document.querySelectorAll(".row-checkbox");

    const checked = document.querySelectorAll(
        ".row-checkbox:checked"
    );

    checkAll.checked =
        rows.length > 0 &&
        rows.length === checked.length;

}


/* ==========================================
   UPDATE BULK DELETE BUTTON
========================================== */

function updateBulkDeleteButton() {

    if (!bulkDeleteBtn) return;

    const total = document.querySelectorAll(
        ".row-checkbox:checked"
    ).length;

    bulkDeleteBtn.disabled = total === 0;

}


/* ==========================================
   DETAIL ASPIRASI
========================================== */

function showDetail(button) {

    if (!button || !detailBody) return;

    const data = {

        id: button.dataset.id,

        name: button.dataset.name,

        email: button.dataset.email,

        phone: button.dataset.phone,

        message: button.dataset.message,

        status: button.dataset.status,

        created_at: button.dataset.created

    };


    /* ==========================================
       ISI MODAL
    ========================================== */

    detailBody.innerHTML = `

        <div class="detail-item">

            <div class="detail-label">
                Nama
            </div>

            <div class="detail-value">
                ${data.name}
            </div>

        </div>


        <div class="detail-item">

            <div class="detail-label">
                Email
            </div>

            <div class="detail-value">
                ${data.email}
            </div>

        </div>


        <div class="detail-item">

            <div class="detail-label">
                No HP
            </div>

            <div class="detail-value">
                ${data.phone || "-"}
            </div>

        </div>


        <div class="detail-item">

            <div class="detail-label">
                Status
            </div>

            <div class="detail-value">
                ${
                    data.status == "1"
                        ? "Dibaca"
                        : "Belum Dibaca"
                }
            </div>

        </div>


        <div class="detail-item">

            <div class="detail-label">
                Tanggal
            </div>

            <div class="detail-value">
                ${data.created_at}
            </div>

        </div>


        <div class="detail-item">

            <div class="detail-label">
                Pesan
            </div>

            <div class="detail-value">
                ${data.message}
            </div>

        </div>

    `;


    openModal(detailModal);


    /* ==========================================
       OTOMATIS TANDAI DIBACA
    ========================================== */

    if (data.status == "0") {

        const csrfToken = document.querySelector(
            'meta[name="csrf-token"]'
        );

        if (!csrfToken) {

            console.error(
                "CSRF token tidak ditemukan."
            );

            return;

        }


        fetch(`/admin/messages/${data.id}/read`, {

            method: "PUT",

            headers: {

                "X-CSRF-TOKEN":
                    csrfToken.content,

                "X-Requested-With":
                    "XMLHttpRequest",

                "Accept":
                    "application/json",

                "Content-Type":
                    "application/json"

            }

        })

        .then(function (response) {

            if (!response.ok) {

                throw new Error(
                    "Gagal mengubah status."
                );

            }

            return response.json();

        })

        .then(function () {

            button.dataset.status = "1";


            /* ==================================
               UPDATE STATUS MODAL
            ================================== */

            const modalStatus =
                detailBody.querySelector(
                    ".detail-item:nth-child(4) .detail-value"
                );

            if (modalStatus) {

                modalStatus.textContent = "Dibaca";

            }


            /* ==================================
               UPDATE STATUS TABLE
            ================================== */

            const row = button.closest("tr");

            if (row) {

                row.dataset.status = "1";

                const badge =
                    row.querySelector(".status-badge");

                if (badge) {

                    badge.classList.remove("baru");

                    badge.classList.add("dibaca");

                    badge.textContent = "Dibaca";

                }

            }

        })

        .catch(function (error) {

            console.error(
                "Error mark as read:",
                error
            );

        });

    }

}


/* ==========================================
   GET SELECTED IDS
========================================== */

function getSelectedIds() {

    return [
        ...document.querySelectorAll(
            ".row-checkbox:checked"
        )
    ].map(function (item) {

        return item.value;

    });

}


/* ==========================================
   CHECKBOX CHANGE
========================================== */

document.addEventListener(
    "change",
    function (e) {

        if (
            e.target.classList.contains(
                "row-checkbox"
            )
        ) {

            updateCheckAll();

            updateBulkDeleteButton();

        }

    }
);


/* ==========================================
   HAPUS ASPIRASI
========================================== */

function deleteAspirasi(id) {

    Swal.fire({

        title: "Hapus Aspirasi?",

        text:
            "Aspirasi yang dihapus tidak dapat dikembalikan.",

        icon: "warning",

        showCancelButton: true,

        confirmButtonColor: "#dc3545",

        cancelButtonColor: "#6c757d",

        confirmButtonText:
            '<i class="fa-solid fa-trash"></i> Ya, Hapus',

        cancelButtonText: "Batal",

        reverseButtons: true

    })

    .then(function (result) {

        if (!result.isConfirmed) {
            return;
        }


        const csrfToken = document.querySelector(
            'meta[name="csrf-token"]'
        );

        if (!csrfToken) {

            Swal.fire({

                icon: "error",

                title: "Error",

                text:
                    "CSRF token tidak ditemukan."

            });

            return;

        }


        const form =
            document.createElement("form");


        form.method = "POST";

        form.action =
            `/admin/messages/${id}`;


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
   BULK DELETE
========================================== */

function bulkDelete() {

    const ids = getSelectedIds();


    if (ids.length === 0) {

        Swal.fire({

            icon: "warning",

            title: "Belum Ada Pilihan",

            text:
                "Pilih minimal satu aspirasi."

        });

        return;

    }


    Swal.fire({

        title:
            `Hapus ${ids.length} aspirasi?`,

        text:
            "Data yang dihapus tidak dapat dikembalikan.",

        icon: "warning",

        showCancelButton: true,

        confirmButtonColor: "#dc3545",

        cancelButtonColor: "#6c757d",

        confirmButtonText:
            '<i class="fa-solid fa-trash"></i> Ya, Hapus',

        cancelButtonText: "Batal",

        reverseButtons: true

    })

    .then(function (result) {

        if (!result.isConfirmed) {
            return;
        }


        const csrfToken = document.querySelector(
            'meta[name="csrf-token"]'
        );

        if (!csrfToken) {

            Swal.fire({

                icon: "error",

                title: "Error",

                text:
                    "CSRF token tidak ditemukan."

            });

            return;

        }


        const form =
            document.createElement("form");


        form.method = "POST";

        form.action =
            aspirasiBaseUrl;


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

    });

}


/* ==========================================
   BULK BUTTON
========================================== */

if (bulkDeleteBtn) {

    bulkDeleteBtn.addEventListener(
        "click",
        bulkDelete
    );

    updateBulkDeleteButton();

}


/* ==========================================
   LIVE SEARCH
========================================== */

if (searchInput) {

    searchInput.addEventListener(
        "input",
        function () {

            clearTimeout(searchTimer);


            /*
            |--------------------------------------------------------------------------
            | Tunggu 400ms setelah user berhenti mengetik
            |--------------------------------------------------------------------------
            */

            searchTimer = setTimeout(
                function () {

                    applyServerFilter();

                },
                400
            );

        }
    );

}


/* ==========================================
   STATUS FILTER
========================================== */

if (filterStatus) {

    filterStatus.addEventListener(
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


    const status =
        filterStatus
            ? filterStatus.value
            : "";


    const url =
        new URL(
            window.location.href
        );


    /* ==========================================
       SEARCH PARAMETER
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
       STATUS PARAMETER
    ========================================== */

    if (status !== "") {

        url.searchParams.set(
            "status",
            status
        );

    } else {

        url.searchParams.delete(
            "status"
        );

    }


    /* ==========================================
       RESET PAGE
    ========================================== */

    url.searchParams.delete("page");


    /* ==========================================
       AJAX REQUEST
    ========================================== */

    fetch(

        url.toString(),

        {

            method: "GET",

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
                "Gagal mengambil data."
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


        /* ==========================================
           UPDATE TABLE BODY
        ========================================== */

        const newBody =
            doc.querySelector(
                "#aspirasiBody"
            );


        const currentBody =
            document.querySelector(
                "#aspirasiBody"
            );


        if (
            newBody &&
            currentBody
        ) {

            currentBody.innerHTML =
                newBody.innerHTML;

        }


        /* ==========================================
           UPDATE PAGINATION
        ========================================== */

        const newPagination =
            doc.querySelector(
                ".custom-section"
            );


        const currentPagination =
            document.querySelector(
                ".custom-section"
            );


        if (
            newPagination &&
            currentPagination
        ) {

            currentPagination.innerHTML =
                newPagination.innerHTML;

        }


        /* ==========================================
           UPDATE URL
        ========================================== */

        window.history.replaceState(

            {},

            "",

            url.toString()

        );


        /* ==========================================
           RESET CHECKBOX
        ========================================== */

        if (checkAll) {

            checkAll.checked = false;

        }


        updateBulkDeleteButton();

    })

    .catch(function (error) {

        console.error(
            "Search error:",
            error
        );

    });

}