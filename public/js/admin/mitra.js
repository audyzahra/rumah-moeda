// ==============================
// MITRA.JS
// Manajemen Mitra
// ==============================

// ===== VARIABEL GLOBAL =====
// let mitraData = [];
// let filteredData = [];
// let currentPage = 1;
// const itemsPerPage = 8;
// let deleteId = null;
// let editId = null;

// ===== DOM ELEMENTS =====
// const grid = document.getElementById('mitraGrid');
// const searchInput = document.getElementById('searchInput');
// const filterWebsite = document.getElementById('filterWebsite');

document.addEventListener('DOMContentLoaded', function() {
        

        // ==========================================
        // 2. DETAIL MODAL
        // ==========================================
        const detailModal = document.getElementById('detailModal');
        if (detailModal) {
            detailModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const name = button.getAttribute('data-name');
                const website = button.getAttribute('data-website');
                const description = button.getAttribute('data-description');
                const order = button.getAttribute('data-order');
                const logo = button.getAttribute('data-logo');

                const body = document.getElementById('detailBody');
                // const logoUrl = logo ? "{{ asset('storage/') }}/" + logo : null;
                const logoUrl = logo ? `${window.storageUrl}/${logo}`: null;
                
                body.innerHTML = `
                    <div class="text-center mb-3">
                        ${logoUrl ? 
                            `<img src="${logoUrl}" alt="${name}" class="detail-logo" style="max-width: 200px; max-height: 150px; object-fit: contain;">` : 
                            `<div class="detail-logo-placeholder" style="width: 150px; height: 100px; background: #e5e7eb; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                <i class="fa-solid fa-building" style="font-size: 40px; color: #94a3b8;"></i>
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
                            ${website ? 
                                `<a href="${website}" target="_blank" class="website-link">${website}</a>` : 
                                'Tidak ada website'
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

    // ==========================================
    // 3. CONFIRM DELETE
    // ==========================================
    function confirmDelete(element) {
        const id = element.getAttribute('data-id');
        const name = element.getAttribute('data-name');
        
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        document.getElementById('deleteName').textContent = name;
        
        const form = document.getElementById('deleteForm');
        form.action = `${window.mitraRoutes.destroy}/${id}`;
        
        deleteModal.show();
    }

    // ==========================================
    // 4. NOTIFICATION FUNCTION
    // ==========================================
    function showNotification(message, type = 'info') {
        const notification = document.getElementById('notification');
        if (!notification) return;

        notification.textContent = message;
        notification.className = `notification ${type} show`;
        
        setTimeout(() => {
            notification.classList.remove('show');
        }, 3000);
    }

    