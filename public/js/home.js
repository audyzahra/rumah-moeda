const modal=document.getElementById('galleryModal');
const content=document.getElementById('modalContent');

function openImage(element) {
    const src = element.dataset.image;

    content.innerHTML = `<img src="${src}">`;

    modal.style.display = 'flex';
}

function openVideo(id){

    content.innerHTML=
    `<iframe
        src="https://www.youtube.com/embed/${id}?autoplay=1"
        frameborder="0"
        allowfullscreen>
    </iframe>`;

    modal.style.display='flex';

}

document.querySelector('.close-modal').onclick=function(){

    modal.style.display='none';

    content.innerHTML='';

}

modal.onclick=function(e){

    if(e.target===modal){

        modal.style.display='none';

        content.innerHTML='';

    }

}