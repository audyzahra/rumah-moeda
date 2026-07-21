document.getElementById("heroPreview").addEventListener("click", function () {
    document.getElementById("heroImage").click();
});
function previewHero(event) {

    const file = event.target.files[0];

    if (!file) return;

    const reader = new FileReader();

    reader.onload = function (e) {

        document.getElementById("heroPreview").innerHTML = `
            <div class="hero-preview-content">
                <img
                    src="${e.target.result}"
                    alt="Preview Hero"
                    class="hero-preview-image">
            </div>
        `;

    };

    reader.readAsDataURL(file);

}
