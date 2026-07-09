function editGallery(id, title, date, description)
{
    document.getElementById('edit_title').value = title;
    document.getElementById('edit_activity_date').value = date;
    document.getElementById('edit_description').value = description;

    document.getElementById('editForm').action =
        '/admin/gallery/' + id;

    document.getElementById('editModal').style.display = 'flex';
}

function closeEditModal()
{
    document.getElementById('editModal').style.display = 'none';
}

function openCreateModal(){
    document.getElementById('createModal').style.display='flex';
}

function closeCreateModal(){
    document.getElementById('createModal').style.display='none';
}

setTimeout(() => {
    const alert = document.querySelector('.alert-success');

    if (alert) {
        alert.style.transition = "all .5s ease";
        alert.style.opacity = "0";
        alert.style.transform = "translateY(-10px)";

        setTimeout(() => {
            alert.remove();
        }, 500);
    }
}, 3000);

function showDetail(button) {

    document.getElementById('detail_photo').src = button.dataset.photo;
    document.getElementById('detail_title').textContent = button.dataset.title;
    document.getElementById('detail_date').textContent = button.dataset.date;
    document.getElementById('detail_description').textContent = button.dataset.description;

    document.getElementById('detailModal').style.display = 'flex';
}