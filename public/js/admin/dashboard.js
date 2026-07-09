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

    window.logout = function() {
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
    clock.style.cssText = 'font-size:14px;color:#666;margin-left:15px;';
    
    const topbar = document.querySelector('.topbar');

if (topbar) {
    clock.style.marginLeft = "0";
    clock.style.marginRight = "10px";
    topbar.appendChild(clock);
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

    console.log('📊 Dashboard berhasil dimuat!');
    console.log('👋 Selamat datang, Administrator');
});