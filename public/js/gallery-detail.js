console.log('Gallery Detail JS Loaded');
const lightbox = document.getElementById('lightbox');
const lightboxImage = document.getElementById('lightboxImage');
const closeBtn = document.querySelector('.lightbox-close');

document.querySelectorAll('.preview-image').forEach(img => {

    img.addEventListener('click', () => {

        lightboxImage.src = img.src;

        lightbox.classList.add('show');

        document.body.style.overflow = 'hidden';

    });

});

closeBtn.addEventListener('click', closeLightbox);

lightbox.addEventListener('click', function(e){

    if(e.target === lightbox){

        closeLightbox();

    }

});

document.addEventListener('keydown', function(e){

    if(e.key === 'Escape'){

        closeLightbox();

    }

});

function closeLightbox(){

    lightbox.classList.remove('show');

    document.body.style.overflow = '';

}
