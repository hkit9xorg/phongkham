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

        const appointmentInput = bookingForm.querySelector('input[name="appointment_date"]');
        const slotContainer = document.getElementById('slot-suggestions');
        const slotMeta = document.getElementById('suggest-meta');
        const suggestBtn = document.getElementById('suggest-slot-btn');

        const renderSlots = (slots = []) => {
            if (!slotContainer) return;
            slotContainer.innerHTML = '';
            slots.forEach((slot) => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'btn btn-sm';
                btn.textContent = `${slot.datetime.replace(' ', ' • ')}`;
                btn.addEventListener('click', () => {
                    if (appointmentInput) {
                        appointmentInput.value = slot.datetime.replace(' ', 'T');
                    }
                });
                slotContainer.appendChild(btn);
            });
        };

        const loadSuggestions = async () => {
            if (!suggestBtn) return;
            suggestBtn.setAttribute('disabled', 'disabled');
            suggestBtn.classList.add('loading');
            const date = appointmentInput?.value ? appointmentInput.value.split('T')[0] : new Date().toISOString().slice(0, 10);
            try {
                const res = await apiFetch(`/api/availability.php?date=${date}`);
                if (res.status === 'success') {
                    slotMeta.textContent = `Bác sĩ: ${res.data.slots[0].doctor_name} - Ngày ${res.data.date}`;
                    renderSlots(res.data.slots);
                } else {
                    slotMeta.textContent = res.message;
                    renderSlots([]);
                }
            } catch (error) {
                slotMeta.textContent = 'Không thể tải gợi ý.';
                renderSlots([]);
            } finally {
                suggestBtn.removeAttribute('disabled');
                suggestBtn.classList.remove('loading');
            }
        };

        if (suggestBtn) {
            suggestBtn.addEventListener('click', loadSuggestions);
        }
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
