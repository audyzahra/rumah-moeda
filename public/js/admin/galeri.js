function editGallery(id, title, date, description)
{
    document.getElementById('edit_title').value = title;
    document.getElementById('edit_activity_date').value = date;
    document.getElementById('edit_description').value = description;

    document.getElementById('editForm').action =
        '/admin/gallery/' + id;

    document.getElementById('editModal').style.display = 'flex';
}

function closeEditModal()
{
    document.getElementById('editModal').style.display = 'none';
}

function openCreateModal(){
    document.getElementById('createModal').style.display='flex';
}

function closeCreateModal(){
    document.getElementById('createModal').style.display='none';
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

function showDetail(button) {

    console.log(button.dataset);

    document.getElementById('detail_photo').src = button.dataset.photo;
    document.getElementById('detail_title').textContent = button.dataset.title;
    document.getElementById('detail_date').textContent = button.dataset.date;
    document.getElementById('detail_description').textContent = button.dataset.description;

    document.getElementById('detailModal').style.display = 'flex';
}
function closeDetailModal() {
    document.getElementById('detailModal').style.display = 'none';
}

/* ==========================================
   LIVE SEARCH
========================================== */

const searchInput = document.getElementById("searchInput");

if (searchInput) {

    searchInput.addEventListener("input", function () {

        const keyword = this.value.toLowerCase().trim();

        const cards = document.querySelectorAll(".dokumentasi-card");

        cards.forEach(card => {

            const title = card.dataset.title;
            const description = card.dataset.description;

            if (
                title.includes(keyword) ||
                description.includes(keyword)
            ) {

                card.style.display = "";

            } else {

                card.style.display = "none";

            }

        });

    });

}