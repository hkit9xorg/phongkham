<section class="mb-6">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-3xl font-bold">Quản trị chi tiết</h1>
        <div class="breadcrumbs">
            <ul class="text-sm">
                <li><a href="/index.php?page=dashboard">Dashboard</a></li>
                <li><?= htmlspecialchars($module) ?></li>
            </ul>
        </div>
    </div>
    <div class="tabs tabs-boxed mb-4">
        <a class="tab <?= $module === 'services' ? 'tab-active' : '' ?>" href="/index.php?page=admin&module=services">Dịch vụ</a>
        <a class="tab <?= $module === 'articles' ? 'tab-active' : '' ?>" href="/index.php?page=admin&module=articles">Bài viết</a>
        <a class="tab <?= $module === 'appointments' ? 'tab-active' : '' ?>" href="/index.php?page=admin&module=appointments">Lịch hẹn</a>
    </div>
</section>

<section class="bg-base-100 p-4 rounded-box shadow">
    <form class="flex flex-col md:flex-row md:items-end gap-3" method="get">
        <input type="hidden" name="page" value="admin">
        <input type="hidden" name="module" value="<?= htmlspecialchars($module) ?>">
        <label class="form-control w-full md:w-1/3">
            <span class="label-text">Từ khóa</span>
            <input class="input input-bordered" name="q" value="<?= htmlspecialchars($keyword) ?>" placeholder="Tìm kiếm tiêu đề, tên hoặc SĐT">
        </label>
        <?php if ($module === 'appointments'): ?>
            <label class="form-control w-full md:w-1/4">
                <span class="label-text">Trạng thái</span>
                <select name="status" class="select select-bordered">
                    <option value="">Tất cả</option>
                    <?php foreach (['pending','confirmed','rescheduled','cancelled','completed','no_show','revisit'] as $st): ?>
                        <option value="<?= $st ?>" <?= $status === $st ? 'selected' : '' ?>><?= $st ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        <?php endif; ?>
        <button class="btn btn-primary" type="submit"><i class="ri-search-line mr-2"></i>Lọc</button>
    </form>
</section>

<section class="grid md:grid-cols-3 gap-4 mt-4">
    <div class="bg-base-100 p-4 rounded-box shadow md:col-span-2">
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-xl font-semibold">Danh sách</h2>
            <span class="text-sm">Trang <?= $page ?> / <?= $totalPages ?></span>
        </div>
        <div class="overflow-x-auto">
            <?php if ($module === 'services'): ?>
                <table class="table">
                    <thead><tr><th>Tên</th><th>Giá</th><th>Hiển thị</th><th></th></tr></thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td><?= $item['price'] ? number_format($item['price']) . ' đ' : 'Đang cập nhật' ?></td>
                                <td><?= $item['is_active'] ? 'Hiển thị' : 'Ẩn' ?></td>
                                <td><a class="link" href="/index.php?page=admin&module=services&edit_id=<?= $item['id'] ?>">Chỉnh sửa</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php elseif ($module === 'articles'): ?>
                <table class="table">
                    <thead><tr><th>Tiêu đề</th><th>Trạng thái</th><th>Tác giả</th><th></th></tr></thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['title']) ?></td>
                                <td><?= htmlspecialchars($item['status']) ?></td>
                                <td><?= htmlspecialchars($item['author_name'] ?? '') ?></td>
                                <td><a class="link" href="/index.php?page=admin&module=articles&edit_id=<?= $item['id'] ?>">Chỉnh sửa</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <table class="table">
                    <thead><tr><th>Khách hàng</th><th>Dịch vụ</th><th>Ngày giờ</th><th>Trạng thái</th><th></th></tr></thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['full_name']) ?></td>
                                <td><?= htmlspecialchars($item['service_name'] ?? 'Tư vấn') ?></td>
                                <td><?= htmlspecialchars($item['appointment_date']) ?></td>
                                <td><?= htmlspecialchars($item['status']) ?></td>
                                <td><a class="link" href="/index.php?page=admin&module=appointments&edit_id=<?= $item['id'] ?>">Chỉnh sửa</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        <div class="flex justify-between items-center mt-4">
            <div> Tổng: <?= $total ?> mục</div>
            <div class="join">
                <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                    <a class="join-item btn <?= $p === $page ? 'btn-active' : '' ?>" href="/index.php?page=admin&module=<?= $module ?>&q=<?= urlencode($keyword) ?>&status=<?= urlencode($status) ?>&p=<?= $p ?>"><?= $p ?></a>
                <?php endfor; ?>
            </div>
        </div>
    </div>
    <div class="bg-base-100 p-4 rounded-box shadow">
        <h2 class="text-xl font-semibold mb-3"><?= $currentRecord ? 'Chỉnh sửa' : 'Thêm mới' ?></h2>
        <form method="post" class="space-y-3">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token()) ?>">
            <input type="hidden" name="id" value="<?= htmlspecialchars($currentRecord['id'] ?? '') ?>">
            <?php if ($module === 'services'): ?>
                <label class="form-control">
                    <span class="label-text">Tên dịch vụ</span>
                    <input name="name" class="input input-bordered" required value="<?= htmlspecialchars($currentRecord['name'] ?? '') ?>">
                </label>
                <label class="form-control">
                    <span class="label-text">Giá tham khảo</span>
                    <input type="number" step="1000" name="price" class="input input-bordered" value="<?= htmlspecialchars($currentRecord['price'] ?? '') ?>">
                </label>
                <label class="form-control">
                    <span class="label-text">Mô tả</span>
                    <textarea name="description" class="textarea textarea-bordered" rows="3"><?= htmlspecialchars($currentRecord['description'] ?? '') ?></textarea>
                </label>
                <label class="form-control">
                    <span class="label-text">Trạng thái hiển thị</span>
                    <select name="is_active" class="select select-bordered">
                        <option value="1" <?= ($currentRecord['is_active'] ?? 1) == 1 ? 'selected' : '' ?>>Hiển thị</option>
                        <option value="0" <?= isset($currentRecord['is_active']) && (int)$currentRecord['is_active'] === 0 ? 'selected' : '' ?>>Ẩn</option>
                    </select>
                </label>
            <?php elseif ($module === 'articles'): ?>
                <label class="form-control">
                    <span class="label-text">Tiêu đề</span>
                    <input name="title" class="input input-bordered" required value="<?= htmlspecialchars($currentRecord['title'] ?? '') ?>">
                </label>
                <label class="form-control">
                    <span class="label-text">Chuyên mục</span>
                    <input name="category" class="input input-bordered" value="<?= htmlspecialchars($currentRecord['category'] ?? 'news') ?>">
                </label>
                <label class="form-control">
                    <span class="label-text">Nội dung</span>
                    <textarea name="content" class="textarea textarea-bordered" rows="4" required><?= htmlspecialchars($currentRecord['content'] ?? '') ?></textarea>
                </label>
                <label class="form-control">
                    <span class="label-text">Trạng thái</span>
                    <select name="status" class="select select-bordered">
                        <option value="draft" <?= ($currentRecord['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Nháp</option>
                        <option value="published" <?= ($currentRecord['status'] ?? '') === 'published' ? 'selected' : '' ?>>Đăng ngay</option>
                    </select>
                </label>
            <?php else: ?>
                <?php if ($currentRecord): ?>
                    <div class="space-y-2">
                        <p><strong>Khách hàng:</strong> <?= htmlspecialchars($currentRecord['full_name']) ?> | <?= htmlspecialchars($currentRecord['phone']) ?></p>
                        <p><strong>Dịch vụ:</strong> <?= htmlspecialchars($currentRecord['service_name'] ?? 'Tư vấn') ?></p>
                        <p><strong>Thời gian:</strong> <?= htmlspecialchars($currentRecord['appointment_date']) ?></p>
                    </div>
                    <label class="form-control">
                        <span class="label-text">Thời gian hẹn</span>
                        <input type="datetime-local" name="appointment_date" class="input input-bordered" value="<?= isset($currentRecord['appointment_date']) ? date('Y-m-d\TH:i', strtotime($currentRecord['appointment_date'])) : '' ?>">
                    </label>
                    <label class="form-control">
                        <span class="label-text">Trạng thái</span>
                        <select name="status" class="select select-bordered">
                            <?php foreach (['pending','confirmed','rescheduled','cancelled','completed','no_show','revisit'] as $st): ?>
                                <option value="<?= $st ?>" <?= ($currentRecord['status'] ?? '') === $st ? 'selected' : '' ?>><?= $st ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label class="form-control">
                        <span class="label-text">Bác sĩ phụ trách</span>
                        <select name="doctor_id" class="select select-bordered">
                            <option value="">Chưa gán</option>
                            <?php foreach ($doctors as $doc): ?>
                                <option value="<?= $doc['id'] ?>" <?= ($currentRecord['doctor_id'] ?? null) == $doc['id'] ? 'selected' : '' ?>><?= htmlspecialchars($doc['full_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label class="form-control">
                        <span class="label-text">Ghi chú</span>
                        <textarea name="notes" class="textarea textarea-bordered" rows="3"><?= htmlspecialchars($currentRecord['notes'] ?? '') ?></textarea>
                    </label>
                <?php else: ?>
                    <p>Chọn một lịch hẹn để chỉnh sửa.</p>
                <?php endif; ?>
            <?php endif; ?>
            <div class="pt-2">
                <button class="btn btn-primary" type="submit"><i class="ri-save-3-line mr-2"></i>Lưu</button>
            </div>
        </form>
    </div>
</section>
