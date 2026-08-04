document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.delete-form').forEach(form => {

        form.addEventListener('submit', function (e) {

            e.preventDefault();

            Swal.fire({
                title: 'Hapus FAQ?',
                text: 'FAQ yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                reverseButtons: true
            }).then((result) => {

                if (result.isConfirmed) {

                    form.submit();

                }

            });

        });

    });

});

// UNTUK MODAL DETAIL

document.addEventListener("DOMContentLoaded", function(){


    const modal = document.getElementById("faqModal");

    const closeBtn = document.getElementById("closeFaqModal");

    const question = document.getElementById("detailQuestion");

    const answer = document.getElementById("detailAnswer");


    const detailButtons = document.querySelectorAll(".btn-detail");



    detailButtons.forEach(button => {


        button.addEventListener("click", function(){


            question.innerHTML = this.dataset.question;


            answer.innerHTML = this.dataset.answer;


            modal.classList.add("active");


        });


    });



    closeBtn.addEventListener("click", function(){


        modal.classList.remove("active");


    });



    modal.addEventListener("click", function(e){


        if(e.target === modal){

            modal.classList.remove("active");

        }


    });



});

// =========================
// SEARCH & SORT FAQ
// =========================

document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("faqFilter");
    const search = document.getElementById("searchInput");
    const sort = document.getElementById("sortFaq");

    // Hentikan jika salah satu elemen tidak ditemukan
    if (!form || !search || !sort) return;

    let timer;

    // Search otomatis saat mengetik
    search.addEventListener("keyup", function () {

        clearTimeout(timer);

        timer = setTimeout(function () {

            form.submit();

        }, 300);

    });

    // Sort otomatis saat berubah
    sort.addEventListener("change", function () {

        form.submit();

    });

});