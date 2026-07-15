// Klik area upload
const logoPreview = document.getElementById("logoPreview");
const logoInput = document.getElementById("formLogo");

if (logoPreview && logoInput) {

    logoPreview.addEventListener("click", function () {
        logoInput.click();
    });

}

// Preview logo
function previewLogo(event) {

    const file = event.target.files[0];

    if (!file) return;

    const reader = new FileReader();

    reader.onload = function (e) {

        document.getElementById("logoPreview").innerHTML = `
            <img src="${e.target.result}"
                 style="
                    max-width:100%;
                    max-height:150px;
                    object-fit:contain;
                 ">
        `;

    };

    reader.readAsDataURL(file);

}