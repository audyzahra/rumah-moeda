document.addEventListener("DOMContentLoaded", function () {

    initLightbox();
    initScrollAnimation();
    initSmoothScroll();
    initActiveMenu();
    initUserDropdown();
    initMobileMenu();

});

/* ==========================
   LIGHTBOX GALERI
========================== */

function initLightbox() {

    const galleryImages = document.querySelectorAll(".gallery-item img");
    const lightbox = document.getElementById("lightbox");
    const lightboxImg = document.getElementById("lightbox-img");
    const closeBtn = document.querySelector(".close");

    if (!galleryImages.length || !lightbox || !lightboxImg) {
        return;
    }

    galleryImages.forEach(image => {

        image.addEventListener("click", function () {

            lightbox.style.display = "flex";
            lightboxImg.src = this.src;
            lightboxImg.alt = this.alt;

            document.body.style.overflow = "hidden";

        });

    });

    if (closeBtn) {

        closeBtn.addEventListener("click", closeLightbox);

    }

    lightbox.addEventListener("click", function (e) {

        if (e.target === lightbox) {

            closeLightbox();

        }

    });

    document.addEventListener("keydown", function (e) {

        if (e.key === "Escape") {

            closeLightbox();

        }

    });

    function closeLightbox() {

        lightbox.style.display = "none";
        document.body.style.overflow = "auto";

    }

}

/* ==========================
   SCROLL ANIMATION
========================== */

function initScrollAnimation() {

    const sections = document.querySelectorAll("section");

    if (!sections.length) return;

    const observer = new IntersectionObserver(

        (entries) => {

            entries.forEach(entry => {

                if (entry.isIntersecting) {

                    entry.target.classList.add("show");

                }

            });

        },

        {
            threshold: 0.15
        }

    );

    sections.forEach(section => {

        observer.observe(section);

    });

}

/* ==========================
   SMOOTH SCROLL
========================== */

function initSmoothScroll() {

    const links = document.querySelectorAll('a[href^="#"]');

    links.forEach(link => {

        link.addEventListener("click", function (e) {

            const target = document.querySelector(this.getAttribute("href"));

            if (!target) return;

            e.preventDefault();

            target.scrollIntoView({

                behavior: "smooth",
                block: "start"

            });

        });

    });

}

/* ==========================
   ACTIVE MENU
========================== */

function initActiveMenu() {

    const sections = document.querySelectorAll("section[id]");
    const navLinks = document.querySelectorAll(".nav-menu a");

    if (!sections.length || !navLinks.length) return;

    window.addEventListener("scroll", () => {

        let current = "";

        sections.forEach(section => {

            const sectionTop = section.offsetTop - 120;
            const sectionHeight = section.clientHeight;

            if (
                window.scrollY >= sectionTop &&
                window.scrollY < sectionTop + sectionHeight
            ) {
                current = section.getAttribute("id");
            }

        });

        navLinks.forEach(link => {

            link.classList.remove("active");

            const href = link.getAttribute("href");

            if (href === "#" + current) {

                link.classList.add("active");

            }

        });

    });

}

/* ==========================
   USER DROPDOWN
========================== */

function initUserDropdown() {

    const userBtn = document.getElementById("userMenuBtn");
    const dropdown = document.getElementById("userDropdown");

    if (!userBtn || !dropdown) return;

    userBtn.addEventListener("click", function (e) {

        e.preventDefault();
        e.stopPropagation();

        dropdown.classList.toggle("show");

    });

    dropdown.addEventListener("click", function (e) {

        e.stopPropagation();

    });

    document.addEventListener("click", function () {

        dropdown.classList.remove("show");

    });

}

/* ==========================
   MOBILE MENU
========================== */

function initMobileMenu() {

    const menuToggle = document.querySelector(".menu-toggle");
    const navMenu = document.querySelector(".nav-menu");

    console.log(menuToggle);
    console.log(navMenu);

    if (!menuToggle || !navMenu) return;

    menuToggle.onclick = function () {

        console.log("klik");

        navMenu.classList.toggle("active");

    };

}