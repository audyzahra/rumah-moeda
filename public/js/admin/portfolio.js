document.addEventListener("DOMContentLoaded", function () {
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

            const lat = this.dataset.lat;
            const lng = this.dataset.lng;

            const mapsButton = document.getElementById("googleMapsButton");

            if (lat && lng) {
                mapsButton.href = `https://www.google.com/maps?q=${lat},${lng}`;

                mapsButton.style.display = "inline-block";
            } else {
                mapsButton.href = "#";

                mapsButton.style.display = "none";
            }

            let detailMap = null;
            let detailMarker = null;

            if (lat && lng) {
                const latitude = parseFloat(lat);
                const longitude = parseFloat(lng);

                setTimeout(() => {
                    if (detailMap) {
                        detailMap.remove();
                    }

                    detailMap = L.map("detail-map").setView(
                        [latitude, longitude],
                        15,
                    );

                    L.tileLayer(
                        "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
                        {
                            attribution: "© OpenStreetMap",
                        },
                    ).addTo(detailMap);

                    detailMarker = L.marker([latitude, longitude]).addTo(
                        detailMap,
                    );

                    detailMap.invalidateSize();
                }, 300);

                mapsButton.href = `https://www.google.com/maps?q=${latitude},${longitude}`;

                mapsButton.style.display = "block";
            } else {
                mapsButton.style.display = "none";

                if (detailMap) {
                    detailMap.remove();

                    detailMap = null;
                }
            }

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

    /*
|--------------------------------------------------------------------------
| LOCATION SEARCH MAPS
|--------------------------------------------------------------------------
*/

    let defaultLat = -6.917464;
    let defaultLng = 107.619123;

    const latitudeInput = document.getElementById("latitude");
    const longitudeInput = document.getElementById("longitude");

    if (
        latitudeInput &&
        longitudeInput &&
        latitudeInput.value &&
        longitudeInput.value
    ) {
        defaultLat = parseFloat(latitudeInput.value);
        defaultLng = parseFloat(longitudeInput.value);
    }

    const mapElement = document.getElementById("map");

    let map = null;
    let marker = null;

    // ===============================
    // CREATE / EDIT MAP
    // ===============================

    if (mapElement) {
        map = L.map("map").setView([defaultLat, defaultLng], 13);

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: "© OpenStreetMap",
        }).addTo(map);

        marker = L.marker([defaultLat, defaultLng]).addTo(map);
    }

    // ===============================
    // LOCATION SEARCH
    // ===============================

    const input = document.getElementById("location");
    const result = document.getElementById("location-result");

    const latitude = document.getElementById("latitude");
    const longitude = document.getElementById("longitude");

    let timer;
    let controller;

    if (input) {
        input.addEventListener("input", function () {
            clearTimeout(timer);

            let keyword = this.value.trim();

            if (keyword.length < 1) {
                result.innerHTML = "";

                return;
            }

            timer = setTimeout(() => {
                searchLocation(keyword);
            }, 200);
        });
    }

    async function searchLocation(keyword) {
        if (!result) {
            return;
        }

        result.innerHTML = `
        <div class="list-group-item text-muted">
            Mencari lokasi...
        </div>
    `;

        if (controller) {
            controller.abort();
        }

        controller = new AbortController();

        try {
            let response = await fetch(
                `/admin/location-search?keyword=${encodeURIComponent(keyword)}`,
                {
                    signal: controller.signal,
                },
            );

            let data = await response.json();

            result.innerHTML = "";

            data.forEach((place) => {
                let address = place.address;

                let detail = [
                    address.village,
                    address.town,
                    address.city,
                    address.county,
                    address.state,
                    address.country,
                ]
                    .filter((item) => item)
                    .join(", ");

                result.innerHTML += `

            <a href="#"
            class="list-group-item list-group-item-action location-item"

            data-name="${place.name}"

            data-lat="${place.lat}"

            data-lon="${place.lon}">


                <strong>
                    ${place.name}
                </strong>


                <br>


                <small>
                    ${detail}
                </small>


            </a>

            `;
            });
        } catch (error) {
            if (error.name !== "AbortError") {
                console.log(error);
            }
        }
    }

    // ===============================
    // PILIH HASIL LOKASI
    // ===============================

    document.addEventListener("click", function (e) {
        let item = e.target.closest(".location-item");

        if (!item) {
            return;
        }

        e.preventDefault();

        const lat = item.dataset.lat;

        const lon = item.dataset.lon;

        const name = item.dataset.name;

        if (input) {
            input.value = name;
        }

        if (latitude) {
            latitude.value = lat;
        }

        if (longitude) {
            longitude.value = lon;
        }

        if (result) {
            result.innerHTML = "";
        }

        // hanya jalan jika map create/edit ada

        if (map) {
            if (marker) {
                marker.remove();
            }

            marker = L.marker([lat, lon]).addTo(map);

            map.setView([lat, lon], 16);
        }
    });

    // ===============================
    // LOAD DATA EDIT
    // ===============================

    if (map && latitude && longitude && latitude.value && longitude.value) {
        map.setView([latitude.value, longitude.value], 16);

        if (marker) {
            marker.remove();
        }

        marker = L.marker([latitude.value, longitude.value]).addTo(map);
    }

    /*
|--------------------------------------------------------------------------
| AUTO SEARCH PORTFOLIO
|--------------------------------------------------------------------------
*/

    const searchPortfolio = document.getElementById("searchPortfolio");

    const sortPortfolio = document.getElementById("sortPortfolio");

    const portfolioFilter = document.getElementById("portfolioFilter");

    let portfolioSearchTimer;

    if (searchPortfolio) {
        searchPortfolio.addEventListener("input", function () {
            clearTimeout(portfolioSearchTimer);

            portfolioSearchTimer = setTimeout(() => {
                portfolioFilter.submit();
            }, 50);
        });
    }

    if (sortPortfolio) {
        sortPortfolio.addEventListener("change", function () {
            portfolioFilter.submit();
        });
    }

    // kurawal penutup
});
