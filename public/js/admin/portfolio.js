document.querySelectorAll(".delete-form").forEach((form) => {
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        Swal.fire({
            title: "Hapus Portfolio?",
            text: "Data yang dihapus dapat dipulihkan karena menggunakan soft delete",
            icon: "warning",

            showCancelButton: true,

            confirmButtonText: "Hapus",

            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});

// UNTUK MODAL DETAIL DI HALAMAN INDEX
document.addEventListener("DOMContentLoaded", function () {
    const detailButtons = document.querySelectorAll(".btn-detail");

    detailButtons.forEach((button) => {
        button.addEventListener("click", function () {
            document.getElementById("detailTitle").innerText =
                this.dataset.title;

            document.getElementById("detailCategory").innerText =
                this.dataset.category;

            document.getElementById("detailPartner").innerText =
                this.dataset.partner;

            document.getElementById("detailDate").innerText = this.dataset.date;

            document.getElementById("detailLocation").innerText =
                this.dataset.location;

            document.getElementById("detailParticipants").innerText =
                this.dataset.participants + " Orang";

            document.getElementById("detailDescription").innerHTML = JSON.parse(
                this.dataset.description,
            );
        });
    });
});
