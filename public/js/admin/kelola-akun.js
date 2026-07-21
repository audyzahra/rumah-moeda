/* ==========================
   Show / Hide Password
========================== */

document.addEventListener('DOMContentLoaded', function () {

    // Toggle Password
    document.querySelectorAll('.toggle-password').forEach(icon => {

        icon.addEventListener('click', function () {

            const input = document.getElementById(this.dataset.target);

            if (input.type === 'password') {

                input.type = 'text';
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');

            } else {

                input.type = 'password';
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');

            }

        });

    });

    // Konfirmasi Hapus Akun
    document.querySelectorAll('.delete-form').forEach(form => {

        form.addEventListener('submit', function (e) {

            e.preventDefault();

            Swal.fire({
                title: 'Hapus Akun?',
                text: 'Akun yang dihapus tidak dapat dikembalikan.',
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