<?php
    $moduleLabels = [
        'services' => 'dịch vụ',
        'articles' => 'bài viết',
        'doctors' => 'bác sĩ',
        'appointments' => 'lịch hẹn',
        'users' => 'người dùng',
    ];
    $moduleLabel = $moduleLabels[$module] ?? 'mục';
?>

<section class="mb-6">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-3xl font-bold">Quản trị chi tiết</h1>
        <div class="breadcrumbs">
            <ul class="text-sm">
                <li><a href="/index.php?page=dashboard">Trang chủ</a></li>
                <li><?php
                    switch ($module) {
                        case 'services':
                            echo 'Dịch vụ';
                            break;
                        case 'articles':
                            echo 'Bài viết';
                            break;
                        case 'doctors':
                            echo 'Bác sĩ';
                            break;
                        case 'appointments':
                            echo 'Lịch hẹn';
                            break;
                        case 'users':
                            echo 'Người dùng';
                            break;
                        default:
                            echo 'Không xác định';
                            break;
                    }
                ?></li>
            </ul>
        </div>
    </div>
    <div class="tabs tabs-boxed mb-4">
        <a class="tab <?= $module === 'services' ? 'tab-active' : '' ?>" href="/index.php?page=admin&module=services">Dịch vụ</a>
        <a class="tab <?= $module === 'articles' ? 'tab-active' : '' ?>" href="/index.php?page=admin&module=articles">Bài viết</a>
        <a class="tab <?= $module === 'doctors' ? 'tab-active' : '' ?>" href="/index.php?page=admin&module=doctors">Bác sĩ</a>
        <a class="tab <?= $module === 'appointments' ? 'tab-active' : '' ?>" href="/index.php?page=admin&module=appointments">Lịch hẹn</a>
        <a class="tab <?= $module === 'users' ? 'tab-active' : '' ?>" href="/index.php?page=admin&module=users">Người dùng</a>
    </div>
</section>

<section class="bg-base-100 p-4 rounded-box shadow">
    <form class="flex flex-col md:flex-row md:items-end gap-3" method="get">
        <input type="hidden" name="page" value="admin">
        <input type="hidden" name="module" value="<?= htmlspecialchars($module) ?>">
        <label class="form-control w-full md:w-1/3">
            <span class="label-text mb-3">Từ khóa</span>
            <input class="input input-bordered" name="q" value="<?= htmlspecialchars($keyword) ?>" placeholder="Tìm kiếm tiêu đề, tên hoặc SĐT">
        </label>
        <?php if ($module === 'appointments'): ?>
            <label class="form-control w-full md:w-1/4">
                <span class="label-text mb-3">Trạng thái</span>
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

<section class="space-y-4 mt-4">
    <div class="bg-base-100 p-4 rounded-box shadow">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
            <div class="flex items-center gap-3">
                <h2 class="text-xl font-semibold">Danh sách</h2>
                <span class="text-sm">Trang <?= $page ?> / <?= $totalPages ?></span>
            </div>
            <div class="flex items-center gap-2">
                <?php if (in_array($module, ['services', 'articles', 'doctors'], true)): ?>
                    <button type="button" class="btn btn-primary btn-sm" data-open-form>+ Thêm <?= $moduleLabel ?></button>
                <?php endif; ?>
                <a class="btn bg-primary text-white btn-sm" href="/index.php?page=admin&module=<?= $module ?>"><i class="ri-refresh-line mr-1"></i>Tải lại</a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <?php if ($module === 'services'): ?>
                <table class="table">
                    <thead><tr><th>Tên</th><th>Giá</th><th>Hiển thị</th><th class="text-right">Thao tác</th></tr></thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td><?= $item['price'] ? number_format($item['price']) . ' đ' : 'Đang cập nhật' ?></td>
                                <td><?= $item['is_active'] ? 'Hiển thị' : 'Ẩn' ?></td>
                                <td class="text-right">
                                    <div class="flex gap-2 justify-end">
                                        <a class="btn btn-sm btn-primary text-white" href="/index.php?page=admin&module=services&edit_id=<?= $item['id'] ?>"><i class="ri-edit-2-line mr-1"></i>Chỉnh sửa</a>
                                        <form method="post" onsubmit="return confirm('Bạn có chắc muốn xóa dịch vụ này?');">
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token()) ?>">
                                            <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <button type="submit" class="btn btn-sm btn-error text-white"><i class="ri-delete-bin-line mr-1"></i>Xóa</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php elseif ($module === 'articles'): ?>
                <table class="table">
                    <thead><tr><th>Ảnh</th><th>Tiêu đề</th><th>Trạng thái</th><th>Tác giả</th><th class="text-right">Thao tác</th></tr></thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($item['thumbnail'])): ?>
                                        <img src="<?= htmlspecialchars($item['thumbnail']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="h-12 w-16 object-cover rounded">
                                    <?php else: ?>
                                        <div class="badge badge-ghost">Không ảnh</div>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($item['title']) ?></td>
                                <td><?= htmlspecialchars($item['status']) === 'published' ? 'Hiển thị' : 'Nháp' ?></td>
                                <td><?= htmlspecialchars($item['author_name'] ?? '') ?></td>
                                <td class="text-right">
                                    <div class="flex gap-2 justify-end">
                                        <a class="btn btn-sm btn-primary" href="/index.php?page=admin&module=articles&edit_id=<?= $item['id'] ?>"><i class="ri-edit-2-line mr-1"></i>Chỉnh sửa</a>
                                        <form method="post" onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?');">
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token()) ?>">
                                            <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <button type="submit" class="btn btn-sm btn-error text-white"><i class="ri-delete-bin-line mr-1"></i>Xóa</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php elseif ($module === 'doctors'): ?>
                <table class="table">
                    <thead><tr><th>Họ tên</th><th>Học hàm/học vị</th><th>Chuyên ngành</th><th>Ngày vào</th><th>Hiển thị</th><th class="text-right">Thao tác</th></tr></thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td class="font-semibold"><?= htmlspecialchars($item['full_name']) ?></td>
                                <td><?= htmlspecialchars($item['academic_title'] ?? 'Đang cập nhật') ?></td>
                                <td><?= htmlspecialchars($item['specialty'] ?? 'Đang cập nhật') ?></td>
                                <td><?= $item['joined_at'] ? date('d/m/Y', strtotime($item['joined_at'])) : 'Chưa cập nhật' ?></td>
                                <td><?= (int)$item['is_active'] === 1 ? 'Hiển thị' : 'Ẩn' ?></td>
                                <td class="text-right">
                                    <div class="flex gap-2 justify-end">
                                        <a class="btn btn-sm btn-primary text-white" href="/index.php?page=admin&module=doctors&edit_id=<?= $item['id'] ?>"><i class="ri-edit-2-line mr-1"></i>Chỉnh sửa</a>
                                        <form method="post" onsubmit="return confirm('Bạn có chắc muốn xóa bác sĩ này?');">
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token()) ?>">
                                            <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <button type="submit" class="btn btn-sm btn-error text-white"><i class="ri-delete-bin-line mr-1"></i>Xóa</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php elseif ($module === 'users'): ?>
                <table class="table">
                    <thead><tr><th>Họ tên</th><th>SĐT</th><th>Vai trò</th><th>Trạng thái</th><th class="text-right">Thao tác</th></tr></thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['full_name']) ?></td>
                                <td><?= htmlspecialchars($item['phone'] ?? 'Chưa cập nhật') ?></td>
                                <?php if ($item['role'] === 'admin'): ?>
                                    <td><span class="badge badge-outline capitalize badge-error">Quản trị</span></td>
                                <?php elseif ($item['role'] === 'doctor'): ?>                                
                                    <td><span class="badge badge-outline capitalize badge-warning">Bác sĩ</span></td>
                                <?php else: ?>
                                    <td><span class="badge badge-outline capitalize badge-success">Khách hàng</span></td>
                                <?php endif; ?>
                                <td><?= (int)$item['is_active'] === 1 ? 'Hoạt động' : 'Khoá' ?></td>
                                <td class="text-right">
                                    <div class="flex gap-2 justify-end">
                                        <a class="btn btn-sm btn-primary" href="/index.php?page=admin&module=users&edit_id=<?= $item['id'] ?>"><i class="ri-edit-2-line mr-1"></i>Cập nhật quyền</a>
                                        <form method="post" onsubmit="return confirm('Bạn có chắc muốn xóa người dùng này?');">
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token()) ?>">
                                            <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <button type="submit" class="btn btn-sm btn-error text-white"><i class="ri-delete-bin-line mr-1"></i>Xóa</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Khách hàng</th>
                            <th>Dịch vụ</th>
                            <th>Người phụ trách</th>
                            <th>Ngày giờ</th>
                            <th>Thay đổi gần nhất</th>
                            <th>Trạng thái</th>
                            <th class="text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['full_name']) ?></td>
                                <td><?= htmlspecialchars($item['service_name'] ?? 'Tư vấn') ?></td>
                                <td>
                                    <?php if (!empty($item['doctor_name'])): ?>
                                        <div class="">
                                            <i class="ri-user-heart-line"></i>
                                            <span><?= htmlspecialchars($item['doctor_name']) ?></span>
                                        </div>
                                    <?php else: ?>
                                        <span class="badge badge-ghost">Chưa gán</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($item['appointment_date']) ?></td>
                                <td>
                                    <?php $change = $appointmentChanges[$item['id']] ?? null; ?>
                                    <?php if ($change): ?>
                                        <div class="text-xs space-y-1">
                                            <div><strong><?= htmlspecialchars($change['new_date']) ?></strong></div>
                                            <div class="text-gray-500"><i><?= htmlspecialchars($change['old_date']) ?></i></div>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-xs text-base-content/60">Không có</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                        switch ($item['status']) {
                                            case 'completed':
                                                echo '<span class="badge badge-success badge-outline">Hoàn thành</span>';
                                                break;
                                            case 'rescheduled':
                                                echo '<span class="badge badge-warning badge-outline">Hẹn lại</span>';
                                                break;
                                            case 'cancelled':
                                                echo '<span class="badge badge-error badge-outline">Đã hủy</span>';
                                                break;
                                            case 'no_show':
                                                echo '<span class="badge badge-error badge-outline">Không đến</span>';
                                                break;
                                            case 'revisit':
                                                echo '<span class="badge badge-success badge-outline">Đã tái khám</span>';
                                                break;
                                            case 'confirmed':
                                                echo '<span class="badge badge-success badge-outline">Đã xác nhận</span>';
                                                break;
                                            case 'pending':
                                                echo '<span class="badge badge-info badge-outline">Đang chờ</span>';
                                                break;
                                            default:
                                                echo '<span class="badge badge-info badge-outline">Chưa xác định</span>';
                                                break;
                                        }
                                    ?>
                                </td>
                                <td class="text-right">
                                    <div class="flex gap-2 justify-end">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-primary"
                                            data-appointment-trigger
                                            data-id="<?= (int)$item['id'] ?>"
                                            data-name="<?= htmlspecialchars($item['full_name']) ?>"
                                            data-phone="<?= htmlspecialchars($item['phone'] ?? '') ?>"
                                            data-service="<?= htmlspecialchars($item['service_name'] ?? 'Tư vấn') ?>"
                                            data-date="<?= htmlspecialchars($item['appointment_date']) ?>"
                                            data-status="<?= htmlspecialchars($item['status']) ?>"
                                            data-doctor-id="<?= htmlspecialchars($item['doctor_id'] ?? '') ?>"
                                            data-notes="<?= htmlspecialchars($item['notes'] ?? '') ?>">
                                            <i class="ri-edit-2-line mr-1"></i>
                                            <span>Chỉnh sửa</span>
                                        </button>
                                        <form method="post" onsubmit="return confirm('Bạn có chắc muốn xóa lịch hẹn này?');">
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token()) ?>">
                                            <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <button type="submit" class="btn btn-sm btn-error text-white">
                                                <i class="ri-delete-bin-line mr-1"></i>
                                                <span>Xóa</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
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
</section>

<?php if (in_array($module, ['services', 'articles', 'doctors', 'users'], true)): ?>
<dialog id="module-form-modal"
    class="modal"
    data-auto-open="<?= $currentRecord ? 'true' : 'false' ?>"
    data-create-title="Thêm mới <?= $moduleLabel ?>"
    data-edit-title="Chỉnh sửa <?= $moduleLabel ?>"
    data-create-subtitle="Điền đầy đủ thông tin và lưu thay đổi."
    data-edit-subtitle="Cập nhật nhanh <?= $moduleLabel ?> hiện có.">
    <div class="modal-box w-11/12 max-w-4xl">
        <div class="flex items-start justify-between gap-3">
            <div>
                <h3 class="font-bold text-lg" data-form-title><?= $currentRecord ? 'Chỉnh sửa' : 'Thêm mới' ?> <?= $moduleLabel ?></h3>
                <p class="text-sm text-base-content/70" data-form-subtitle>
                    <?= $currentRecord ? 'Kiểm tra thông tin và lưu thay đổi.' : 'Thêm dữ liệu mới cho ' . $moduleLabel ?>
                </p>
            </div>
            <button type="button" class="btn btn-sm btn-ghost" data-close-modal><i class="ri-close-line text-lg"></i></button>
        </div>

        <form method="post" enctype="multipart/form-data" class="space-y-3 mt-4" data-module-form>
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token()) ?>">
            <input type="hidden" name="id" value="<?= htmlspecialchars($currentRecord['id'] ?? '') ?>">

            <?php if ($module === 'services'): ?>
                <label class="form-control">
                    <span class="label-text mb-3">Tên dịch vụ</span>
                    <input name="name" class="input input-bordered" required value="<?= htmlspecialchars($currentRecord['name'] ?? '') ?>">
                </label>
                <label class="form-control">
                    <span class="label-text mb-3">Giá tham khảo</span>
                    <input type="number" step="1000" name="price" class="input input-bordered" value="<?= htmlspecialchars($currentRecord['price'] ?? '') ?>">
                </label>
                <label class="form-control">
                    <span class="label-text mb-3">Mô tả</span>
                    <textarea name="description" class="textarea textarea-bordered" rows="3"><?= htmlspecialchars($currentRecord['description'] ?? '') ?></textarea>
                </label>
                <label class="form-control">
                    <span class="label-text mb-3">Ảnh đại diện</span>
                    <input type="file" name="thumbnail" accept="image/*" class="file-input file-input-bordered" data-file-input data-preview-target="#service-thumb-preview">
                    <p class="text-xs text-base-content/60 mt-3">Hỗ trợ PNG, JPG, GIF, WebP (tối đa 2MB)</p>
                    <img id="service-thumb-preview" data-preview-image class="mt-2 rounded-lg h-28 w-full object-cover <?= empty($currentRecord['thumbnail']) ? 'hidden' : '' ?>" src="<?= htmlspecialchars($currentRecord['thumbnail'] ?? '') ?>" alt="Xem trước ảnh dịch vụ">
                </label>
                <label class="form-control">
                    <span class="label-text mb-3">Trạng thái hiển thị</span>
                    <select name="is_active" class="select select-bordered">
                        <option value="1" <?= ($currentRecord['is_active'] ?? 1) == 1 ? 'selected' : '' ?>>Hiển thị</option>
                        <option value="0" <?= isset($currentRecord['is_active']) && (int)$currentRecord['is_active'] === 0 ? 'selected' : '' ?>>Ẩn</option>
                    </select>
                </label>
            <?php elseif ($module === 'articles'): ?>
                <label class="form-control">
                    <span class="label-text mb-3">Tiêu đề</span>
                    <input name="title" class="input input-bordered" required value="<?= htmlspecialchars($currentRecord['title'] ?? '') ?>">
                </label>
                <label class="form-control">
                    <span class="label-text mb-3">Chuyên mục</span>
                    <input name="category" class="input input-bordered" value="<?= htmlspecialchars($currentRecord['category'] ?? 'news') ?>">
                </label>
                <label class="form-control">
                    <span class="label-text mb-3">Ảnh thumbnail</span>
                    <input type="file" name="thumbnail" accept="image/*" class="file-input file-input-bordered" data-file-input data-preview-target="#article-thumb-preview">
                    <p class="text-xs text-base-content/60 mt-3">PNG, JPG, GIF, WebP (tối đa 2MB)</p>
                    <img id="article-thumb-preview" data-preview-image class="mt-2 rounded-lg h-28 w-full object-cover <?= empty($currentRecord['thumbnail']) ? 'hidden' : '' ?>" src="<?= htmlspecialchars($currentRecord['thumbnail'] ?? '') ?>" alt="Xem trước thumbnail">
                </label>
                <div class="form-control" data-wysiwyg>
                    <label class="label flex items-center justify-between">
                        <span class="label-text mb-3">Nội dung</span>
                        <span class="text-xs text-base-content/60">Hỗ trợ định dạng cơ bản</span>
                    </label>
                    <div class="wysiwyg-toolbar mb-2">
                        <button type="button" class="btn btn-xs" data-command="bold"><i class="ri-bold"></i></button>
                        <button type="button" class="btn btn-xs" data-command="italic"><i class="ri-italic"></i></button>
                        <button type="button" class="btn btn-xs" data-command="underline"><i class="ri-underline"></i></button>
                        <button type="button" class="btn btn-xs" data-command="insertUnorderedList"><i class="ri-list-unordered"></i></button>
                        <button type="button" class="btn btn-xs" data-command="insertOrderedList"><i class="ri-list-ordered"></i></button>
                        <button type="button" class="btn btn-xs" data-command="createLink"><i class="ri-link"></i></button>
                    </div>
                    <div class="wysiwyg-editor" data-editor contenteditable="true" aria-label="Soạn nội dung bài viết"><?= htmlspecialchars($currentRecord['content'] ?? '') ?></div>
                    <textarea name="content" class="textarea textarea-bordered hidden" rows="4" required><?= htmlspecialchars($currentRecord['content'] ?? '') ?></textarea>
                </div>
                <label class="form-control">
                    <span class="label-text mb-3">Trạng thái</span>
                    <select name="status" class="select select-bordered">
                        <option value="draft" <?= ($currentRecord['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Nháp</option>
                        <option value="published" <?= ($currentRecord['status'] ?? '') === 'published' ? 'selected' : '' ?>>Đăng ngay</option>
                    </select>
                </label>
            <?php elseif ($module === 'doctors'): ?>
                <label class="form-control">
                    <span class="label-text mb-3">Tài khoản bác sĩ (tùy chọn)</span>
                    <select name="user_id" class="select select-bordered">
                        <option value="">Chưa liên kết</option>
                        <?php foreach ($doctorUsers as $doctorUser): ?>
                            <option value="<?= (int)$doctorUser['id'] ?>" <?= ($currentRecord['user_id'] ?? null) == $doctorUser['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($doctorUser['full_name']) ?> - <?= htmlspecialchars($doctorUser['email'] ?? '') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p class="text-xs text-base-content/60">Chọn tài khoản có vai trò bác sĩ để đồng bộ thông tin.</p>
                </label>
                <label class="form-control">
                    <span class="label-text mb-3">Họ tên</span>
                    <input name="full_name" class="input input-bordered" required value="<?= htmlspecialchars($currentRecord['full_name'] ?? '') ?>">
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <label class="form-control">
                        <span class="label-text mb-3">Học hàm/Học vị</span>
                        <input name="academic_title" class="input input-bordered" value="<?= htmlspecialchars($currentRecord['academic_title'] ?? '') ?>">
                    </label>
                    <label class="form-control">
                        <span class="label-text mb-3">Chuyên ngành</span>
                        <input name="specialty" class="input input-bordered" value="<?= htmlspecialchars($currentRecord['specialty'] ?? '') ?>">
                    </label>
                </div>
                <label class="form-control">
                    <span class="label-text mb-3">Ảnh chân dung (tải từ máy)</span>
                    <input type="file" name="avatar_file" accept="image/*" class="file-input file-input-bordered" data-file-input data-preview-target="#doctor-avatar-preview">
                    <p class="text-xs text-base-content/60 mt-3">PNG, JPG, GIF, WebP (tối đa 2MB)</p>
                    <img id="doctor-avatar-preview" data-preview-image class="mt-2 rounded-full h-24 w-24 object-cover <?= empty($currentRecord['avatar_url']) ? 'hidden' : '' ?>" src="<?= htmlspecialchars($currentRecord['avatar_url'] ?? '') ?>" alt="Xem trước ảnh bác sĩ">
                </label>
                <label class="form-control">
                    <span class="label-text mb-3">Link ảnh chân dung</span>
                    <input name="avatar_url" class="input input-bordered" placeholder="https://..." value="<?= htmlspecialchars($currentRecord['avatar_url'] ?? '') ?>">
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <label class="form-control">
                        <span class="label-text mb-3">Ngày vào</span>
                        <input type="date" name="joined_at" class="input input-bordered" value="<?= htmlspecialchars($currentRecord['joined_at'] ?? '') ?>">
                    </label>
                    <label class="form-control">
                        <span class="label-text mb-3">Trạng thái hiển thị</span>
                        <select name="is_active" class="select select-bordered">
                            <option value="1" <?= ($currentRecord['is_active'] ?? 1) == 1 ? 'selected' : '' ?>>Hiển thị</option>
                            <option value="0" <?= isset($currentRecord['is_active']) && (int)$currentRecord['is_active'] === 0 ? 'selected' : '' ?>>Ẩn</option>
                        </select>
                    </label>
                </div>
                <label class="form-control">
                    <span class="label-text mb-3">Triết lý điều trị</span>
                    <textarea name="philosophy" class="textarea textarea-bordered" rows="3" placeholder="Tập trung vào trải nghiệm nhẹ nhàng..."><?= htmlspecialchars($currentRecord['philosophy'] ?? '') ?></textarea>
                </label>
            <?php else: ?>
                <?php if ($currentRecord): ?>
                    <div class="space-y-2">
                        <p><strong>Họ tên:</strong> <?= htmlspecialchars($currentRecord['full_name'] ?? '') ?></p>
                        <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($currentRecord['phone'] ?? '') ?></p>
                    </div>
                    <label class="form-control">
                        <span class="label-text mb-3">Vai trò</span>
                        <select name="role" class="select select-bordered" required>
                            <?php foreach (['customer' => 'Khách hàng', 'doctor' => 'Bác sĩ', 'admin' => 'Quản trị'] as $role => $label): ?>
                                <option value="<?= $role ?>" <?= ($currentRecord['role'] ?? '') === $role ? 'selected' : '' ?>><?= $label ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <span>Chọn một người dùng trong danh sách để cập nhật quyền.</span>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="pt-2">
                <button class="btn btn-primary" type="submit" <?= ($module === 'users' && !$currentRecord) ? 'disabled' : '' ?>><i class="ri-save-3-line mr-2"></i>Lưu</button>
            </div>
        </form>
    </div>
</dialog>
<?php endif; ?>

<?php if ($module === 'appointments'): ?>
<dialog id="appointment-edit-modal" class="modal">
    <div class="modal-box w-11/12 max-w-2xl">
        <div class="flex items-start justify-between gap-3">
            <div>
                <h3 class="font-bold text-lg">Cập nhật lịch hẹn</h3>
                <p class="text-sm text-base-content/70">Chỉnh sửa nhanh thông tin lịch hẹn và lưu thay đổi.</p>
            </div>
            <form method="dialog">
                <button class="btn btn-sm btn-ghost"><i class="ri-close-line text-lg"></i></button>
            </form>
        </div>

        <div class="bg-base-200 rounded-box p-3 mt-4 space-y-1 text-sm">
            <div><strong>Khách hàng:</strong> <span data-appointment-name></span> • <span data-appointment-phone></span></div>
            <div><strong>Dịch vụ:</strong> <span data-appointment-service></span></div>
            <div><strong>Thời gian:</strong> <span data-appointment-datetime></span></div>
        </div>

        <form method="post" class="space-y-3 mt-4">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token()) ?>">
            <input type="hidden" name="id" data-appointment-id>
            <label class="form-control">
                <span class="label-text mb-3">Thời gian hẹn</span>
                <input type="datetime-local" name="appointment_date" class="input input-bordered" data-appointment-date>
            </label>
            <label class="form-control">
                <span class="label-text mb-3">Trạng thái</span>
                <select name="status" class="select select-bordered" data-appointment-status>
                    <?php foreach (['pending','confirmed','rescheduled','cancelled','completed','no_show','revisit'] as $st): ?>
                        <option value="<?= $st ?>"><?= $st ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label class="form-control">
                <span class="label-text mb-3">Bác sĩ phụ trách</span>
                <select name="doctor_id" class="select select-bordered" data-appointment-doctor>
                    <option value="">Chưa gán</option>
                    <?php foreach ($doctorProfiles as $doc): ?>
                        <option value="<?= $doc['id'] ?>"><?= htmlspecialchars($doc['full_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label class="form-control">
                <span class="label-text mb-3">Ghi chú</span>
                <textarea name="notes" class="textarea textarea-bordered" rows="3" data-appointment-notes></textarea>
            </label>
            <div class="modal-action">
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                <button type="button" class="btn" data-appointment-close>Đóng</button>
            </div>
        </form>
    </div>
</dialog>
<?php endif; ?>
