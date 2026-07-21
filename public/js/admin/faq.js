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