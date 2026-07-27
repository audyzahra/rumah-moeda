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

        item.classList.add("hidden");

        observer.observe(item);

    });

}


/* ==========================================
   GALLERY LIGHTBOX
========================================== */

function initGalleryLightbox() {

    const images = document.querySelectorAll(".gallery-grid img");

    if (!images.length) return;

    const overlay = document.createElement("div");

    overlay.className = "portfolio-lightbox";

    overlay.innerHTML = `
        <span class="lightbox-close">&times;</span>
        <img class="lightbox-image" src="" alt="">
    `;

    document.body.appendChild(overlay);

    const lightboxImage = overlay.querySelector(".lightbox-image");

    const closeButton = overlay.querySelector(".lightbox-close");

    images.forEach(image => {

        image.addEventListener("click", () => {

            lightboxImage.src = image.src;

            overlay.classList.add("active");

            document.body.style.overflow = "hidden";

        });

    });

    function closeLightbox() {

        overlay.classList.remove("active");

        document.body.style.overflow = "";

    }

    closeButton.addEventListener("click", closeLightbox);

    overlay.addEventListener("click", (event) => {

        if (event.target === overlay) {

            closeLightbox();

        }

    });

    document.addEventListener("keydown", (event) => {

        if (event.key === "Escape") {

            closeLightbox();

        }

    });

}
