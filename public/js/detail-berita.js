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
