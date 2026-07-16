// ==============================
// SIDEBAR.JS
// Fungsi Global Sidebar Responsif
// ==============================

// ===== TOGGLE SIDEBAR =====
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    if (sidebar) {
        sidebar.classList.toggle('open');
    }
    if (overlay) {
        overlay.classList.toggle('show');
    }

    // Mencegah scroll body saat sidebar terbuka
    if (sidebar && sidebar.classList.contains('open')) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
}

// ===== CLOSE SIDEBAR =====
function closeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    if (sidebar) {
        sidebar.classList.remove('open');
    }
    if (overlay) {
        overlay.classList.remove('show');
    }

    // Kembalikan scroll body
    document.body.style.overflow = '';
}

// ===== LOGOUT =====
function logout() {
    if (confirm('Apakah Anda yakin ingin logout?')) {
        localStorage.removeItem('api_token');
        window.location.href = 'login.html';
    }
}

// ===== HIGHLIGHT ACTIVE MENU =====
function highlightActiveMenu() {
    const currentPage = window.location.pathname.split('/').pop().replace('.html', '');
    const menuItems = document.querySelectorAll('.menu li');

    menuItems.forEach(item => {
        const page = item.getAttribute('data-page');
        if (page === currentPage) {
            item.classList.add('active');
        } else {
            item.classList.remove('active');
        }
    });
}

// ===== UPDATE BADGE =====
function updateBadge(page, count) {
    const badgeMap = {
        'aspirasi': 'badgeAspirasi',
        'berita': 'badgeBerita',
        'dokumentasi': 'badgeDokumentasi',
        'struktur': 'badgeStruktur',
        'mitra': 'badgeMitra',
        'faq': 'badgeFaq'
    };

    const badgeId = badgeMap[page];
    if (badgeId) {
        const badge = document.getElementById(badgeId);
        if (badge) {
            badge.textContent = count;
            if (count === 0 || !count) {
                badge.style.display = 'none';
            } else {
                badge.style.display = 'inline-block';
            }
        }
    }
}

// ============================================
// INISIALISASI SIDEBAR
// ============================================

document.addEventListener('DOMContentLoaded', function () {
    // Highlight menu aktif
    highlightActiveMenu();

    // ===== TUTUP SIDEBAR SAAT KLIK DI LUAR =====
    document.addEventListener('click', function (event) {
        const sidebar = document.getElementById('sidebar');
        const hamburger = document.querySelector('.hamburger-btn');
        const overlay = document.getElementById('overlay');

        // Hanya di mobile (≤ 768px)
        if (window.innerWidth <= 768) {
            if (sidebar && sidebar.classList.contains('open')) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickHamburger = hamburger && hamburger.contains(event.target);
                const isClickOverlay = overlay && overlay.contains(event.target);

                if (!isClickInsideSidebar && !isClickHamburger && !isClickOverlay) {
                    closeSidebar();
                }
            }
        }
    });

    // ===== TUTUP SIDEBAR SAAT RESIZE KE DESKTOP =====
    let resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            if (window.innerWidth > 768) {
                closeSidebar();
            }
        }, 200);
    });

    // ===== KEYBOARD SHORTCUT: ESC UNTUK TUTUP SIDEBAR =====
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeSidebar();
        }
    });

    // ===== SWIPE GESTURE UNTUK MOBILE =====
    let touchStartX = 0;
    let touchEndX = 0;

    document.addEventListener('touchstart', function (e) {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    document.addEventListener('touchend', function (e) {
        touchEndX = e.changedTouches[0].screenX;
        const sidebar = document.getElementById('sidebar');

        // Swipe dari kiri ke kanan untuk buka sidebar (hanya jika di tepi kiri)
        if (touchStartX < 30 && touchEndX - touchStartX > 80) {
            if (sidebar && !sidebar.classList.contains('open')) {
                toggleSidebar();
            }
        }

        // Swipe dari kanan ke kiri untuk tutup sidebar
        if (touchStartX - touchEndX > 80) {
            if (sidebar && sidebar.classList.contains('open')) {
                closeSidebar();
            }
        }
    }, { passive: true });

    // ===== CEK UKURAN LAYAR SAAT LOAD =====
    function checkScreenSize() {
        const sidebar = document.getElementById('sidebar');
        if (window.innerWidth > 768 && sidebar) {
            sidebar.classList.remove('open');
            document.body.style.overflow = '';
        }
    }
    checkScreenSize();

    console.log('📱 Sidebar responsif siap digunakan!');
    // ==============================
    // DROPDOWN MENU BERITA
    // ==============================

    const beritaDropdown = document.querySelector(".submenu-toggle");

    if (beritaDropdown) {

        beritaDropdown.addEventListener("click", function (e) {

            e.preventDefault();

            const parent = this.closest(".has-submenu");

            parent.classList.toggle("open");

        });

    }

    // ==============================
    // DROPDOWN MENU PENGATURAN
    // ==============================

    const settingDropdown = document.querySelector(".submenu-toggle-setting");

    if (settingDropdown) {

        settingDropdown.addEventListener("click", function (e) {

            e.preventDefault();

            const parent = this.closest(".has-submenu-setting");

            parent.classList.toggle("open");

        });

    }

    if (window.location.pathname.includes('/admin/pengaturan')) {

        document
            .querySelector('.has-submenu-setting')
            ?.classList.add('open');

    }
    console.log('ℹ️ Gunakan tombol hamburger di mobile untuk membuka sidebar');
    console.log('ℹ️ Swipe dari kiri ke kanan untuk buka sidebar di mobile');
});
// ========================================
// REALTIME SIDEBAR NOTIFICATION
// ========================================

function loadSidebarNotification(){

    fetch(window.sidebarNotificationUrl)

        .then(response => response.json())

        .then(data => {

            const badge = document.getElementById("badgeAspirasi");

            if(!badge) return;

            badge.textContent = data.count;

            if(data.count > 0){

                badge.classList.remove("badge-zero");

            }else{

                badge.classList.add("badge-zero");

            }

        })

        .catch(error => console.log(error));

}

loadSidebarNotification();

setInterval(loadSidebarNotification,5000);
