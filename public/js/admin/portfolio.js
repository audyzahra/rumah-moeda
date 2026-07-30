document.addEventListener("DOMContentLoaded", function () {
    console.log("portfolio.js loaded");

    /*
    |--------------------------------------------------------------------------
    | DELETE PORTFOLIO
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(".delete-form").forEach((form) => {
        form.addEventListener("submit", function (e) {
            e.preventDefault();

            Swal.fire({
                title: "Hapus Portfolio?",
                text: "Data dapat dipulihkan karena menggunakan soft delete",
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

    /*
    |--------------------------------------------------------------------------
    | DETAIL MODAL
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(".btn-detail").forEach((button) => {
        button.addEventListener("click", function () {
            document.getElementById("detailAuthor").innerText =
                this.dataset.author;

            document.getElementById("detailTitle").innerText =
                this.dataset.title;

            document.getElementById("detailCategory").innerText =
                this.dataset.category;

            document.getElementById("detailPartner").innerText =
                this.dataset.partner;

            document.getElementById("detailDate").innerText = this.dataset.date;

            document.getElementById("detailLocation").innerText =
                this.dataset.location;

            document.getElementById("detailLatitude").innerText =
                this.dataset.lat || "-";

            document.getElementById("detailLongitude").innerText =
                this.dataset.lng || "-";

            document.getElementById("detailParticipants").innerText =
                this.dataset.participants + " Orang";

            document.getElementById("detailDescription").innerHTML = JSON.parse(
                this.dataset.description,
            );

            let media = JSON.parse(this.dataset.media);

            let html = "";

            if (media.length) {
                media.forEach((item) => {
                    if (item.type === "image") {
                        html += `

                        <div class="col-md-4">

                            <img
                            src="/storage/${item.file_path}"
                            class="img-fluid rounded">


                        </div>

                        `;
                    }

                    if (item.type === "video") {
                        let id = getYoutubeId(item.video_url);

                        if (id) {
                            html += `

                            <div class="col-md-12">

                                <iframe
                                width="100%"
                                height="300"
                                src="https://www.youtube.com/embed/${id}"
                                frameborder="0"
                                allowfullscreen>

                                </iframe>


                            </div>

                            `;
                        }
                    }
                });
            } else {
                html = `
                    <p class="text-muted">
                    Tidak ada media
                    </p>
                `;
            }

            document.getElementById("detailMedia").innerHTML = html;
        });
    });

    /*
    |--------------------------------------------------------------------------
    | GET YOUTUBE ID
    |--------------------------------------------------------------------------
    */

    window.getYoutubeId = function (url) {
        let regex =
            /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;

        let match = url.match(regex);

        return match && match[2].length === 11 ? match[2] : null;
    };

    /*
    |--------------------------------------------------------------------------
    | TAMBAH FOTO
    |--------------------------------------------------------------------------
    */

    const addImage = document.getElementById("addImage");

    if (addImage) {
        addImage.addEventListener("click", function () {
            document.getElementById("imageContainer").insertAdjacentHTML(
                "beforeend",

                `

                <div class="image-item mb-3">


                    <div class="input-group">


                        <input
                        type="file"
                        name="images[]"
                        class="form-control image-input"
                        accept="image/*">


                        <button
                        type="button"
                        class="btn btn-danger remove-image">

                            <i class="fa fa-trash"></i>

                        </button>


                    </div>


                    <div class="preview-container mt-2"></div>


                </div>


                `,
            );
        });
    }

    /*
    |--------------------------------------------------------------------------
    | PREVIEW FOTO
    |--------------------------------------------------------------------------
    */

    document.addEventListener("change", function (e) {
        if (e.target.classList.contains("image-input")) {
            let file = e.target.files[0];

            let preview = e.target
                .closest(".image-item")
                .querySelector(".preview-container");

            preview.innerHTML = "";

            if (file) {
                let reader = new FileReader();

                reader.onload = function (event) {
                    preview.innerHTML = `

                    <div class="position-relative d-inline-block">


                        <img
                        src="${event.target.result}"
                        width="150"
                        class="rounded">


                        <button
                        type="button"
                        class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-image">


                            <i class="fa fa-times"></i>


                        </button>


                    </div>


                    `;
                };

                reader.readAsDataURL(file);
            }
        }
    });

    /*
    |--------------------------------------------------------------------------
    | TAMBAH VIDEO
    |--------------------------------------------------------------------------
    */

    const addVideo = document.getElementById("addVideo");

    if (addVideo) {
        addVideo.addEventListener("click", function () {
            document.getElementById("videoContainer").insertAdjacentHTML(
                "beforeend",

                `
<div class="video-item mb-3">


    <div class="input-group">


        <input
        type="text"
        name="video_url[]"
        class="form-control video-input"
        placeholder="https://youtube.com/watch?v=">


        <button
        type="button"
        class="btn btn-danger remove-video">

            <i class="fa fa-trash"></i>

        </button>


    </div>


    <div class="video-preview mt-3"></div>


</div>
`,
            );
        });
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS INPUT FOTO / VIDEO BARU
    |--------------------------------------------------------------------------
    */

    document.addEventListener("click", function (e) {
        if (e.target.closest(".remove-image")) {
            e.target.closest(".image-item").remove();
        }

        if (e.target.closest(".remove-video")) {
            e.target.closest(".input-group").remove();
        }
    });

    /*
    |--------------------------------------------------------------------------
    | HAPUS MEDIA LAMA EDIT
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(".delete-old-media").forEach((button) => {
        button.addEventListener("click", function () {
            let id = this.dataset.id;

            let element = this.dataset.element;

            Swal.fire({
                title: "Hapus Media?",
                text: "Media akan dihapus setelah menyimpan perubahan",
                icon: "warning",

                showCancelButton: true,

                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    document
                        .getElementById("deleteMediaContainer")
                        .insertAdjacentHTML(
                            "beforeend",

                            `
                        <input
                        type="hidden"
                        name="delete_media[]"
                        value="${id}">
                        `,
                        );

                    document.getElementById(element).remove();
                }
            });
        });
    });

    // PREVIEW VIDEO YOUTUBE

    document.addEventListener("input", function (e) {
        if (e.target.classList.contains("video-input")) {
            let url = e.target.value;

            let videoId = getYoutubeId(url);

            let preview = e.target
                .closest(".video-item")
                .querySelector(".video-preview");

            preview.innerHTML = "";

            if (videoId) {
                preview.innerHTML = `

    <div class="position-relative">


        <iframe
        width="100%"
        height="300"
        src="https://www.youtube.com/embed/${videoId}"
        frameborder="0"
        allowfullscreen>
        </iframe>


        <button
        type="button"
        class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-video-preview">

            <i class="fa fa-times"></i>

        </button>


    </div>

    `;
            }
        }
    });

    document.addEventListener("click", function (e) {
        if (e.target.closest(".remove-video")) {
            e.target.closest(".video-item").remove();
        }
    });

    /* ==========================================
   SEARCH & SORT PORTFOLIO
========================================== */

    const searchPortfolio = document.getElementById("searchPortfolio");

    const sortPortfolio = document.getElementById("sortPortfolio");

    function filterPortfolio() {
        const keyword = searchPortfolio.value.toLowerCase().trim();

        const sortValue = sortPortfolio.value;

        const rows = document.querySelectorAll("#portfolioTable tr");

        rows.forEach(function (row) {
            // Lewati empty state
            if (row.querySelector(".empty-state")) return;

            const title = row.dataset.title || "";

            const category = row.dataset.category || "";

            const partner = row.dataset.partner || "";

            const author = row.dataset.author || "";

            const matchKeyword =
                title.includes(keyword) ||
                category.includes(keyword) ||
                partner.includes(keyword) ||
                author.includes(keyword);

            row.style.display = matchKeyword ? "" : "none";
        });

        // SORTING

        const tbody = document.getElementById("portfolioTable");

        const rowsArray = Array.from(tbody.querySelectorAll("tr"));

        rowsArray.sort(function (a, b) {
            const titleA = a.dataset.title || "";

            const titleB = b.dataset.title || "";

            if (sortValue === "title_asc") {
                return titleA.localeCompare(titleB);
            }

            if (sortValue === "title_desc") {
                return titleB.localeCompare(titleA);
            }

            return 0;
        });

        rowsArray.forEach((row) => {
            tbody.appendChild(row);
        });
    }

    if (searchPortfolio) {
        searchPortfolio.addEventListener("keyup", filterPortfolio);
    }

    if (sortPortfolio) {
        sortPortfolio.addEventListener("change", filterPortfolio);
    }

    // kurawal penutup
});
