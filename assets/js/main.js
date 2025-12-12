document.addEventListener('DOMContentLoaded', () => {
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const showModal = (title, body) => {
        const modal = document.getElementById('modal-message');
        document.getElementById('modal-title').textContent = title;
        document.getElementById('modal-body').textContent = body;
        modal.showModal();
    };

    const apiFetch = async (url, options = {}) => {
        const opts = Object.assign({
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf
            },
        }, options);
        const res = await fetch(url, opts);
        return res.json();
    };

    const bookingForm = document.getElementById('booking-form');
    if (bookingForm) {
        bookingForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(bookingForm);
            const payload = Object.fromEntries(formData.entries());
            const response = await apiFetch('/api/appointments.php', {
                method: 'POST',
                body: JSON.stringify(payload)
            });
            showModal(response.status === 'success' ? 'Thành công' : 'Lỗi', response.message);
            if (response.status === 'success') {
                bookingForm.reset();
            }
        });
    }

    const serviceForm = document.getElementById('service-form');
    if (serviceForm) {
        serviceForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const data = Object.fromEntries(new FormData(serviceForm).entries());
            const res = await apiFetch('/api/services.php', { method: 'POST', body: JSON.stringify(data) });
            showModal(res.status === 'success' ? 'Đã lưu' : 'Lỗi', res.message);
            if (res.status === 'success') {
                location.reload();
            }
        });
    }

    const articleForm = document.getElementById('article-form');
    if (articleForm) {
        articleForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const data = Object.fromEntries(new FormData(articleForm).entries());
            const res = await apiFetch('/api/articles.php', { method: 'POST', body: JSON.stringify(data) });
            showModal(res.status === 'success' ? 'Đã lưu' : 'Lỗi', res.message);
            if (res.status === 'success') {
                location.reload();
            }
        });
    }

    document.querySelectorAll('.appointment-update-form').forEach((form) => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const payload = Object.fromEntries(new FormData(form).entries());
            payload.id = form.dataset.id;
            const res = await apiFetch('/api/appointment_status.php', { method: 'POST', body: JSON.stringify(payload) });
            showModal(res.status === 'success' ? 'Đã cập nhật' : 'Lỗi', res.message);
        });
    });

    const profileForm = document.getElementById('patient-profile-form');
    if (profileForm) {
        profileForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const payload = Object.fromEntries(new FormData(profileForm).entries());
            payload.action = 'update_profile';
            const res = await apiFetch('/api/profile.php', { method: 'POST', body: JSON.stringify(payload) });
            showModal(res.status === 'success' ? 'Đã lưu' : 'Lỗi', res.message);
        });
    }

    const passwordForm = document.getElementById('password-form');
    if (passwordForm) {
        passwordForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const payload = Object.fromEntries(new FormData(passwordForm).entries());
            payload.action = 'change_password';
            const res = await apiFetch('/api/profile.php', { method: 'POST', body: JSON.stringify(payload) });
            showModal(res.status === 'success' ? 'Thành công' : 'Lỗi', res.message);
            if (res.status === 'success') {
                passwordForm.reset();
            }
        });
    }

    if (window.jQuery) {
        $('#service-table').DataTable();
        $('#article-table').DataTable();
        $('#appointment-table').DataTable();
        $('#schedule-table').DataTable();
    }
});
