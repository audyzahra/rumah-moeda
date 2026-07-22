// ==============================
// MITRA.JS
// Manajemen Mitra
// ==============================

/* ==========================================
   SEARCH & FILTER MITRA
========================================== */

const searchInput = document.getElementById("searchInput");
const websiteFilter = document.getElementById("websiteFilter");
const sortFilter = document.getElementById("sortFilter");
const filterForm = document.querySelector(".filter-form");
const refreshBtn = document.getElementById("refreshBtn");

if (searchInput) {

    let timeout;

    searchInput.addEventListener("keyup", function () {

        clearTimeout(timeout);

        timeout = setTimeout(() => {

            filterForm.submit();

        }, 300);

    });

}

if (websiteFilter) {

    websiteFilter.addEventListener("change", function () {

        filterForm.submit();

    });

}

if (sortFilter) {

    sortFilter.addEventListener("change", function () {

        filterForm.submit();

    });

}

if (refreshBtn) {

    refreshBtn.addEventListener("click", function () {

        window.location.href = "/admin/partners";

    });

}

/* ==========================================
   DETAIL MODAL
========================================== */

document.addEventListener('DOMContentLoaded', function () {

    const detailModal = document.getElementById('detailModal');

    if (detailModal) {

        detailModal.addEventListener('show.bs.modal', function (event) {

            const button = event.relatedTarget;

            const name = button.getAttribute('data-name');
            const website = button.getAttribute('data-website');
            const description = button.getAttribute('data-description');
            const order = button.getAttribute('data-order');
            const logo = button.getAttribute('data-logo');

            const body = document.getElementById('detailBody');

            const logoUrl = logo ? `${window.storageUrl}/${logo}` : null;

            body.innerHTML = `
                <div class="text-center mb-3">
                    ${
                        logoUrl
                        ? `<img src="${logoUrl}" alt="${name}" class="detail-logo" style="max-width:200px;max-height:150px;object-fit:contain;">`
                        : `<div class="detail-logo-placeholder" style="width:150px;height:100px;background:#e5e7eb;border-radius:10px;display:flex;align-items:center;justify-content:center;margin:0 auto;">
                                <i class="fa-solid fa-building" style="font-size:40px;color:#94a3b8;"></i>
                           </div>`
                    }
                </div>

                <div class="detail-item">
                    <span class="detail-label">Nama Mitra</span>
                    <span class="detail-value">${name || '-'}</span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Deskripsi</span>
                    <span class="detail-value">${description || 'Tidak ada deskripsi'}</span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Website</span>
                    <span class="detail-value">
                        ${
                            website
                            ? `<a href="${website}" target="_blank" class="website-link">${website}</a>`
                            : 'Tidak ada website'
                        }
                    </span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Urutan Tampil</span>
                    <span class="detail-value">${order || 0}</span>
                </div>
            `;

        });

    }

});

/* ==========================================
   CONFIRM DELETE
========================================== */

function confirmDelete(element) {

    const id = element.dataset.id;
    const name = element.dataset.name;

    Swal.fire({
        title: 'Hapus Mitra?',
        text: `Yakin ingin menghapus "${name}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true

    }).then((result) => {

        if (result.isConfirmed) {

            const form = document.createElement('form');

            form.method = 'POST';
            form.action = `/admin/partners/${id}`;

            form.innerHTML = `
                <input type="hidden" name="_token"
                    value="${document.querySelector('meta[name="csrf-token"]').content}">
                <input type="hidden" name="_method" value="DELETE">
            `;

            document.body.appendChild(form);
            form.submit();

        }

    });

}