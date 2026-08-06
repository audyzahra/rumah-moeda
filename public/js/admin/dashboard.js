// ==============================
// BERANDA.JS
// Dashboard Admin
// ==============================

document.addEventListener('DOMContentLoaded', () => {

    // ==============================
    // Efek angka naik (Counter)
    // ==============================

    const counters = document.querySelectorAll(".card h2");

    counters.forEach(counter => {

        const target = parseInt(counter.innerText.replace(/\./g, ""));
        let current = 0;

        const increment = Math.ceil(target / 80);

        const updateCounter = () => {

            current += increment;

            if (current >= target) {

                current = target;

            }

            counter.innerText = current.toLocaleString("id-ID");

            if (current < target) {

                requestAnimationFrame(updateCounter);

            }

        };

        updateCounter();

    });

    // ==============================
    // Highlight Sidebar
    // ==============================

    const menuItems = document.querySelectorAll(".menu li");

    menuItems.forEach(item => {

        item.addEventListener("click", () => {

            menuItems.forEach(i => i.classList.remove("active"));

            item.classList.add("active");

        });

    });

    // ==============================
    // Hover Efek Card
    // ==============================

    const cards = document.querySelectorAll(".card");

    cards.forEach(card => {

        card.addEventListener("mouseenter", () => {

            card.style.transform = "translateY(-8px)";
            card.style.transition = ".3s";

        });

        card.addEventListener("mouseleave", () => {

            card.style.transform = "translateY(0)";

        });

    });

    // ==============================
    // Animasi Table
    // ==============================

    const rows = document.querySelectorAll("tbody tr");

    rows.forEach((row, index) => {

        row.style.opacity = "0";
        row.style.transform = "translateY(20px)";

        setTimeout(() => {

            row.style.transition = ".4s ease";
            row.style.opacity = "1";
            row.style.transform = "translateY(0)";

        }, index * 120);

    });

    // ==============================
    // Notifikasi
    // ==============================

    function showNotification(message, type = 'info') {
        const notification = document.getElementById('notification');
        if (!notification) return;

        notification.textContent = message;
        notification.className = `notification ${type} show`;

        setTimeout(() => {
            notification.classList.remove('show');
        }, 3000);
    }

    // ==============================
    // Logout
    // ==============================

    window.logout = function () {
        if (confirm('Apakah Anda yakin ingin logout?')) {
            localStorage.removeItem('api_token');
            window.location.href = 'login.html';
        }
    };

    // ==============================
    // Jam Digital
    // ==============================

    const clock = document.createElement('span');
    clock.id = 'clock';

    clock.style.cssText = `
    display:flex;
    align-items:center;
    gap:5px;
    font-size:14px;
    color:#666;
`;

    clock.innerHTML = `<i class="fa-regular fa-clock"></i> 00:00:00`;

    clock.style.cssText = `
    font-size:14px;
    color:#666;
    display:flex;
    align-items:center;
    white-space:nowrap;
`;

    const topbarRight = document.querySelector('.topbar-right');
    const profile = document.querySelector('.profile');

    if (topbarRight && profile) {
        topbarRight.insertBefore(clock, profile);
    }

    function updateClock() {
        if (!clock) return;
        const now = new Date();
        const jam = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        clock.innerHTML = `<i class="fa-regular fa-clock"></i> ${jam}`;
    }

    setInterval(updateClock, 1000);
    updateClock();
    // ==============================
    // WEBSITE PREVIEW
    // ==============================

    const btnPreview = document.getElementById("btnPreview");
    const previewPanel = document.getElementById("previewPanel");
    const btnClosePreview = document.getElementById("btnClosePreview");
    const btnFullscreen = document.getElementById("btnFullscreen");
    const previewFrame = document.getElementById("previewFrame");

    if (btnPreview) {

        btnPreview.onclick = function () {

            previewPanel.classList.add("show");

            previewFrame.src = "/";

        }

    }

    if (btnClosePreview) {

        btnClosePreview.onclick = function () {

            previewPanel.classList.remove("show");

        }

    }

    if (btnFullscreen) {

        btnFullscreen.onclick = function () {

            window.open("/", "_blank");

        }

    }
    // ==============================
    // DRAG PREVIEW WINDOW
    // ==============================

    const panel = document.getElementById("previewPanel");
    const header = panel?.querySelector(".preview-header");

    if (panel && header) {

        let isDragging = false;

        let offsetX = 0;
        let offsetY = 0;

        header.addEventListener("mousedown", function (e) {

            isDragging = true;

            const rect = panel.getBoundingClientRect();

            offsetX = e.clientX - rect.left;
            offsetY = e.clientY - rect.top;

            panel.style.right = "auto";

            panel.style.left = rect.left + "px";

            panel.style.top = rect.top + "px";

            document.body.style.userSelect = "none";

        });

        document.addEventListener("mousemove", function (e) {

            if (!isDragging) return;

            panel.style.left = (e.clientX - offsetX) + "px";

            panel.style.top = (e.clientY - offsetY) + "px";

        });

        document.addEventListener("mouseup", function () {

            isDragging = false;

            document.body.style.userSelect = "";

        });

    }
    // ==============================
    // RESIZE WINDOW
    // ==============================

    const handles = document.querySelectorAll(".resize");

    handles.forEach(handle => {

        handle.addEventListener("mousedown", startResize);

    });

    function startResize(e) {

        e.preventDefault();

        const direction = [...e.target.classList]
            .find(c => c.startsWith("resize-"))
            .replace("resize-", "");

        const startX = e.clientX;
        const startY = e.clientY;

        const startWidth = panel.offsetWidth;
        const startHeight = panel.offsetHeight;

        const startLeft = panel.offsetLeft;
        const startTop = panel.offsetTop;

        function resize(ev) {

            let width = startWidth;
            let height = startHeight;

            let left = startLeft;
            let top = startTop;

            const dx = ev.clientX - startX;
            const dy = ev.clientY - startY;

            if (direction.includes("e")) {

                width = startWidth + dx;

            }

            if (direction.includes("s")) {

                height = startHeight + dy;

            }

            if (direction.includes("w")) {

                width = startWidth - dx;

                left = startLeft + dx;

            }

            if (direction.includes("n")) {

                height = startHeight - dy;

                top = startTop + dy;

            }

            if (width > 500) {

                panel.style.width = width + "px";

                panel.style.left = left + "px";

            }

            if (height > 350) {

                panel.style.height = height + "px";

                panel.style.top = top + "px";

            }

        }

        function stop() {

            document.removeEventListener("mousemove", resize);

            document.removeEventListener("mouseup", stop);

        }

        document.addEventListener("mousemove", resize);

        document.addEventListener("mouseup", stop);

    }
    let maximized = false;

    header.addEventListener("dblclick", function () {

        if (!maximized) {

            panel.dataset.left = panel.style.left;
            panel.dataset.top = panel.style.top;
            panel.dataset.width = panel.style.width;
            panel.dataset.height = panel.style.height;

            panel.style.left = "15px";
            panel.style.top = "15px";
            panel.style.width = "calc(100vw - 30px)";
            panel.style.height = "calc(100vh - 30px)";

        } else {

            panel.style.left = panel.dataset.left;
            panel.style.top = panel.dataset.top;
            panel.style.width = panel.dataset.width;
            panel.style.height = panel.dataset.height;

        }

        maximized = !maximized;

    });
    console.log('📊 Dashboard berhasil dimuat!');
    console.log('👋 Selamat datang, Administrator');
});
