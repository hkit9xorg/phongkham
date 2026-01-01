document.addEventListener('DOMContentLoaded', () => {
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.querySelectorAll('[data-flash="true"]').forEach((alert) => {
        setTimeout(() => {
            alert.classList.add('animate-fade-out');
            alert.addEventListener('animationend', () => alert.remove());
        }, 3200);
    });

    const showModal = (title, body, extraNode = null) => {
        const modal = document.getElementById('modal-message');
        const modalBody = document.getElementById('modal-body');
        document.getElementById('modal-title').textContent = title;
        modalBody.innerHTML = '';

        const bodyParagraph = document.createElement('p');
        bodyParagraph.textContent = body;
        modalBody.appendChild(bodyParagraph);

        if (extraNode) {
            modalBody.appendChild(extraNode);
        }

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

    const syncWysiwygEditors = () => {
        document.querySelectorAll('[data-wysiwyg]').forEach((wrapper) => {
            const editor = wrapper.querySelector('[data-editor]');
            const textarea = wrapper.querySelector('textarea');
            if (editor && textarea) {
                textarea.value = editor.innerHTML.trim();
            }
        });
    };

    const initWysiwygEditors = () => {
        document.querySelectorAll('[data-wysiwyg]').forEach((wrapper) => {
            if (wrapper.dataset.initialized === 'true') return;
            const editor = wrapper.querySelector('[data-editor]');
            const textarea = wrapper.querySelector('textarea');
            if (!editor || !textarea) return;

            editor.innerHTML = textarea.value;

            wrapper.querySelectorAll('[data-command]').forEach((btn) => {
                btn.addEventListener('click', (event) => {
                    event.preventDefault();
                    const cmd = btn.dataset.command;
                    if (cmd === 'createLink') {
                        const url = prompt('Nhập đường dẫn:');
                        if (url) {
                            document.execCommand(cmd, false, url);
                        }
                    } else {
                        document.execCommand(cmd, false, null);
                    }
                    editor.focus();
                    textarea.value = editor.innerHTML.trim();
                });
            });

            editor.addEventListener('input', () => {
                textarea.value = editor.innerHTML.trim();
            });

            wrapper.dataset.initialized = 'true';
        });
    };

    initWysiwygEditors();

    const bookingForm = document.getElementById('booking-form');
    if (bookingForm) {
        const doctorSelect = bookingForm.querySelector('[data-doctor-select]');
        bookingForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(bookingForm);
            const payload = Object.fromEntries(formData.entries());
            const response = await apiFetch('/api/appointments.php', {
                method: 'POST',
                body: JSON.stringify(payload)
            });

            let extraNode = null;
            if (response.status === 'success' && response.data?.suggest_register) {
                extraNode = document.createElement('div');
                extraNode.className = 'mt-3 space-y-1';

                const hint = document.createElement('p');
                hint.textContent = 'Bạn chưa có tài khoản với số điện thoại này. Đăng ký để quản lý và theo dõi lịch hẹn.';

                const link = document.createElement('a');
                link.className = 'link link-primary font-semibold';
                link.href = response.data.register_url || '/index.php?page=register';
                link.textContent = 'Đăng ký tài khoản';

                extraNode.appendChild(hint);
                extraNode.appendChild(link);
            }

            showModal(response.status === 'success' ? 'Thành công' : 'Lỗi', response.message, extraNode);
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
                const params = new URLSearchParams({ date });
                if (doctorSelect?.value) {
                    params.set('doctor_id', doctorSelect.value);
                }

                const res = await apiFetch(`/api/availability.php?${params.toString()}`);
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
        const thumbInput = articleForm.querySelector('input[name="thumbnail"]');
        const thumbPreview = articleForm.querySelector('[data-preview-thumb]');

        if (thumbInput && thumbPreview) {
            thumbInput.addEventListener('change', (event) => {
                const file = event.target.files?.[0];
                if (file) {
                    thumbPreview.src = URL.createObjectURL(file);
                    thumbPreview.classList.remove('hidden');
                } else {
                    thumbPreview.src = '';
                    thumbPreview.classList.add('hidden');
                }
            });
        }

        articleForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            syncWysiwygEditors();
            const formData = new FormData(articleForm);

            try {
                const response = await fetch('/api/articles.php', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrf },
                    body: formData,
                });
                const res = await response.json();
                showModal(res.status === 'success' ? 'Đã lưu' : 'Lỗi', res.message);
                if (res.status === 'success') {
                    articleForm.reset();
                    if (thumbPreview) {
                        thumbPreview.src = '';
                        thumbPreview.classList.add('hidden');
                    }
                    document.querySelectorAll('[data-wysiwyg]').forEach((wrapper) => {
                        wrapper.dataset.initialized = '';
                        const editor = wrapper.querySelector('[data-editor]');
                        const textarea = wrapper.querySelector('textarea');
                        if (editor) editor.innerHTML = '';
                        if (textarea) textarea.value = '';
                    });
                    initWysiwygEditors();
                }
            } catch (error) {
                showModal('Lỗi', 'Không thể lưu bài viết.');
            }
        });
    }

    document.querySelectorAll('[data-file-input]').forEach((input) => {
        const targetSelector = input.dataset.previewTarget;
        const previewEl = targetSelector ? document.querySelector(targetSelector) : null;
        if (!previewEl) return;

        input.addEventListener('change', (event) => {
            const file = event.target.files?.[0];
            if (file) {
                previewEl.src = URL.createObjectURL(file);
                previewEl.classList.remove('hidden');
            } else {
                previewEl.src = '';
                previewEl.classList.add('hidden');
            }
        });
    });

    document.querySelectorAll('.appointment-reschedule-toggle').forEach((btn) => {
        btn.addEventListener('click', () => {
            const card = btn.closest('.card-body');
            const rescheduleForm = card?.querySelector('.appointment-reschedule-form');
            const cancelForm = card?.querySelector('.appointment-cancel-form');
            if (!rescheduleForm) return;

            const isHidden = rescheduleForm.classList.contains('hidden');
            rescheduleForm.classList.toggle('hidden');
            if (isHidden) {
                cancelForm?.classList.add('hidden');
            }
        });
    });

    document.querySelectorAll('.appointment-cancel-toggle').forEach((btn) => {
        btn.addEventListener('click', () => {
            const card = btn.closest('.card-body');
            const cancelForm = card?.querySelector('.appointment-cancel-form');
            const rescheduleForm = card?.querySelector('.appointment-reschedule-form');
            if (!cancelForm) return;

            const isHidden = cancelForm.classList.contains('hidden');
            cancelForm.classList.toggle('hidden');
            if (isHidden) {
                rescheduleForm?.classList.add('hidden');
            }
        });
    });

    document.querySelectorAll('[data-hide-reschedule]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const form = btn.closest('.appointment-reschedule-form');
            form?.classList.add('hidden');
        });
    });

    document.querySelectorAll('[data-hide-cancel]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const form = btn.closest('.appointment-cancel-form');
            form?.classList.add('hidden');
        });
    });

    document.querySelectorAll('.appointment-reschedule-form').forEach((form) => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const payload = Object.fromEntries(new FormData(form).entries());
            payload.id = form.dataset.id;
            const res = await apiFetch('/api/appointment_reschedule.php', { method: 'POST', body: JSON.stringify(payload) });
            showModal(res.status === 'success' ? 'Đã gửi yêu cầu' : 'Lỗi', res.message);
        });
    });

    document.querySelectorAll('.appointment-cancel-form').forEach((form) => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            if (!confirm('Bạn chắc chắn muốn hủy lịch hẹn này?')) return;

            const payload = Object.fromEntries(new FormData(form).entries());
            payload.id = form.dataset.id;
            const res = await apiFetch('/api/appointment_cancel.php', { method: 'POST', body: JSON.stringify(payload) });
            showModal(res.status === 'success' ? 'Đã hủy lịch' : 'Lỗi', res.message);
        });
    });

    const appointmentModal = document.getElementById('appointment-edit-modal');
    if (appointmentModal) {
        const idInput = appointmentModal.querySelector('[data-appointment-id]');
        const dateInput = appointmentModal.querySelector('[data-appointment-date]');
        const statusSelect = appointmentModal.querySelector('[data-appointment-status]');
        const doctorSelect = appointmentModal.querySelector('[data-appointment-doctor]');
        const notesTextarea = appointmentModal.querySelector('[data-appointment-notes]');
        const nameEl = appointmentModal.querySelector('[data-appointment-name]');
        const phoneEl = appointmentModal.querySelector('[data-appointment-phone]');
        const serviceEl = appointmentModal.querySelector('[data-appointment-service]');
        const datetimeEl = appointmentModal.querySelector('[data-appointment-datetime]');
        const closeBtn = appointmentModal.querySelector('[data-appointment-close]');
        const modalForm = appointmentModal.querySelector('[data-appointment-form]');

        if (closeBtn) {
            closeBtn.addEventListener('click', () => appointmentModal.close());
        }

        document.querySelectorAll('[data-appointment-trigger]').forEach((btn) => {
            btn.addEventListener('click', () => {
                idInput.value = btn.dataset.id || '';
                dateInput.value = btn.dataset.date ? btn.dataset.date.replace(' ', 'T') : '';
                statusSelect.value = btn.dataset.status || 'pending';
                doctorSelect.value = btn.dataset.doctorId || '';
                notesTextarea.value = btn.dataset.notes || '';

                nameEl.textContent = btn.dataset.name || 'Khách hàng';
                phoneEl.textContent = btn.dataset.phone || '';
                serviceEl.textContent = btn.dataset.service || '';
                datetimeEl.textContent = btn.dataset.date || '';

                appointmentModal.showModal();
            });
        });

        if (modalForm) {
            modalForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const payload = Object.fromEntries(new FormData(modalForm).entries());
                payload.id = idInput?.value || '';
                const res = await apiFetch('/api/appointment_status.php', { method: 'POST', body: JSON.stringify(payload) });
                showModal(res.status === 'success' ? 'Đã cập nhật' : 'Lỗi', res.message);
                if (res.status === 'success') {
                    appointmentModal.close();
                }
            });
        }
    }

    const moduleFormModal = document.getElementById('module-form-modal');
    if (moduleFormModal) {
        const moduleForm = moduleFormModal.querySelector('[data-module-form]');
        const titleEl = moduleFormModal.querySelector('[data-form-title]');
        const subtitleEl = moduleFormModal.querySelector('[data-form-subtitle]');
        const createTitle = moduleFormModal.dataset.createTitle;
        const editTitle = moduleFormModal.dataset.editTitle;
        const createSubtitle = moduleFormModal.dataset.createSubtitle;
        const editSubtitle = moduleFormModal.dataset.editSubtitle;

        const setMode = (mode) => {
            if (mode === 'edit') {
                if (titleEl) titleEl.textContent = editTitle;
                if (subtitleEl) subtitleEl.textContent = editSubtitle;
            } else {
                if (titleEl) titleEl.textContent = createTitle;
                if (subtitleEl) subtitleEl.textContent = createSubtitle;
            }
        };

        const resetModuleForm = () => {
            if (!moduleForm) return;
            moduleForm.reset();
            const idInput = moduleForm.querySelector('input[name="id"]');
            if (idInput) idInput.value = '';

            moduleForm.querySelectorAll('[data-preview-target]').forEach((input) => {
                const selector = input.dataset.previewTarget;
                const preview = selector ? document.querySelector(selector) : null;
                if (preview) {
                    preview.src = '';
                    preview.classList.add('hidden');
                }
                input.value = '';
            });

            moduleForm.querySelectorAll('[data-preview-image]').forEach((img) => {
                img.src = '';
                img.classList.add('hidden');
            });

            moduleForm.querySelectorAll('[data-wysiwyg]').forEach((wrapper) => {
                const editor = wrapper.querySelector('[data-editor]');
                const textarea = wrapper.querySelector('textarea');
                if (editor) editor.innerHTML = '';
                if (textarea) textarea.value = '';
            });
        };

        document.querySelectorAll('[data-open-form]').forEach((btn) => {
            btn.addEventListener('click', () => {
                resetModuleForm();
                setMode('create');
                moduleFormModal.showModal();
            });
        });

        moduleFormModal.querySelector('[data-close-modal]')?.addEventListener('click', () => {
            moduleFormModal.close();
        });

        if (moduleFormModal.dataset.autoOpen === 'true') {
            setMode('edit');
            moduleFormModal.showModal();
        } else {
            setMode('create');
        }
    }

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

    const scheduleModal = document.getElementById('schedule-view-modal');
    if (scheduleModal) {
        const dateEl = scheduleModal.querySelector('[data-schedule-date]');
        const startEl = scheduleModal.querySelector('[data-schedule-start]');
        const endEl = scheduleModal.querySelector('[data-schedule-end]');
        const noteEl = scheduleModal.querySelector('[data-schedule-note]');

        document.querySelectorAll('[data-schedule-trigger]').forEach((btn) => {
            btn.addEventListener('click', () => {
                dateEl.textContent = btn.dataset.date || '';
                startEl.textContent = btn.dataset.start || '';
                endEl.textContent = btn.dataset.end || '';
                noteEl.textContent = btn.dataset.note || 'Không có ghi chú.';
                scheduleModal.showModal();
            });
        });
    }

    const initSliders = () => {
        document.querySelectorAll('[data-auto-slider]').forEach((slider) => {
            const slides = slider.querySelectorAll('[data-slide]');
            if (!slides.length) return;

            const track = slider.querySelector('[data-track]');
            const perPage = Math.max(1, parseInt(slider.dataset.visible || '1', 10));
            let activeIndex = Array.from(slides).findIndex((slide) => slide.hasAttribute('data-active'));
            activeIndex = activeIndex >= 0 ? activeIndex : 0;
            activeIndex = Math.floor(activeIndex / perPage) * perPage;
            const interval = parseInt(slider.dataset.interval || '4000', 10);

            const setActive = (index) => {
                const totalGroups = Math.max(1, Math.ceil(slides.length / perPage));
                const groupIndex = ((Math.floor(index / perPage) % totalGroups) + totalGroups) % totalGroups;
                activeIndex = groupIndex * perPage;
                slides.forEach((slide, idx) => {
                    const isActiveGroup = idx >= activeIndex && idx < activeIndex + perPage;
                    if (isActiveGroup) slide.setAttribute('data-active', '');
                    else slide.removeAttribute('data-active');
                });

                if (track) {
                    const target = slides[activeIndex];
                    const offset = target?.offsetLeft || 0;
                    track.scrollTo({ left: offset, behavior: 'smooth' });
                }
            };

            const next = () => setActive(activeIndex + perPage);
            const prev = () => setActive(activeIndex - perPage);

            slider.querySelectorAll('[data-next]').forEach((btn) => btn.addEventListener('click', next));
            slider.querySelectorAll('[data-prev]').forEach((btn) => btn.addEventListener('click', prev));

            if (slider.id) {
                document.querySelectorAll(`[data-target="${slider.id}"][data-next]`).forEach((btn) => btn.addEventListener('click', next));
                document.querySelectorAll(`[data-target="${slider.id}"][data-prev]`).forEach((btn) => btn.addEventListener('click', prev));
            }

            setActive(activeIndex);
            setInterval(next, interval);
        });
    };

    initSliders();

    if (window.jQuery) {
        if ($('#service-table').length) {
            $('#service-table').DataTable();
        }
        if ($('#article-table').length) {
            $('#article-table').DataTable();
        }
        if ($('#appointment-table').length) {
            $('#appointment-table').DataTable();
        }
        if ($('#schedule-table').length) {
            $('#schedule-table').DataTable();
        }
    }
});
