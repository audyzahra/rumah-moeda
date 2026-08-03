function addMisi() {

    const container = document.getElementById("misiContainer");

    const item = document.createElement("div");

    item.className = "misi-item";

    item.innerHTML = `
        <textarea
            class="form-control misi-text"
            name="missions[]"
            rows="3">
        </textarea>

        <button
            type="button"
            class="btn-remove-misi"
            onclick="removeMisi(this)">

            <i class="fa-solid fa-trash"></i>

        </button>
    `;

    container.appendChild(item);

    item.scrollIntoView({
        behavior: "smooth",
        block: "center"
    });

}

function removeMisi(button) {

    const items = document.querySelectorAll('.misi-item');

    if (items.length <= 1) {

        Swal.fire({
            icon: 'warning',
            title: 'Tidak dapat menghapus',
            text: 'Minimal harus ada satu misi.',
            confirmButtonText: 'OK'
        });

        return;
    }

    button.closest('.misi-item').remove();
}
