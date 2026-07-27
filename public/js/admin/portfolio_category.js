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

// SEARCH DAN SORT
document.addEventListener('DOMContentLoaded', () => {

    const searchInput = document.getElementById('searchInput');
    const sortSelect = document.getElementById('sortSelect');

    if (!searchInput || !sortSelect) return;

    const tbody = document.querySelector('.portfolio-category-table tbody');

    function renderTable() {

        let rows = [...tbody.querySelectorAll('tr')];

        // Abaikan row kosong
        rows = rows.filter(row => !row.querySelector('.empty-data'));

        // SEARCH
        const keyword = searchInput.value.toLowerCase();

        rows.forEach(row => {

            const name = row.dataset.name;

            row.style.display = name.includes(keyword) ? '' : 'none';

        });

        // SORT
        rows.sort((a, b) => {

            switch (sortSelect.value) {

                case 'az':
                    return a.dataset.name.localeCompare(b.dataset.name);

                case 'za':
                    return b.dataset.name.localeCompare(a.dataset.name);

                case 'oldest':
                    return Number(a.dataset.date) - Number(b.dataset.date);

                default: // newest
                    return Number(b.dataset.date) - Number(a.dataset.date);

            }

        });

        rows.forEach(row => tbody.appendChild(row));

        // Update nomor
        let no = 1;

        rows.forEach(row => {

            if (row.style.display !== 'none') {

                row.cells[0].textContent = no++;

            }

        });

    }

    searchInput.addEventListener('input', renderTable);

    sortSelect.addEventListener('change', renderTable);

});