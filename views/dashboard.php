<?php
$isAdmin = $user['role'] === 'admin';
$isDoctor = $user['role'] === 'doctor';
$canUpdateAppointment = in_array($user['role'], ['admin', 'doctor'], true);
$appointmentTotal = max(1, array_sum($appointmentStatusCounts ?? []));
?>

<section class="mb-8 space-y-4">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <p class="text-sm text-base-content/60">Welcome back, <?= htmlspecialchars($user['name']) ?> 👋</p>
            <h1 class="text-3xl font-bold">Bảng điều khiển</h1>
        </div>
        <?php if ($isAdmin): ?>
            <div class="badge badge-primary badge-lg shadow">Admin dashboard</div>
        <?php elseif ($isDoctor): ?>
            <div class="badge badge-secondary badge-lg shadow">Bác sĩ</div>
        <?php endif; ?>
    </div>

    <?php if ($isAdmin): ?>
        <div class="grid md:grid-cols-4 gap-4">
            <div class="stat bg-base-100 shadow rounded-box">
                <div class="stat-title">Khách hàng</div>
                <div class="stat-value text-primary"><?= number_format($stats['customers']) ?></div>
                <div class="stat-desc">Tổng số tài khoản</div>
            </div>
            <div class="stat bg-base-100 shadow rounded-box">
                <div class="stat-title">Dịch vụ</div>
                <div class="stat-value text-secondary"><?= number_format($stats['services']) ?></div>
                <div class="stat-desc">Đang được giới thiệu</div>
            </div>
            <div class="stat bg-base-100 shadow rounded-box">
                <div class="stat-title">Bài viết</div>
                <div class="stat-value text-accent"><?= number_format($stats['articles']) ?></div>
                <div class="stat-desc">Tin tức & tư vấn</div>
            </div>
            <div class="stat bg-base-100 shadow rounded-box">
                <div class="stat-title">Lịch hẹn</div>
                <div class="stat-value text-primary"><?= number_format($stats['appointments']) ?></div>
                <div class="stat-desc">Tổng lượt đặt lịch</div>
            </div>
        </div>
    <?php elseif ($isDoctor): ?>
        <div class="grid md:grid-cols-3 gap-4">
            <div class="stat bg-base-100 shadow rounded-box">
                <div class="stat-title">Lịch hẹn được giao</div>
                <div class="stat-value text-primary"><?= number_format($doctorStats['appointments'] ?? 0) ?></div>
                <div class="stat-desc">Tất cả trạng thái</div>
            </div>
            <div class="stat bg-base-100 shadow rounded-box">
                <div class="stat-title">Lịch làm việc</div>
                <div class="stat-value text-secondary"><?= number_format($doctorStats['schedules'] ?? 0) ?></div>
                <div class="stat-desc">Theo cấu hình của phòng khám</div>
            </div>
            <div class="stat bg-base-100 shadow rounded-box">
                <div class="stat-title">Lịch sắp tới</div>
                <div class="stat-value text-accent"><?= number_format(count(array_filter($appointments, fn($item) => strtotime($item['appointment_date']) > time()))) ?></div>
                <div class="stat-desc">Lọc theo thời gian</div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($isAdmin): ?>
        <div class="bg-base-100 p-4 rounded-box shadow flex flex-wrap gap-3">
            <div class="w-full text-base font-semibold mb-2 flex items-center gap-2">
                <i class="ri-flashlight-line"></i>Thao tác nhanh
            </div>
            <a class="btn btn-primary" href="/index.php?page=create_service"><i class="ri-add-line mr-2"></i>Thêm dịch vụ</a>
            <a class="btn btn-secondary" href="/index.php?page=create_article"><i class="ri-article-line mr-2"></i>Viết bài mới</a>
            <a class="btn" href="/index.php?page=admin&module=appointments"><i class="ri-calendar-event-line mr-2"></i>Quản lý lịch hẹn</a>
            <a class="btn btn-outline" href="/index.php?page=admin&module=services"><i class="ri-tools-line mr-2"></i>Điều chỉnh dịch vụ</a>
        </div>
    <?php elseif ($isDoctor): ?>
        <div class="bg-base-100 p-4 rounded-box shadow flex flex-wrap gap-3">
            <div class="w-full text-base font-semibold mb-2 flex items-center gap-2">
                <i class="ri-flashlight-line"></i>Thao tác nhanh</div>
            <a class="btn btn-secondary" href="#schedule-table"><i class="ri-time-line mr-2"></i>Xem lịch làm việc</a>
            <a class="btn btn-outline" href="#appointment-table"><i class="ri-list-check mr-2"></i>Lịch hẹn phụ trách</a>
        </div>
    <?php endif; ?>
</section>

<?php if ($isAdmin): ?>
<section class="grid lg:grid-cols-3 gap-4 mb-10">
    <div class="bg-base-100 p-5 rounded-box shadow lg:col-span-2 space-y-3">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold flex items-center gap-2"><i class="ri-donut-chart-line"></i>Trạng thái lịch hẹn</h2>
            <span class="text-sm text-base-content/60"><?= array_sum($appointmentStatusCounts ?? []) ?> lượt</span>
        </div>
        <div class="space-y-2">
            <?php foreach (($appointmentStatusCounts ?? []) as $status => $count): ?>
                <?php $percent = round(($count / $appointmentTotal) * 100); ?>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="uppercase tracking-wide text-base-content/70"><?= htmlspecialchars($status) ?></span>
                        <span class="font-semibold"><?= $count ?> lượt (<?= $percent ?>%)</span>
                    </div>
                    <div class="h-3 rounded-full bg-base-200 overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-primary to-secondary" style="width: <?= $percent ?>%"></div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($appointmentStatusCounts)): ?>
                <p class="text-sm text-base-content/60">Chưa có dữ liệu lịch hẹn.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="space-y-4">
        <div class="bg-base-100 p-5 rounded-box shadow space-y-3">
            <h2 class="text-xl font-semibold flex items-center gap-2"><i class="ri-service-line"></i>Dịch vụ</h2>
            <p class="text-sm text-base-content/60">Phân bổ hiển thị</p>
            <?php $serviceTotal = max(1, $serviceVisibility['active'] + $serviceVisibility['hidden']); ?>
            <div class="space-y-2">
                <div class="flex justify-between text-sm"><span>Hiển thị</span><span><?= $serviceVisibility['active'] ?></span></div>
                <div class="progress progress-primary" value="<?= $serviceVisibility['active'] ?>" max="<?= $serviceTotal ?>"></div>
                <div class="flex justify-between text-sm"><span>Ẩn</span><span><?= $serviceVisibility['hidden'] ?></span></div>
                <div class="progress progress-secondary" value="<?= $serviceVisibility['hidden'] ?>" max="<?= $serviceTotal ?>"></div>
            </div>
        </div>
        <div class="bg-base-100 p-5 rounded-box shadow space-y-3">
            <h2 class="text-xl font-semibold flex items-center gap-2"><i class="ri-user-star-line"></i>Phân bố tài khoản</h2>
            <?php foreach ($roleDistribution as $role => $count): ?>
                <?php $percent = round(($count / max(1, array_sum($roleDistribution))) * 100); ?>
                <div class="flex items-center justify-between text-sm">
                    <span class="capitalize"><?= htmlspecialchars($role) ?></span>
                    <span class="font-semibold"><?= $count ?> (<?= $percent ?>%)</span>
                </div>
            <?php endforeach; ?>
            <?php if (empty($roleDistribution)): ?>
                <p class="text-sm text-base-content/60">Chưa có dữ liệu người dùng.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($isAdmin || $isDoctor): ?>
<section class="mb-10">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-semibold flex items-center gap-2"><i class="ri-calendar-line"></i>Danh sách lịch hẹn</h2>
        <?php if ($isAdmin): ?>
            <a class="btn btn-outline btn-sm" href="/index.php?page=admin&module=appointments"><i class="ri-arrow-right-up-line mr-1"></i>Xem tất cả</a>
        <?php endif; ?>
    </div>
    <div class="overflow-x-auto bg-base-100 p-4 rounded-box shadow">
        <table class="table" id="appointment-table">
            <thead>
                <tr>
                    <th>Khách hàng</th><th>Dịch vụ</th><th>Ngày giờ</th><th>Trạng thái</th><th>Bác sĩ</th><th>Ghi chú</th>
                    <?php if ($canUpdateAppointment && $isDoctor): ?><th>Thao tác</th><?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($isAdmin ? array_slice($appointments, 0, 6) : $appointments as $app): ?>
                    <tr>
                        <td><?= htmlspecialchars($app['full_name'] ?? $app['customer_name'] ?? 'Khách lẻ') ?></td>
                        <td><?= htmlspecialchars($app['service_name'] ?? 'Tư vấn') ?></td>
                        <td><?= htmlspecialchars($app['appointment_date']) ?></td>
                        <td><span class="badge badge-outline badge-sm capitalize"><?= htmlspecialchars($app['status']) ?></span></td>
                        <td><?= htmlspecialchars($app['doctor_name'] ?? '') ?></td>
                        <td><?= htmlspecialchars($app['notes'] ?? '') ?></td>
                        <?php if ($canUpdateAppointment && $isDoctor): ?>
                            <td>
                                <form class="appointment-update-form space-y-1" data-id="<?= $app['id'] ?>">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token()) ?>">
                                    <input type="hidden" name="doctor_id" value="<?= (int)$user['id'] ?>">
                                    <select name="status" class="select select-bordered select-sm w-full">
                                        <?php foreach (['pending','confirmed','rescheduled','cancelled','completed','no_show','revisit'] as $st): ?>
                                            <option value="<?= $st ?>" <?= ($app['status'] ?? '') === $st ? 'selected' : '' ?>><?= $st ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="datetime-local" name="appointment_date" class="input input-bordered input-sm w-full" value="<?= isset($app['appointment_date']) ? date('Y-m-d\\TH:i', strtotime($app['appointment_date'])) : '' ?>">
                                    <textarea name="notes" rows="2" class="textarea textarea-bordered textarea-xs w-full" placeholder="Ghi chú"><?= htmlspecialchars($app['notes'] ?? '') ?></textarea>
                                    <button type="submit" class="btn btn-primary btn-sm w-full"><i class="ri-save-line mr-1"></i>Cập nhật</button>
                                </form>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if ($isAdmin): ?>
            <p class="text-sm text-base-content/60 mt-2">Hiển thị 6 lịch hẹn mới nhất.</p>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

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
    <div class="bg-base-100 p-4 rounded-box shadow space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold flex items-center gap-2"><i class="ri-calendar-todo-line mr-2"></i>Lịch hẹn sắp tới</h2>
            <span class="text-sm text-base-content/60">Chỉ hiển thị lịch đang chờ hoặc đã xác nhận</span>
        </div>
        <div class="space-y-3">
            <?php foreach ($customerAppointments as $app): ?>
                <div class="card bg-base-200 shadow-sm">
                    <div class="card-body py-3 space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="font-semibold"><?= htmlspecialchars($app['service_name'] ?? 'Tư vấn') ?></div>
                            <div class="badge badge-outline capitalize"><?= htmlspecialchars($app['status']) ?></div>
                        </div>
                        <p class="text-sm text-base-content/70 flex items-center gap-2"><i class="ri-time-line"></i><?= htmlspecialchars($app['appointment_date']) ?></p>
                        <?php if (!empty($app['notes'])): ?>
                            <p class="text-sm text-base-content/70">Ghi chú: <?= htmlspecialchars($app['notes']) ?></p>
                        <?php endif; ?>
                        <form class="appointment-reschedule-form grid md:grid-cols-2 gap-3" data-id="<?= $app['id'] ?>">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token()) ?>">
                            <label class="form-control">
                                <span class="label-text">Thời gian muốn dời</span>
                                <input type="datetime-local" name="appointment_date" class="input input-bordered" value="<?= isset($app['appointment_date']) ? date('Y-m-d\\TH:i', strtotime($app['appointment_date'])) : '' ?>" required>
                            </label>
                            <label class="form-control">
                                <span class="label-text">Lý do (tuỳ chọn)</span>
                                <input type="text" name="note" class="input input-bordered" placeholder="Ví dụ: bận công việc">
                            </label>
                            <div class="md:col-span-2">
                                <button class="btn btn-primary btn-sm" type="submit"><i class="ri-calendar-check-line mr-1"></i>Gửi yêu cầu dời lịch</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($customerAppointments)): ?>
                <p class="text-sm text-base-content/60">Bạn chưa có lịch hẹn đang mở.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<section class="mb-10">
    <div class="bg-base-100 p-4 rounded-box shadow space-y-3">
        <h2 class="text-2xl font-semibold flex items-center gap-2"><i class="ri-file-list-3-line mr-2"></i>Lịch sử sử dụng dịch vụ</h2>
        <p class="text-sm text-base-content/60">Bao gồm các lịch hẹn đã hoàn tất, huỷ hoặc tái khám.</p>
        <div class="grid md:grid-cols-2 gap-3">
            <?php foreach ($appointmentHistory as $history): ?>
                <div class="card bg-base-200 shadow-sm">
                    <div class="card-body py-3 space-y-1">
                        <div class="flex items-center justify-between">
                            <div class="font-semibold"><?= htmlspecialchars($history['service_name'] ?? 'Tư vấn') ?></div>
                            <div class="badge badge-outline capitalize"><?= htmlspecialchars($history['status']) ?></div>
                        </div>
                        <p class="text-sm text-base-content/70 flex items-center gap-2"><i class="ri-time-line"></i><?= htmlspecialchars($history['appointment_date']) ?></p>
                        <?php if (!empty($history['doctor_name'])): ?>
                            <p class="text-sm text-base-content/70">Bác sĩ: <?= htmlspecialchars($history['doctor_name']) ?></p>
                        <?php endif; ?>
                        <?php if (!empty($history['notes'])): ?>
                            <p class="text-sm text-base-content/70">Ghi chú: <?= htmlspecialchars($history['notes']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($appointmentHistory)): ?>
                <p class="text-sm text-base-content/60">Chưa có lịch sử sử dụng dịch vụ.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>
