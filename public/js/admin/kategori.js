/* ==========================================
   SEARCH
========================================== */

const searchInput = document.getElementById("searchInput");
const filterForm = document.getElementById("filterForm");

if (searchInput && filterForm) {

    let timer;

    searchInput.addEventListener("input", function () {

        clearTimeout(timer);

        timer = setTimeout(function () {

            filterForm.submit();

        }, 150);

    });

}


// ===========================
// Delete
// ===========================

function deleteKategori(id) {

    Swal.fire({
        title: 'Hapus Kategori?',
        text: 'Kategori yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true

    }).then((result) => {

        if (result.isConfirmed) {

            const form = document.createElement('form');

            form.method = 'POST';
            form.action = `/admin/categories/${id}`;

            form.innerHTML = `
                <input type="hidden" name="_token"
                    value="${document.querySelector('meta[name="csrf-token"]').content}">
                <input type="hidden" name="_method" value="DELETE">
            `;

            document.body.appendChild(form);
            form.submit();

        }

    });

}
