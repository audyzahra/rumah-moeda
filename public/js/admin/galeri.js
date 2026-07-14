"use strict";

/* ==========================================
   BASE URL
========================================== */

const isAdmin = window.location.pathname.startsWith("/admin");

const galleryBaseUrl = isAdmin
    ? "/admin/gallery"
    : "/dashboard/gallery";

/* ==========================================
   ELEMENT
========================================== */

const createModal = document.getElementById("createModal");
const editModal = document.getElementById("editModal");
const detailModal = document.getElementById("detailModal");

const searchInput = document.getElementById("searchInput");

/* ==========================================
   CREATE
========================================== */

function openCreateModal() {

    if (createModal) {
        createModal.style.display = "flex";
    }

}

function closeCreateModal() {

    if (createModal) {
        createModal.style.display = "none";
    }

}

/* ==========================================
   EDIT
========================================== */

function editGallery(button, id, title, date, description) {

    const media = JSON.parse(button.dataset.media);

    document.getElementById("edit_title").value = title;
    document.getElementById("edit_activity_date").value = date;
    document.getElementById("edit_description").value = description;

    const existingMedia = document.getElementById("existingMedia");

    existingMedia.innerHTML = "";

    if (media.length === 0) {

        existingMedia.innerHTML =
            "<p class='text-muted'>Belum ada media.</p>";

    } else {

        media.forEach(item => {

    if (item.type === "image") {

        existingMedia.innerHTML += `
            <div class="media-item">

                <img
                    src="/storage/${item.file_path}"
                    class="media-preview">

                <button
                    type="button"
                    class="btn-delete-media"
                    onclick="deleteMedia(${item.id}, this)">

                    <i class="fa-solid fa-trash"></i>

                </button>

            </div>
        `;

    } else {

        existingMedia.innerHTML += `
            <div class="media-item">

                <a
                    href="${item.video_url}"
                    target="_blank">

                    🎥 Video YouTube

                </a>

                <button
                    type="button"
                    class="btn-delete-media"
                    onclick="deleteMedia(${item.id}, this)">

                    <i class="fa-solid fa-trash"></i>

                </button>

            </div>
        `;

    }

});

    

    }

    document.getElementById("editForm").action =
        galleryBaseUrl + "/" + id;

    editModal.style.display = "flex";
}

// untuk mneutup modal edit
function closeEditModal() {

    if (editModal) {
        editModal.style.display = "none";
    }

}

// untuk tambah foto di edit
const btnEditAddPhoto = document.getElementById("btn-edit-add-photo");
const editPhotoContainer = document.getElementById("edit-photo-container");

if (btnEditAddPhoto && editPhotoContainer) {

    btnEditAddPhoto.addEventListener("click", function () {

        const div = document.createElement("div");

        div.classList.add("form-group");

        div.innerHTML = `
            <input
                type="file"
                name="images[]"
                class="form-control"
                accept=".jpg,.jpeg,.png,.webp">
        `;

        editPhotoContainer.appendChild(div);

    });

}

/* ==========================================
   TAMBAH VIDEO EDIT
========================================== */

const btnEditAddVideo = document.getElementById("btn-edit-add-video");
const editVideoContainer = document.getElementById("edit-video-container");

if (btnEditAddVideo && editVideoContainer) {

    btnEditAddVideo.addEventListener("click", function () {

        const div = document.createElement("div");

        div.classList.add("form-group");

        div.innerHTML = `
            <input
                type="url"
                name="videos[]"
                class="form-control"
                placeholder="https://www.youtube.com/watch?v=xxxx">
        `;

        editVideoContainer.appendChild(div);

    });

}

// galery untuk hapus media
function deleteMedia(id, button)
{
    if (!confirm("Hapus media ini?")) {
        return;
    }

    fetch(`/admin/gallery/media/${id}`, {

        method: "DELETE",

        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .content
        }

    })
    .then(res => res.json())
    .then(data => {

        if (data.success) {

            button
                .closest(".media-item")
                .remove();

        }

    });
}

/* ==========================================
   DETAIL
========================================== */

function showDetail(button) {

    document.getElementById("detail_title").textContent =
        button.dataset.title;

    document.getElementById("detail_date").textContent =
        button.dataset.date;

    document.getElementById("detail_description").textContent =
        button.dataset.description;

    const mediaContainer = document.getElementById("detail_media");

    mediaContainer.innerHTML = "";

    const medias = JSON.parse(button.dataset.media || "[]");

    if (medias.length === 0) {

        mediaContainer.innerHTML = `
            <p class="text-muted">
                Tidak ada media.
            </p>
        `;

    } else {

        medias.forEach(media => {

            if (media.type === "image") {

                mediaContainer.innerHTML += `
                    <div class="detail-media-item">
                        <img
                            src="/storage/${media.file_path}"
                            class="detail-image">
                    </div>
                `;

            } else if (media.type === "video") {

                const videoId = getYoutubeId(media.video_url);

                mediaContainer.innerHTML += `
                    <div class="detail-media-item">
                        <iframe
                            width="100%"
                            height="315"
                            src="https://www.youtube.com/embed/${videoId}"
                            frameborder="0"
                            allowfullscreen>
                        </iframe>
                    </div>
                `;
            }

        });

    }

    detailModal.style.display = "flex";
}

function closeDetailModal() {

    if (detailModal) {
        detailModal.style.display = "none";
    }

}

/* ==========================================
   CLICK OUTSIDE
========================================== */

window.onclick = function (event) {

    if (event.target === createModal) {

        closeCreateModal();

    }

    if (event.target === editModal) {

        closeEditModal();

    }

    if (event.target === detailModal) {

        closeDetailModal();

    }

};

/* ==========================================
   ESC CLOSE
========================================== */

document.addEventListener("keydown", function (e) {

    if (e.key === "Escape") {

        closeCreateModal();
        closeEditModal();
        closeDetailModal();

    }

});

/* ==========================================
   NOTIFICATION
========================================== */

function showNotification(message, type = "success") {

    const notification = document.getElementById("notification");

    if (!notification) return;

    let icon = "";

    switch (type) {

        case "success":
            icon = '<i class="fa-solid fa-circle-check"></i>';
            break;

        case "error":
            icon = '<i class="fa-solid fa-circle-xmark"></i>';
            break;

        default:
            icon = '<i class="fa-solid fa-circle-info"></i>';
            break;

    }

    notification.innerHTML =
        `${icon}<span>${message}</span>`;

    notification.className =
        `notification ${type} show`;

    setTimeout(() => {

        notification.classList.remove("show");

    }, 3000);

}

/* ==========================================
   FLASH MESSAGE
========================================== */

document.addEventListener("DOMContentLoaded", () => {

    const notif =
        document.getElementById("notification");

    if (!notif) return;

    if (notif.dataset.success) {

        showNotification(
            notif.dataset.success,
            "success"
        );

    }

    if (notif.dataset.error) {

        showNotification(
            notif.dataset.error,
            "error"
        );

    }

});

/* ==========================================
   TAMBAH VIDEO
========================================== */

const btnAddVideo = document.getElementById("btn-add-video");
const videoContainer = document.getElementById("video-container");

if (btnAddVideo && videoContainer) {

    btnAddVideo.addEventListener("click", function () {

        const div = document.createElement("div");

        div.classList.add("form-group");

        div.innerHTML = `
            <input
                type="url"
                name="videos[]"
                class="form-control"
                placeholder="https://www.youtube.com/watch?v=xxxx">
        `;

        videoContainer.appendChild(div);

    });

}

/* ==========================================
   TAMBAH FOTO
========================================== */

const btnAddPhoto = document.getElementById("btn-add-photo");
const photoContainer = document.getElementById("photo-container");

if (btnAddPhoto && photoContainer) {

    btnAddPhoto.addEventListener("click", function () {

        const div = document.createElement("div");

        div.classList.add("form-group");

        div.innerHTML = `
            <input
                type="file"
                name="images[]"
                class="form-control"
                accept=".jpg,.jpeg,.png,.webp">
        `;

        photoContainer.appendChild(div);

    });

}

/* ==========================================
   LIVE SEARCH
========================================== */

if (searchInput) {

    searchInput.addEventListener("input", function () {

        const keyword =
            this.value.toLowerCase().trim();

        const cards =
            document.querySelectorAll(".dokumentasi-card");

        cards.forEach(card => {

            const title =
                card.dataset.title;

            const description =
                card.dataset.description;

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

// helper js untuk yt
function getYoutubeId(url) {

    const regExp =
        /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;

    const match = url.match(regExp);

    return (match && match[2].length === 11)
        ? match[2]
        : "";
}