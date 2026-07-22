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
// Search
// =========================
// =========================
// Live Search
// =========================
const searchInput = document.getElementById("searchInput");

if (searchInput) {
    searchInput.addEventListener("input", function () {
        const keyword = this.value.toLowerCase().trim();

        const cards = document.querySelectorAll(".struktur-card");

        cards.forEach((card) => {
            const name = card.dataset.name;
            const position = card.dataset.position;

            if (name.includes(keyword) || position.includes(keyword)) {
                card.style.display = "";
            } else {
                card.style.display = "none";
            }
        });
    });
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
