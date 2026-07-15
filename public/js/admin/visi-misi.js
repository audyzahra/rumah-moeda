function addMisi() {

    const container = document.getElementById("misiContainer");

    const item = document.createElement("div");

    item.className = "misi-item";

    item.innerHTML = `
        <textarea
            class="form-control misi-text"
            name="missions[]"
            rows="3"
            placeholder="Masukkan misi perusahaan..."
            required></textarea>

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

    const container = document.getElementById("misiContainer");

    if (container.children.length === 1) {

        alert("Minimal harus ada satu misi.");

        return;

    }

    button.closest(".misi-item").remove();

}