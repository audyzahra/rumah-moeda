document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchInput');
    const rows = document.querySelectorAll('.kategori-table tbody tr');

    searchInput.addEventListener('keyup', function () {

        const keyword = this.value.toLowerCase();

        rows.forEach(row => {

            const nama = row.cells[1]?.textContent.toLowerCase() || '';

            row.style.display = nama.includes(keyword) ? '' : 'none';

        });

    });

});


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
