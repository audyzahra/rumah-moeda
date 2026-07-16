/* ==========================
   Show / Hide Password
========================== */

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
function openDeleteModal(action) {

    document.getElementById('deleteForm').action = action;

    document.getElementById('deleteModal').classList.add('show');

}

function closeDeleteModal() {

    document.getElementById('deleteModal').classList.remove('show');

}

window.addEventListener('click', function (e) {

    const modal = document.getElementById('deleteModal');

    if (e.target === modal) {

        closeDeleteModal();

    }

});