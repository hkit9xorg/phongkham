<section class="hero bg-base-100 rounded-2xl p-10 shadow mb-8">
    <div class="grid md:grid-cols-2 gap-6 items-center">
        <div>
            <p class="badge badge-primary mb-2">Nha khoa số hóa</p>
            <h1 class="text-4xl font-bold mb-3">Chăm sóc răng miệng toàn diện cho cả gia đình</h1>
            <p class="text-lg mb-4">Đặt lịch nhanh, quản lý hồ sơ và theo dõi lịch tái khám ngay trên hệ thống SmileCare Clinic.</p>
            <div class="flex flex-wrap gap-3">
                <a href="#booking" class="btn btn-primary"><i class="ri-calendar-check-line mr-2"></i>Đặt lịch ngay</a>
                <a href="#services" class="btn btn-ghost"><i class="ri-hand-heart-line mr-2"></i>Xem dịch vụ</a>
            </div>
        </div>
        <div class="text-center">
            <img src="https://placehold.co/480x320?text=Dental+Care" alt="Dental" class="rounded-xl shadow-lg mx-auto">
        </div>
    </div>
</section>

<section class="grid md:grid-cols-4 gap-4 mb-10">
    <div class="stat shadow bg-base-100">
        <div class="stat-figure text-primary"><i class="ri-user-smile-line text-3xl"></i></div>
        <div class="stat-title">Khách hàng</div>
        <div class="stat-value"><?= number_format($stats['customers']) ?></div>
    </div>
    <div class="stat shadow bg-base-100">
        <div class="stat-figure text-secondary"><i class="ri-stethoscope-line text-3xl"></i></div>
        <div class="stat-title">Dịch vụ</div>
        <div class="stat-value"><?= number_format($stats['services']) ?></div>
    </div>
    <div class="stat shadow bg-base-100">
        <div class="stat-figure text-accent"><i class="ri-file-list-3-line text-3xl"></i></div>
        <div class="stat-title">Bài viết</div>
        <div class="stat-value"><?= number_format($stats['articles']) ?></div>
    </div>
    <div class="stat shadow bg-base-100">
        <div class="stat-figure text-info"><i class="ri-calendar-check-line text-3xl"></i></div>
        <div class="stat-title">Lịch hẹn</div>
        <div class="stat-value"><?= number_format($stats['appointments']) ?></div>
    </div>
</section>

<section id="services" class="mb-10">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold"><i class="ri-shield-heart-line mr-2"></i>Dịch vụ nha khoa</h2>
        <a class="link" href="#booking">Đặt lịch tư vấn</a>
    </div>
    <div class="grid md:grid-cols-3 gap-4">
        <?php foreach ($services as $service): ?>
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h3 class="card-title"><?= htmlspecialchars($service['name']) ?></h3>
                    <p><?= nl2br(htmlspecialchars($service['description'])) ?></p>
                    <?php if (!empty($service['price'])): ?>
                        <div class="badge badge-outline">Giá từ <?= number_format($service['price']) ?> đ</div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section id="booking" class="mb-10">
    <div class="grid md:grid-cols-2 gap-6">
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title"><i class="ri-calendar-event-line mr-2"></i>Đặt lịch nhanh</h2>
                <p class="text-sm text-gray-500 mb-2">Điền thông tin để được gọi xác nhận. Mọi yêu cầu sẽ ở trạng thái "Chờ xác nhận".</p>
                <form id="booking-form" class="space-y-3">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token()) ?>">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Họ tên *</span></label>
                        <input type="text" name="full_name" class="input input-bordered" required>
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Số điện thoại *</span></label>
                        <input type="tel" name="phone" class="input input-bordered" required pattern="[0-9+ ]{8,15}">
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Email</span></label>
                        <input type="email" name="email" class="input input-bordered" placeholder="you@example.com">
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Chọn dịch vụ</span></label>
                        <select name="service_id" class="select select-bordered">
                            <option value="">Tư vấn chung</option>
                            <?php foreach ($services as $service): ?>
                                <option value="<?= $service['id'] ?>"><?= htmlspecialchars($service['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Thời gian mong muốn *</span></label>
                        <input type="datetime-local" name="appointment_date" class="input input-bordered" required>
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Ghi chú triệu chứng</span></label>
                        <textarea name="notes" class="textarea textarea-bordered" rows="3" placeholder="Đau nhức, ê buốt..."></textarea>
                    </div>
                    <button class="btn btn-primary w-full" type="submit"><i class="ri-send-plane-line mr-2"></i>Gửi yêu cầu</button>
                </form>
            </div>
        </div>
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title"><i class="ri-information-line mr-2"></i>Quy trình tiếp nhận</h2>
                <ul class="steps steps-vertical">
                    <li class="step step-primary">Tiếp nhận yêu cầu</li>
                    <li class="step step-primary">Gọi xác nhận & sắp lịch</li>
                    <li class="step">Khám & điều trị</li>
                    <li class="step">Tái khám (nếu cần)</li>
                </ul>
                <div class="alert alert-info mt-4">
                    <i class="ri-lock-line"></i>
                    <span>Khách có tài khoản vui lòng <a class="link" href="/index.php?page=login">đăng nhập</a> để theo dõi lịch hẹn và hồ sơ.</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="articles" class="mb-10">
    <h2 class="text-2xl font-semibold mb-4"><i class="ri-article-line mr-2"></i>Tin tức & Tư vấn</h2>
    <div class="grid md:grid-cols-3 gap-4">
        <?php foreach ($articles as $article): ?>
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h3 class="card-title"><?= htmlspecialchars($article['title']) ?></h3>
                    <p class="text-sm text-gray-500">Tác giả: <?= htmlspecialchars($article['author_name'] ?? 'Ẩn danh') ?></p>
                    <p><?= nl2br(htmlspecialchars(mb_substr($article['content'], 0, 160))) ?>...</p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
