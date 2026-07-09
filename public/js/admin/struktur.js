// =========================
// Modal Edit
// =========================
document.querySelectorAll('.btn-edit').forEach(button => {

    button.addEventListener('click', function(){

        let id = this.dataset.id;

        document.getElementById('editName').value =
            this.dataset.name;

        document.getElementById('editPosition').value =
            this.dataset.position;

        document.getElementById('editOrder').value =
            this.dataset.order;

        document.getElementById('editDescription').value =
            this.dataset.description ?? '';

        document.getElementById('editForm').action =
            "/admin/struktur/" + id;

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

        cards.forEach(card => {

            const name = card.dataset.name;
            const position = card.dataset.position;

            if (
                name.includes(keyword) ||
                position.includes(keyword)
            ) {
                card.style.display = "";
            } else {
                card.style.display = "none";
            }

        });

    });

}

// =========================
// Notification
// =========================
function showNotification(message, type = "success") {

    const notification = document.getElementById("notification");

    let icon = "";

    if(type === "success"){
        icon = '<i class="fa-solid fa-circle-check"></i>';
    }else if(type === "error"){
        icon = '<i class="fa-solid fa-circle-xmark"></i>';
    }else{
        icon = '<i class="fa-solid fa-circle-info"></i>';
    }

    notification.innerHTML = `${icon}<span>${message}</span>`;
    notification.className = `notification ${type} show`;

    setTimeout(() => {
        notification.classList.remove("show");
    }, 3000);
}

// =========================
// Flash Message Laravel
// =========================
document.addEventListener("DOMContentLoaded", () => {

    const notif = document.getElementById("notification");

    if (!notif) return;

    const success = notif.dataset.success;
    const error = notif.dataset.error;

    if (success) {
        showNotification(success, "success");
    }

    if (error) {
        showNotification(error, "error");
    }

});