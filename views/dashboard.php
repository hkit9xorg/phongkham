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

<section class="mb-10">
    <h2 class="text-2xl font-semibold mb-4"><i class="ri-calendar-line mr-2"></i>Danh sách lịch hẹn</h2>
    <div class="overflow-x-auto bg-base-100 p-4 rounded-box shadow">
        <table class="table" id="appointment-table">
            <thead>
                <tr>
                    <th>Khách hàng</th><th>Dịch vụ</th><th>Ngày giờ</th><th>Trạng thái</th><th>Bác sĩ</th><th>Ghi chú</th>
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
