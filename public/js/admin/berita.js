// =============================================
// BERITA.JS
// Admin Rumah Moeda
// Rewrite Version
// =============================================

"use strict";

/* ==========================================
   ELEMENT
========================================== */

const formModal = document.getElementById("formModal");
const detailModal = document.getElementById("detailModal");
const deleteModal = document.getElementById("deleteModal");

const beritaForm = document.getElementById("beritaForm");

const preview = document.getElementById("preview");

const deleteForm = document.getElementById("deleteForm");

const searchInput = document.getElementById("searchInput");

const categoryFilter = document.getElementById("categoryFilter");

let currentNews = null;


/* ==========================================
   OPEN MODAL
========================================== */

function openModal(modal){

    if(!modal) return;

    modal.classList.add("show");

}

function closeModal(modal){

    if(!modal) return;

    modal.classList.remove("show");

}


/* ==========================================
   CLOSE MODAL
========================================== */

function closeFormModal(){

    closeModal(formModal);

}

function closeDetailModal(){

    closeModal(detailModal);

}

function closeDeleteModal(){

    closeModal(deleteModal);

}


/* ==========================================
   CLICK OUTSIDE MODAL
========================================== */

window.addEventListener("click",function(e){

    if(e.target===formModal){

        closeFormModal();

    }

    if(e.target===detailModal){

        closeDetailModal();

    }

    if(e.target===deleteModal){

        closeDeleteModal();

    }

});


/* ==========================================
   ESC CLOSE
========================================== */

document.addEventListener("keydown",function(e){

    if(e.key==="Escape"){

        closeFormModal();

        closeDetailModal();

        closeDeleteModal();

    }

});


/* ==========================================
   PREVIEW IMAGE
========================================== */

function previewImage(event){

    const file = event.target.files[0];

    if(!file){

        preview.src="";

        preview.style.display="none";

        return;

    }

    const reader=new FileReader();

    reader.onload=function(e){

        preview.src=e.target.result;

        preview.style.display="block";

    }

    reader.readAsDataURL(file);

}


/* ==========================================
   RESET FORM
========================================== */

function resetBeritaForm(){

    beritaForm.reset();

    currentNews=null;

    preview.src="";

    preview.style.display="none";

    document.getElementById("berita_id").value="";

    const method=document.getElementById("formMethod");

    if(method){

        method.remove();

    }

    beritaForm.action="/admin/berita";

    document.getElementById("formModalTitle").innerHTML="Tambah Berita";

}
/* ==========================================
   TAMBAH BERITA
========================================== */

function openTambahModal(){

    resetBeritaForm();

    beritaForm.action="/admin/berita";

    document.getElementById("formModalTitle").innerHTML="Tambah Berita";

    openModal(formModal);

}


/* ==========================================
   EDIT BERITA
========================================== */

function openEditModal(news){

    resetBeritaForm();

    currentNews=news;

    beritaForm.action="/admin/berita/"+news.id;

    document.getElementById("formModalTitle").innerHTML="Edit Berita";

    // Tambahkan method PUT
    const method=document.createElement("input");

    method.type="hidden";

    method.name="_method";

    method.value="PUT";

    method.id="formMethod";

    beritaForm.appendChild(method);

    // Isi Form
    document.getElementById("title").value=
        news.title ?? "";

    document.getElementById("content").value=
        news.content ?? "";

    document.getElementById("category_id").value=
        news.category_id ?? "";

    if(news.publish_date){

        document.getElementById("publish_date").value=
            news.publish_date.substring(0,16);

    }

    // Thumbnail Lama
    if(news.thumbnail){

        preview.src="/"+news.thumbnail;

        preview.style.display="block";

    }

    openModal(formModal);

}


/* ==========================================
   ALIAS
========================================== */

/*
Blade sekarang memakai

onclick="editBerita(...)"

jadi kita arahkan ke openEditModal()
*/

function editBerita(news){

    openEditModal(news);

}


/* ==========================================
   SUBMIT FORM
========================================== */

if(beritaForm){

    beritaForm.addEventListener("submit",function(){

        const button=
            beritaForm.querySelector("button[type='submit']");

        if(button){

            button.disabled=true;

            button.innerHTML=
            '<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan...';

        }

    });

}
/* ==========================================
   DETAIL BERITA
========================================== */

function showDetail(news){

    currentNews = news;

    // Thumbnail
    document.getElementById("detailThumbnail").src =
        news.thumbnail
            ? "/" + news.thumbnail
            : "/assets/no-image.png";

    // Judul
    document.getElementById("detailTitle").textContent =
        news.title ?? "-";

    // Kategori
    document.getElementById("detailCategory").textContent =
        news.category ?? "-";

    // Author
    document.getElementById("detailAuthor").textContent =
        news.author ?? "-";

    // Tanggal
    document.getElementById("detailDate").textContent =
        news.publish_date ?? "-";

    // Isi
    document.getElementById("detailContent").innerHTML =
        news.content ?? "-";

    openModal(detailModal);

}


/* ==========================================
   HAPUS BERITA
========================================== */

function deleteBerita(id){

    deleteForm.action = "/admin/berita/" + id;

    openModal(deleteModal);

}


/* ==========================================
   SUBMIT DELETE
========================================== */

if(deleteForm){

    deleteForm.addEventListener("submit",function(){

        const btn =
            deleteForm.querySelector("button[type='submit']");

        if(btn){

            btn.disabled = true;

            btn.innerHTML =
            '<i class="fa-solid fa-spinner fa-spin"></i> Menghapus...';

        }

    });

}
/* ==========================================
   SEARCH & FILTER BERITA
========================================== */

function filterBerita() {

    const keyword = searchInput.value.toLowerCase().trim();

    const kategori = categoryFilter.value;

    const cards = document.querySelectorAll(".berita-card");

    cards.forEach(function(card){

        const title = card.dataset.title || "";

        const content = card.dataset.content || "";

        const category = card.dataset.category || "";

        const cocokKeyword =
            title.includes(keyword) ||
            content.includes(keyword);

        const cocokKategori =
            kategori === "" ||
            category === kategori;

        if(cocokKeyword && cocokKategori){

            card.style.display = "";

        }else{

            card.style.display = "none";

        }

    });

}

if(searchInput){

    searchInput.addEventListener("keyup", filterBerita);

}

if(categoryFilter){

    categoryFilter.addEventListener("change", filterBerita);

}
