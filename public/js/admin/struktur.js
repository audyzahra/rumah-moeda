// =========================
// Modal Edit
// =========================
document.querySelectorAll(".btn-edit").forEach((button) => {
    button.addEventListener("click", function () {
        let id = this.dataset.id;

        document.getElementById("editName").value = this.dataset.name;

        document.getElementById("editPosition").value = this.dataset.position;

        document.getElementById("editOrder").value = this.dataset.order;

        document.getElementById("editDescription").value =
            this.dataset.description ?? "";

        document.getElementById("editForm").action = "/admin/struktur/" + id;
    });
});

// =========================
// Search & Sort Struktur
// =========================

const searchInput = document.getElementById("searchInput");
const jabatanFilter = document.getElementById("jabatanFilter");
const sortSelect = document.getElementById("sortSelect");

function filterStruktur() {
    const keyword = searchInput.value.toLowerCase().trim();

    const selectedJabatan = jabatanFilter.value.toLowerCase().trim();

    const sortValue = sortSelect.value;

    const tbody = document.getElementById("strukturTable");

    const rows = Array.from(tbody.querySelectorAll("tr"));

    // SEARCH

    rows.forEach(function (row) {
        // skip empty row
        if (row.querySelector("td[colspan]")) {
            return;
        }

        const name = row.dataset.name || "";

        const position = row.dataset.position || "";

        const matchSearch =
            name.includes(keyword) || position.includes(keyword);

        const matchJabatan =
            selectedJabatan === "" || position === selectedJabatan;

        const match = matchSearch && matchJabatan;

        row.style.display = match ? "" : "none";
    });

    // SORTING

    rows.sort(function (a, b) {
        const nameA = a.dataset.name || "";

        const nameB = b.dataset.name || "";

        if (sortValue === "nama_asc") {
            return nameA.localeCompare(nameB);
        }

        if (sortValue === "nama_desc") {
            return nameB.localeCompare(nameA);
        }

        return 0;
    });

    rows.forEach(function (row) {
        tbody.appendChild(row);
    });
}

if (searchInput) {
    searchInput.addEventListener("keyup", filterStruktur);
}

if (sortSelect) {
    sortSelect.addEventListener("change", filterStruktur);

    if (jabatanFilter) {
        jabatanFilter.addEventListener("change", filterStruktur);
    }

    if (sortSelect) {
        sortSelect.addEventListener("change", filterStruktur);
    }
}

// =========================
// Parent / Child
// =========================
document.addEventListener("DOMContentLoaded", function () {
    const typeSelect = document.getElementById("typeSelect");
    const parentWrapper = document.getElementById("parentWrapper");

    if (!typeSelect || !parentWrapper) return;

    const parentSelect = parentWrapper.querySelector("select");

    function toggleParent() {
        if (typeSelect.value === "child") {
            parentWrapper.style.display = "block";
        } else {
            parentWrapper.style.display = "none";
            parentSelect.value = "";
        }
    }

    typeSelect.addEventListener("change", toggleParent);

    toggleParent();
});

// =========================
// Modal Detail
// =========================

function openDetailModal(button) {
    const photo = button.dataset.photo;
    const name = button.dataset.name;
    const position = button.dataset.position;
    const parent = button.dataset.parent;
    const description = button.dataset.description;

    document.getElementById("detailBody").innerHTML = `

    ${
        photo
            ? `<img src="${photo}" class="detail-photo">`
            : `<div class="detail-placeholder">
                <i class="fa-solid fa-user"></i>
           </div>`
    }

    <div class="detail-name">
        ${name}
    </div>

    <table class="detail-table">

        <tr>
            <td>Jabatan</td>
            <td>${position}</td>
        </tr>

        <tr>
            <td>Posisi</td>
            <td>${parent}</td>
        </tr>

    </table>

    <div class="detail-description">
        ${description ? description : "-"}
    </div>

`;

    document.getElementById("detailModal").style.display = "flex";
}

function closeDetailModal() {
    document.getElementById("detailModal").style.display = "none";
}

window.onclick = function (e) {
    const modal = document.getElementById("detailModal");

    if (e.target == modal) {
        modal.style.display = "none";
    }
};

// =========================
// SweetAlert Delete Confirm
// =========================

document.querySelectorAll(".delete-form").forEach((form) => {
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        Swal.fire({
            title: "Hapus data?",
            text: "Data struktur organisasi akan dihapus permanen!",
            icon: "warning",

            showCancelButton: true,

            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",

            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
