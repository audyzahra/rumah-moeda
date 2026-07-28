document.addEventListener('DOMContentLoaded', () => {

    const content = document.querySelector('.artikel-content');

    if (!content) return;

    const children = [...content.children];
    let gallery = null;

    children.forEach(element => {

        if (element.tagName === 'IMG') {

            if (!gallery) {
                gallery = document.createElement('div');
                gallery.className = 'image-gallery';
                element.parentNode.insertBefore(gallery, element);
            }

            gallery.appendChild(element);

        } else {

            gallery = null;

        }

    });

});
// ===========================
// IMAGE LIGHTBOX
// ===========================

const lightbox = document.getElementById('lightbox');
const lightboxImage = document.getElementById('lightboxImage');
const closeBtn = document.querySelector('.lightbox-close');

document.querySelectorAll('.artikel-content img, .hero-image img').forEach(img => {

    img.addEventListener('click', () => {

        lightbox.classList.add('show');

        lightboxImage.src = img.src;

    });

});

closeBtn.addEventListener('click', () => {

    lightbox.classList.remove('show');

});

lightbox.addEventListener('click', e => {

    if (e.target === lightbox) {

        lightbox.classList.remove('show');

    }

});

document.addEventListener('keydown', e => {

    if (e.key === 'Escape') {

        lightbox.classList.remove('show');

    }

});
