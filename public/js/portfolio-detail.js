/* ==========================================
   PORTFOLIO DETAIL
========================================== */

document.addEventListener("DOMContentLoaded", () => {

    initScrollAnimation();

    initGalleryLightbox();

});


/* ==========================================
   SCROLL ANIMATION
========================================== */

function initScrollAnimation() {

    const items = document.querySelectorAll(
        ".portfolio-cover, \
         .portfolio-information, \
         .portfolio-description, \
         .portfolio-gallery, \
         .portfolio-video, \
         .related-card"
    );

    if (!items.length) return;

    const observer = new IntersectionObserver((entries) => {

        entries.forEach(entry => {

            if (entry.isIntersecting) {

                entry.target.classList.add("show");

            }

        });

    }, {

        threshold:0.15

    });

    items.forEach(item => {

        observer.observe(item);

    });

}


/* ==========================================
   GALLERY LIGHTBOX
========================================== */

function initGalleryLightbox() {

    const items = document.querySelectorAll(".gallery-item");

    if (!items.length) return;

    const overlay = document.createElement("div");

    overlay.className = "gallery-lightbox";

    overlay.innerHTML = `
        <button class="gallery-close" type="button">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <img class="lightbox-image" src="" alt="">
    `;

    document.body.appendChild(overlay);

    const lightboxImage = overlay.querySelector(".lightbox-image");
    const closeButton = overlay.querySelector(".gallery-close");

    items.forEach(item => {

        item.addEventListener("click", function (e) {

            e.preventDefault(); // supaya tidak membuka file jpg

            const img = item.querySelector("img");

            if (!img) return;

            lightboxImage.src = img.src;

            overlay.classList.add("active");

            document.body.style.overflow = "hidden";

        });

    });

    function closeLightbox() {

        overlay.classList.remove("active");

        document.body.style.overflow = "";

    }

    closeButton.addEventListener("click", closeLightbox);

    overlay.addEventListener("click", function (e) {

        if (e.target === overlay) {

            closeLightbox();

        }

    });

    document.addEventListener("keydown", function (e) {

        if (e.key === "Escape") {

            closeLightbox();

        }

    });

}