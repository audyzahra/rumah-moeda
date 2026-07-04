/**
 * ===================================================
 * Rumah Moeda Authentication Script
 * Laravel Breeze Compatible
 * ===================================================
 */

document.addEventListener("DOMContentLoaded", function () {

    /* ===========================================
       AUTO HIDE ALERT
    =========================================== */

    const alerts = document.querySelectorAll(".alert-success, .alert-danger");

    alerts.forEach(function (alert) {

        setTimeout(function () {

            alert.style.transition = "0.5s ease";
            alert.style.opacity = "0";

            setTimeout(function () {

                alert.remove();

            }, 500);

        }, 4000);

    });


    /* ===========================================
       BUTTON LOADING
    =========================================== */

    const forms = document.querySelectorAll("form");

    forms.forEach(function (form) {

        form.addEventListener("submit", function () {

            const button = form.querySelector("button[type='submit']");

            if (!button) return;

            button.disabled = true;

            // Simpan teks asli
            button.dataset.originalText = button.innerHTML;

            button.innerHTML =
                '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';

        });

    });

});


/* ===========================================
   SHOW / HIDE PASSWORD
=========================================== */

function togglePassword(inputId, eyeId) {

    const input = document.getElementById(inputId);
    const eye = document.getElementById(eyeId);

    if (input.type === "password") {

        input.type = "text";
        eye.classList.remove("fa-eye");
        eye.classList.add("fa-eye-slash");

    } else {

        input.type = "password";
        eye.classList.remove("fa-eye-slash");
        eye.classList.add("fa-eye");

    }

}


/* ===========================================
   ENTER KEY SUPPORT
=========================================== */

document.addEventListener("keydown", function (event) {

    if (event.key === "Enter") {

        const active = document.activeElement;

        if (
            active.tagName === "INPUT" &&
            active.form
        ) {

            active.form.requestSubmit();

        }

    }

});


/* ===========================================
   INPUT FOCUS EFFECT
=========================================== */

document.querySelectorAll(".input-group input").forEach(function (input) {

    input.addEventListener("focus", function () {

        this.parentElement.classList.add("active");

    });

    input.addEventListener("blur", function () {

        this.parentElement.classList.remove("active");

    });

});


/* ===========================================
   PREVENT DOUBLE CLICK BUTTON
=========================================== */

document.querySelectorAll("button").forEach(function (button) {

    button.addEventListener("click", function () {

        if (button.disabled) {

            return false;

        }

    });

});
