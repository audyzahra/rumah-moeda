document.querySelectorAll('.btn-edit').forEach(button => {

    button.addEventListener('click', function(){

        let id = this.dataset.id;


        document.getElementById('editName').value =
            this.dataset.name;


        document.getElementById('editPosition').value =
            this.dataset.position;


        document.getElementById('editOrder').value =
            this.dataset.order;


        document.getElementById('editDescription').value =
            this.dataset.description ?? '';


        document.getElementById('editForm').action =
            "/admin/struktur/" + id;

    });

});

setTimeout(() => {
    const alert = document.querySelector('.alert-success');

    if (alert) {
        alert.style.transition = "all .5s ease";
        alert.style.opacity = "0";
        alert.style.transform = "translateY(-10px)";

        setTimeout(() => {
            alert.remove();
        }, 500);
    }
}, 3000);

// Untuk bagian Search
const searchInput = document.getElementById('searchInput');
const filterForm = document.getElementById('filterForm');

let timer;

searchInput.addEventListener('input', function () {

    clearTimeout(timer);

    timer = setTimeout(() => {
        filterForm.submit();
    }, 400); // tunggu 400ms setelah berhenti mengetik

});


