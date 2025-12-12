<section class="mb-8">
    <h1 class="text-3xl font-bold mb-4">Dashboard</h1>
    <div class="grid md:grid-cols-4 gap-4">
        <div class="stat bg-base-100 shadow">
            <div class="stat-title">Khách hàng</div>
            <div class="stat-value"><?= number_format($stats['customers']) ?></div>
        </div>
        <div class="stat bg-base-100 shadow">
            <div class="stat-title">Dịch vụ</div>
            <div class="stat-value"><?= number_format($stats['services']) ?></div>
        </div>
        <div class="stat bg-base-100 shadow">
            <div class="stat-title">Bài viết</div>
            <div class="stat-value"><?= number_format($stats['articles']) ?></div>
        </div>
        <div class="stat bg-base-100 shadow">
            <div class="stat-title">Lịch hẹn</div>
            <div class="stat-value"><?= number_format($stats['appointments']) ?></div>
        </div>
    </div>
</section>

<?php if ($user['role'] === 'admin'): ?>
<section class="mb-10">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-semibold"><i class="ri-hospital-line mr-2"></i>Quản lý dịch vụ</h2>
    </div>
    <form id="service-form" class="grid md:grid-cols-4 gap-3 bg-base-100 p-4 rounded-box shadow mb-4">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token()) ?>">
        <input type="hidden" name="id" value="">
        <input name="name" class="input input-bordered" placeholder="Tên dịch vụ" required>
        <input name="price" type="number" step="1000" class="input input-bordered" placeholder="Giá từ">
        <select name="is_active" class="select select-bordered">
            <option value="1">Hiển thị</option>
            <option value="0">Ẩn</option>
        </select>
        <input name="description" class="input input-bordered col-span-2 md:col-span-4" placeholder="Mô tả ngắn">
        <button class="btn btn-primary md:col-span-4" type="submit"><i class="ri-add-line mr-2"></i>Lưu dịch vụ</button>
    </form>
    <div class="overflow-x-auto bg-base-100 p-4 rounded-box shadow">
        <table class="table" id="service-table">
            <thead>
                <tr><th>Tên</th><th>Giá</th><th>Trạng thái</th></tr>
            </thead>
            <tbody>
                <?php foreach ($serviceModel->all() as $service): ?>
                    <tr>
                        <td><?= htmlspecialchars($service['name']) ?></td>
                        <td><?= $service['price'] ? number_format($service['price']) . ' đ' : 'Đang cập nhật' ?></td>
                        <td><?= $service['is_active'] ? 'Hiển thị' : 'Ẩn' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
<?php endif; ?>

<?php if (in_array($user['role'], ['admin', 'doctor'], true)): ?>
<section class="mb-10">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-semibold"><i class="ri-article-line mr-2"></i>Tạo bài viết</h2>
    </div>
    <form id="article-form" class="grid md:grid-cols-2 gap-3 bg-base-100 p-4 rounded-box shadow">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token()) ?>">
        <input name="title" class="input input-bordered" placeholder="Tiêu đề" required>
        <select name="status" class="select select-bordered">
            <option value="published">Đăng ngay</option>
            <option value="draft">Lưu nháp</option>
        </select>
        <input name="category" class="input input-bordered" placeholder="Chuyên mục" value="tuvan">
        <textarea name="content" class="textarea textarea-bordered md:col-span-2" rows="4" placeholder="Nội dung" required></textarea>
        <button class="btn btn-primary md:col-span-2" type="submit"><i class="ri-save-line mr-2"></i>Lưu bài</button>
    </form>
    <div class="overflow-x-auto bg-base-100 p-4 rounded-box shadow mt-4">
        <table class="table" id="article-table">
            <thead><tr><th>Tiêu đề</th><th>Trạng thái</th><th>Tác giả</th></tr></thead>
            <tbody>
                <?php foreach ($articleModel->all() as $article): ?>
                    <tr>
                        <td><?= htmlspecialchars($article['title']) ?></td>
                        <td><?= htmlspecialchars($article['status']) ?></td>
                        <td><?= htmlspecialchars($article['author_name'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
<?php endif; ?>

<?php $canUpdateAppointment = in_array($user['role'], ['admin', 'doctor'], true); ?>
<section class="mb-10">
    <h2 class="text-2xl font-semibold mb-4"><i class="ri-calendar-line mr-2"></i>Danh sách lịch hẹn</h2>
    <div class="overflow-x-auto bg-base-100 p-4 rounded-box shadow">
        <table class="table" id="appointment-table">
            <thead>
                <tr>
                    <th>Khách hàng</th><th>Dịch vụ</th><th>Ngày giờ</th><th>Trạng thái</th><th>Bác sĩ</th><th>Ghi chú</th>
                    <?php if ($canUpdateAppointment): ?><th>Thao tác</th><?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $app): ?>
                    <tr>
                        <td><?= htmlspecialchars($app['full_name'] ?? $app['customer_name'] ?? 'Khách lẻ') ?></td>
                        <td><?= htmlspecialchars($app['service_name'] ?? 'Tư vấn') ?></td>
                        <td><?= htmlspecialchars($app['appointment_date']) ?></td>
                        <td><?= htmlspecialchars($app['status']) ?></td>
                        <td><?= htmlspecialchars($app['doctor_name'] ?? '') ?></td>
                        <td><?= htmlspecialchars($app['notes'] ?? '') ?></td>
                        <?php if ($canUpdateAppointment): ?>
                            <td>
                                <form class="appointment-update-form space-y-1" data-id="<?= $app['id'] ?>">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token()) ?>">
                                    <?php if ($user['role'] === 'doctor'): ?>
                                        <input type="hidden" name="doctor_id" value="<?= (int)$user['id'] ?>">
                                    <?php endif; ?>
                                    <select name="status" class="select select-bordered select-sm w-full">
                                        <?php foreach (['pending','confirmed','rescheduled','cancelled','completed','no_show','revisit'] as $st): ?>
                                            <option value="<?= $st ?>" <?= ($app['status'] ?? '') === $st ? 'selected' : '' ?>><?= $st ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="datetime-local" name="appointment_date" class="input input-bordered input-sm w-full" value="<?= isset($app['appointment_date']) ? date('Y-m-d\TH:i', strtotime($app['appointment_date'])) : '' ?>">
                                    <textarea name="notes" rows="2" class="textarea textarea-bordered textarea-xs w-full" placeholder="Ghi chú"><?= htmlspecialchars($app['notes'] ?? '') ?></textarea>
                                    <button type="submit" class="btn btn-primary btn-sm w-full"><i class="ri-save-line mr-1"></i>Cập nhật</button>
                                </form>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?php if ($user['role'] === 'doctor' && $doctorSchedules): ?>
<section class="mb-10">
    <h2 class="text-2xl font-semibold mb-4"><i class="ri-time-line mr-2"></i>Lịch làm việc</h2>
    <div class="overflow-x-auto bg-base-100 p-4 rounded-box shadow">
        <table class="table" id="schedule-table">
            <thead><tr><th>Ngày</th><th>Bắt đầu</th><th>Kết thúc</th><th>Ghi chú</th></tr></thead>
            <tbody>
                <?php foreach ($doctorSchedules as $schedule): ?>
                    <tr>
                        <td><?= htmlspecialchars($schedule['work_date']) ?></td>
                        <td><?= htmlspecialchars($schedule['start_time']) ?></td>
                        <td><?= htmlspecialchars($schedule['end_time']) ?></td>
                        <td><?= htmlspecialchars($schedule['note']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
<?php endif; ?>

<?php if ($user['role'] === 'customer'): ?>
<section class="mb-10 grid md:grid-cols-2 gap-4">
    <div class="bg-base-100 p-4 rounded-box shadow">
        <h2 class="text-2xl font-semibold mb-4"><i class="ri-user-heart-line mr-2"></i>Hồ sơ bệnh nhân</h2>
        <form id="patient-profile-form" class="space-y-3">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token()) ?>">
            <label class="form-control">
                <span class="label-text">Họ và tên</span>
                <input class="input input-bordered" name="full_name" required value="<?= htmlspecialchars($userDetails['full_name'] ?? $user['name']) ?>">
            </label>
            <label class="form-control">
                <span class="label-text">Số điện thoại</span>
                <input class="input input-bordered" name="phone" value="<?= htmlspecialchars($userDetails['phone'] ?? '') ?>">
            </label>
            <div class="grid grid-cols-2 gap-3">
                <label class="form-control">
                    <span class="label-text">Ngày sinh</span>
                    <input type="date" name="dob" class="input input-bordered" value="<?= htmlspecialchars($patientProfile['dob'] ?? '') ?>">
                </label>
                <label class="form-control">
                    <span class="label-text">Giới tính</span>
                    <select name="gender" class="select select-bordered">
                        <option value="">Không xác định</option>
                        <option value="male" <?= ($patientProfile['gender'] ?? '') === 'male' ? 'selected' : '' ?>>Nam</option>
                        <option value="female" <?= ($patientProfile['gender'] ?? '') === 'female' ? 'selected' : '' ?>>Nữ</option>
                        <option value="other" <?= ($patientProfile['gender'] ?? '') === 'other' ? 'selected' : '' ?>>Khác</option>
                    </select>
                </label>
            </div>
            <label class="form-control">
                <span class="label-text">Địa chỉ</span>
                <input class="input input-bordered" name="address" value="<?= htmlspecialchars($patientProfile['address'] ?? '') ?>">
            </label>
            <label class="form-control">
                <span class="label-text">Tiền sử bệnh</span>
                <textarea class="textarea textarea-bordered" name="medical_history" rows="3"><?= htmlspecialchars($patientProfile['medical_history'] ?? '') ?></textarea>
            </label>
            <label class="form-control">
                <span class="label-text">Dị ứng</span>
                <textarea class="textarea textarea-bordered" name="allergies" rows="2"><?= htmlspecialchars($patientProfile['allergies'] ?? '') ?></textarea>
            </label>
            <button class="btn btn-primary" type="submit"><i class="ri-save-line mr-2"></i>Lưu hồ sơ</button>
        </form>
    </div>
</section>
<?php endif; ?>

<section class="mb-10">
    <div class="bg-base-100 p-4 rounded-box shadow md:max-w-2xl">
        <h2 class="text-2xl font-semibold mb-4"><i class="ri-key-2-line mr-2"></i>Đổi mật khẩu</h2>
        <p class="text-sm text-gray-500 mb-3">Áp dụng cho tất cả vai trò. Vui lòng nhập chính xác mật khẩu hiện tại.</p>
        <form id="password-form" class="space-y-3">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token()) ?>">
            <label class="form-control">
                <span class="label-text">Mật khẩu hiện tại</span>
                <input type="password" name="current_password" class="input input-bordered" required>
            </label>
            <label class="form-control">
                <span class="label-text">Mật khẩu mới</span>
                <input type="password" name="new_password" class="input input-bordered" required>
            </label>
            <label class="form-control">
                <span class="label-text">Xác nhận mật khẩu mới</span>
                <input type="password" name="confirm_password" class="input input-bordered" required>
            </label>
            <button class="btn btn-primary" type="submit"><i class="ri-lock-password-line mr-2"></i>Cập nhật mật khẩu</button>
        </form>
    </div>
</section>
