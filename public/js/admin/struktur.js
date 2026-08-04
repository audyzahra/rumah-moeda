// =========================
// Modal Edit
// =========================
document.querySelectorAll(".btn-edit").forEach((button) => {
    button.addEventListener("click", function () {
        let id = this.dataset.id;

        document.getElementById("editName").value = this.dataset.name;

        document.getElementById("editPosition").value = this.dataset.position;

        document.getElementById("editOrder").value = this.dataset.order;

        document.getElementById("editDescription").value =
            this.dataset.description ?? "";

        document.getElementById("editForm").action = "/admin/struktur/" + id;
    });
});

// =========================
// SEARCH, FILTER & SORT
// =========================

document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("filterForm");

    if (!form) return;

    const searchInput = document.getElementById("searchInput");
    const jabatanFilter = document.getElementById("jabatanFilter");
    const sortSelect = document.getElementById("sortSelect");

    let timer;

    // Search otomatis
    if (searchInput) {

        searchInput.addEventListener("keyup", function () {

            clearTimeout(timer);

            timer = setTimeout(function () {

                form.submit();

            }, 150);

        });

    }

    // Filter Jabatan
    if (jabatanFilter) {

        jabatanFilter.addEventListener("change", function () {

            form.submit();

        });

    }

    // Sort
    if (sortSelect) {

        sortSelect.addEventListener("change", function () {

            form.submit();

        });

    }

});

// =========================
// PARENT CHILD VALIDATION
// =========================

document.addEventListener("DOMContentLoaded", function () {


    const typeSelect = document.getElementById("typeSelect");

    const parentWrapper = document.getElementById("parentWrapper");

    const parentSelect = document.getElementById("parentSelect");


    if(!typeSelect || !parentWrapper || !parentSelect) return;



    function toggleParent(){


        if(typeSelect.value === "child"){


            parentWrapper.style.display = "block";


            parentSelect.setAttribute(
                "required",
                true
            );


        }else{


            parentWrapper.style.display = "none";


            parentSelect.removeAttribute(
                "required"
            );


            parentSelect.value = "";

        }


    }



    typeSelect.addEventListener(
        "change",
        toggleParent
    );


    toggleParent();


});

// =========================
// Modal Detail
// =========================

function openDetailModal(button) {
    const photo = button.dataset.photo;
    const name = button.dataset.name;
    const position = button.dataset.position;
    const parent = button.dataset.parent;
    const description = button.dataset.description;

    document.getElementById("detailBody").innerHTML = `

    ${
        photo
            ? `<img src="${photo}" class="detail-photo">`
            : `<div class="detail-placeholder">
                <i class="fa-solid fa-user"></i>
           </div>`
    }

    <div class="detail-name">
        ${name}
    </div>

    <table class="detail-table">

        <tr>
            <td>Jabatan</td>
            <td>${position}</td>
        </tr>

        <tr>
            <td>Posisi</td>
            <td>${parent}</td>
        </tr>

    </table>

    <div class="detail-description">
        ${description ? description : "-"}
    </div>

`;

    document.getElementById("detailModal").style.display = "flex";
}

function closeDetailModal() {
    document.getElementById("detailModal").style.display = "none";
}

window.onclick = function (e) {
    const modal = document.getElementById("detailModal");

    if (e.target == modal) {
        modal.style.display = "none";
    }
};

// =========================
// SweetAlert Delete Confirm
// =========================

document.querySelectorAll(".delete-form").forEach((form) => {
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        Swal.fire({
            title: "Hapus data?",
            text: "Data struktur organisasi akan dihapus permanen!",
            icon: "warning",

            showCancelButton: true,

            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",

            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});

// =========================
// VALIDASI FOTO STRUKTUR
// =========================

document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("strukturForm");
    const photoInput = document.getElementById("photoInput");


    if (!form || !photoInput) return;


    form.addEventListener("submit", function (e) {


        if (photoInput.files.length === 0) {


            e.preventDefault();


            Swal.fire({

                title: "Foto wajib diisi",

                text: "Minimal harus menambahkan 1 foto sebelum struktur disimpan.",

                icon: "warning",

                confirmButtonText: "Mengerti",

                confirmButtonColor: "#D4AF37",

            });


            return false;

        }


    });


});



// =========================
// VALIDASI FORM TAMBAH STRUKTUR
// =========================

document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("strukturForm");

    if (!form) return;


    const fullName = document.querySelector(
        'input[name="full_name"]'
    );

    const position = document.querySelector(
        'input[name="position"]'
    );

    const typeSelect = document.getElementById(
        "typeSelect"
    );

    const parentSelect = document.getElementById(
        "parentSelect"
    );


    form.addEventListener("submit", function(e){


        // =====================
        // CEK NAMA
        // =====================

        if(fullName.value.trim() === ""){

            e.preventDefault();

            fullName.focus();

            fullName.scrollIntoView({
                behavior:"smooth",
                block:"center"
            });

            return false;
        }



        // =====================
        // CEK JABATAN
        // =====================

        if(position.value.trim() === ""){

            e.preventDefault();

            position.focus();

            position.scrollIntoView({
                behavior:"smooth",
                block:"center"
            });

            return false;
        }



        // =====================
        // CEK CHILD PARENT
        // =====================

        if(
            typeSelect.value === "child" &&
            parentSelect.value === ""
        ){

            e.preventDefault();


            parentSelect.focus();


            parentSelect.scrollIntoView({
                behavior:"smooth",
                block:"center"
            });


            return false;
        }

    });


});



// =========================
// VALIDASI FORM EDIT STRUKTUR
// =========================

document.addEventListener("DOMContentLoaded", function () {


const form = document.getElementById("strukturForm");


if(!form) return;



const fullName = document.querySelector(
    'input[name="full_name"]'
);


const position = document.querySelector(
    'input[name="position"]'
);


const typeSelect = document.getElementById(
    "typeSelect"
);


const parentSelect = document.getElementById(
    "parentSelect"
);




form.addEventListener("submit",function(e){



// =====================
// NAMA
// =====================

if(fullName.value.trim()===""){


e.preventDefault();

fullName.focus();

fullName.scrollIntoView({
    behavior:"smooth",
    block:"center"
});


return false;

}




// =====================
// JABATAN
// =====================


if(position.value.trim()===""){


e.preventDefault();


position.focus();


position.scrollIntoView({
    behavior:"smooth",
    block:"center"
});


return false;


}




// =====================
// CHILD WAJIB PARENT
// =====================


if(
typeSelect.value==="child" &&
parentSelect.value===""

){


e.preventDefault();


parentSelect.focus();


parentSelect.scrollIntoView({
behavior:"smooth",
block:"center"
});


return false;


}



});


});

