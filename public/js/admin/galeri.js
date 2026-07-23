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

/* ==========================================
   TAMBAH FOTO HALAMAN EDIT
========================================== */
const btnEditAddPhoto = document.getElementById("btn-edit-add-photo");
const editPhotoContainer = document.getElementById("edit-photo-container");

if (btnEditAddPhoto && editPhotoContainer) {

    btnEditAddPhoto.addEventListener("click", function () {

        const div = document.createElement("div");

        div.classList.add("form-group", "photo-item");

        div.innerHTML = `
            <div class="input-with-action">

                <input
                    type="file"
                    name="images[]"
                    class="form-control"
                    accept=".jpg,.jpeg,.png,.webp">

                <button
                    type="button"
                    class="btn-remove">

                    <i class="fa-solid fa-trash"></i>

                </button>

            </div>
        `;

        editPhotoContainer.appendChild(div);

    });

}

/* ==========================================
   TAMBAH VIDEO HALAMAN EDIT
========================================== */

const btnEditAddVideo = document.getElementById("btn-edit-add-video");
const editVideoContainer = document.getElementById("edit-video-container");

if (btnEditAddVideo && editVideoContainer) {

    btnEditAddVideo.addEventListener("click", function () {

        const div = document.createElement("div");

        div.classList.add("form-group", "video-item");

        div.innerHTML = `
            <div class="input-with-action">

                <input
                    type="url"
                    name="videos[]"
                    class="form-control"
                    placeholder="https://www.youtube.com/watch?v=xxxx">

                <button
                    type="button"
                    class="btn-remove">

                    <i class="fa-solid fa-trash"></i>

                </button>

            </div>
        `;

        editVideoContainer.appendChild(div);

    });

}

/* ==========================================
   UNTUK HAPUS MEDIA PADA FORM
========================================== */
function deleteMedia(id, button)
{

    Swal.fire({

        title: 'Apakah yakin?',
        text: 'Media yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',

        showCancelButton: true,

        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',

        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6'


    }).then((result)=>{


        if(result.isConfirmed){


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


                if(data.success){


                    button
                    .closest(".media-item")
                    .remove();


                    Swal.fire({

                        icon:'success',
                        title:'Berhasil',
                        text:'Media berhasil dihapus',
                        timer:1500,
                        showConfirmButton:false

                    });


                }


            });


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
                            class="detail-photo">
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
   TAMBAH VIDEO HALAMAN CREATE
========================================== */

const btnAddVideo = document.getElementById("btn-add-video");
const videoContainer = document.getElementById("video-container");

if (btnAddVideo && videoContainer) {

    btnAddVideo.addEventListener("click", function () {

        const div = document.createElement("div");

        div.classList.add("form-group", "video-item");

        div.innerHTML = `
            <div class="input-with-action">

                <input
                    type="url"
                    name="videos[]"
                    class="form-control"
                    placeholder="https://www.youtube.com/watch?v=xxxx">

                <button type="button" class="btn-remove">
                    <i class="fa-solid fa-trash"></i>
                </button>

            </div>
        `;

        videoContainer.appendChild(div);

    });

}

/* ==========================================
   TAMBAH FOTO HALAMAN CREATE
========================================== */

const btnAddPhoto = document.getElementById("btn-add-photo");
const photoContainer = document.getElementById("photo-container");

if (btnAddPhoto && photoContainer) {

    btnAddPhoto.addEventListener("click", function () {

        const div = document.createElement("div");

        div.classList.add("form-group", "photo-item");

        div.innerHTML = `
            <div class="input-with-action">

                <input
                    type="file"
                    name="images[]"
                    class="form-control"
                    accept=".jpg,.jpeg,.png,.webp">

                <button type="button" class="btn-remove">
                    <i class="fa-solid fa-trash"></i>
                </button>

            </div>
        `;

        photoContainer.appendChild(div);

    });

}

/* ==========================================
   HAPUS INPUT FOTO / VIDEO
========================================== */

document.addEventListener("click", function (e) {

    const btn = e.target.closest(".btn-remove");

    if (!btn) return;

    const item = btn.closest(".photo-item, .video-item");

    if (item) {
        item.remove();
    }

});

/* ==========================================
   LIVE SEARCH TABLE
========================================== */

if (searchInput) {

    searchInput.addEventListener("input", function () {

        const keyword = this.value.toLowerCase().trim();

        const rows = document.querySelectorAll(".gallery-table tbody tr");

        rows.forEach(row => {

            // Skip baris "Belum ada dokumentasi"
            if (row.querySelector(".empty-table")) return;

            const text = row.innerText.toLowerCase();

            if (text.includes(keyword)) {

                row.style.display = "";

            } else {

                row.style.display = "none";

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


/* ==========================================
   DELETE GALLERY CONFIRMATION
========================================== */

document.addEventListener("DOMContentLoaded", function(){


    document.querySelectorAll(".btn-delete")
    .forEach(button => {


        button.addEventListener("click", function(e){


            e.preventDefault();


            let form = this.closest("form");


            Swal.fire({

                title:"Apakah yakin?",
                text:"Data galeri akan dihapus permanen!",
                icon:"warning",

                showCancelButton:true,

                confirmButtonText:"Ya, hapus!",
                cancelButtonText:"Batal",

                confirmButtonColor:"#d33",
                cancelButtonColor:"#3085d6"


            }).then((result)=>{


                if(result.isConfirmed){

                    form.submit();

                }


            });


        });


    });


});


// loasing saat simpan
document.addEventListener("DOMContentLoaded", function(){


    const form = document.querySelector(
        'form[action*="gallery"]'
    );


    if(form){


        form.addEventListener("submit", function(){


            const button =
                this.querySelector(".btn-simpan");


            if(button){


                button.disabled = true;

                button.innerHTML =
                `
                <i class="fa-solid fa-spinner fa-spin"></i>
                Menyimpan...
                `;


            }


        });


    }


});