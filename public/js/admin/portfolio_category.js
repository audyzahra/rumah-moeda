document.addEventListener('DOMContentLoaded', function () {

    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');


    if (!nameInput || !slugInput) {
        return;
    }


    nameInput.addEventListener('input', function () {


        let name = this.value.trim();


        if(name === ''){
            slugInput.value = '';
            return;
        }


        fetch('/admin/portfolio-categories/generate-slug/' + encodeURIComponent(name))
            .then(response => response.json())
            .then(data => {

                slugInput.value = data.slug;

            })
            .catch(error => {

                console.error('Error generate slug:', error);

            });


    });


});


// UNTUK DELETE


document.addEventListener('DOMContentLoaded', function () {


    const deleteForms = document.querySelectorAll('.delete-form');


    deleteForms.forEach(form => {


        form.addEventListener('submit', function(e){


            e.preventDefault();


            Swal.fire({

                title: 'Hapus kategori?',
                text: "Data yang sudah dihapus tidak dapat dikembalikan!",
                icon: 'warning',

                showCancelButton: true,

                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',

                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'


            }).then((result)=>{


                if(result.isConfirmed){

                    form.submit();

                }


            });


        });


    });


});

/* ==========================================
   SEARCH & SORT (LARAVEL)
========================================== */

document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("categoryFilterForm");
    const searchInput = document.getElementById("searchInput");
    const sortSelect = document.getElementById("sortSelect");

    if (searchInput && form) {

        let timer;

        searchInput.addEventListener("input", function () {

            clearTimeout(timer);

            timer = setTimeout(function () {

                form.submit();

            }, 150);

        });

    }

    if (sortSelect && form) {

        sortSelect.addEventListener("change", function () {

            form.submit();

        });

    }

});