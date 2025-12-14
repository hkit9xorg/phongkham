<?php
$heroSlides = [
    [
        'title' => 'Nụ cười khỏe đẹp với công nghệ số',
        'desc' => 'Tư vấn, đặt lịch và theo dõi lộ trình điều trị ngay trên nền tảng SmileCare.',
        'image' => 'https://images.unsplash.com/photo-1527610276290-f1d7c7b7e508?auto=format&fit=crop&w=1200&q=80',
    ],
    [
        'title' => 'Đội ngũ bác sĩ tận tâm',
        'desc' => 'Chuyên gia nhiều năm kinh nghiệm, luôn đồng hành cùng khách hàng.',
        'image' => 'https://images.unsplash.com/photo-1631815588090-d4bfec5b1ed1?auto=format&fit=crop&w=1200&q=80',
    ],
    [
        'title' => 'Không gian thư giãn, thiết bị hiện đại',
        'desc' => 'Trải nghiệm dịch vụ nha khoa an toàn, chuẩn quốc tế.',
        'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=1200&q=80',
    ],
];

$quickLinks = [
    ['label' => 'Đặt lịch tư vấn', 'icon' => 'ri-calendar-event-fill', 'href' => '#booking'],
    ['label' => 'Bảng giá', 'icon' => 'ri-price-tag-3-fill', 'href' => '#pricing'],
    ['label' => 'Bác sĩ', 'icon' => 'ri-user-voice-fill', 'href' => '#team'],
    ['label' => 'Đối tác', 'icon' => 'ri-hand-heart-fill', 'href' => '#partners'],
];

$featuredServices = array_slice($services ?? [], 0, 6);
$teamMembers = array_map(function ($doctor) {
    return [
        'name' => $doctor['full_name'] ?? 'Bác sĩ SmileCare',
        'role' => 'Bác sĩ điều trị',
        'email' => $doctor['email'] ?? '',
        'avatar' => 'https://api.dicebear.com/7.x/identicon/svg?seed=' . urlencode($doctor['email'] ?? $doctor['full_name'] ?? 'doctor'),
    ];
}, $doctors ?? []);

if (empty($teamMembers)) {
    $teamMembers = [
        [
            'name' => 'BS. Nguyễn Minh Châu',
            'role' => 'Chuyên gia phục hình',
            'avatar' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=600&q=80',
        ],
        [
            'name' => 'BS. Trần Gia Hưng',
            'role' => 'Chỉnh nha & Implant',
            'avatar' => 'https://images.unsplash.com/photo-1544723795-3fb6469f5b39?auto=format&fit=crop&w=600&q=80',
        ],
        [
            'name' => 'BS. Phạm Bảo Ngọc',
            'role' => 'Điều trị tổng quát',
            'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=600&q=80',
        ],
    ];
}
?>

<section class="grid gap-6 lg:grid-cols-12 items-center">
    <div class="lg:col-span-7 space-y-6">
        <div class="badge badge-outline">Nha khoa số hóa • Chăm sóc tận tâm</div>
        <h1 class="text-4xl md:text-5xl font-bold leading-tight">Chăm sóc răng miệng toàn diện cho cả gia đình</h1>
        <p class="text-lg text-base-content/70">Đặt lịch nhanh, lưu trữ hồ sơ và nhận nhắc lịch tái khám tự động. SmileCare Clinic luôn sẵn sàng đồng hành cùng bạn trên hành trình xây dựng nụ cười khỏe đẹp.</p>
        <div class="flex flex-wrap gap-3">
            <a href="#booking" class="btn btn-primary btn-lg"><i class="ri-calendar-check-line mr-2"></i>Đặt lịch ngay</a>
            <a href="#services" class="btn btn-ghost btn-lg"><i class="ri-hand-heart-line mr-2"></i>Xem dịch vụ</a>
        </div>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div class="p-4 rounded-2xl bg-base-100 shadow">
                <div class="flex items-center gap-2 text-primary"><i class="ri-shield-star-fill"></i><span>Giấy phép hành nghề</span></div>
                <p class="text-base-content/70">Quy trình chuẩn Y tế, bảo mật thông tin khách hàng.</p>
            </div>
            <div class="p-4 rounded-2xl bg-base-100 shadow">
                <div class="flex items-center gap-2 text-primary"><i class="ri-smartphone-line"></i><span>Theo dõi online</span></div>
                <p class="text-base-content/70">Nhận thông báo nhắc lịch, kết quả và dặn dò trên ứng dụng.</p>
            </div>
        </div>
    </div>
    <div class="lg:col-span-5">
        <div class="card bg-base-100 shadow-xl overflow-hidden">
            <div class="card-body p-0">
                <div class="auto-slider" data-auto-slider data-interval="5000">
                    <?php foreach ($heroSlides as $index => $slide): ?>
                        <div class="hero-slide" data-slide <?= $index === 0 ? 'data-active' : '' ?>>
                            <div class="relative">
                                <img src="<?= htmlspecialchars($slide['image']) ?>" class="h-72 w-full object-cover" alt="Slide">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-6 text-white space-y-2">
                                    <h2 class="text-2xl font-bold"><?= htmlspecialchars($slide['title']) ?></h2>
                                    <p class="text-sm text-white/80"><?= htmlspecialchars($slide['desc']) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="flex justify-end gap-2 p-4">
                        <button class="btn btn-circle btn-sm" data-prev aria-label="Slide trước"><i class="ri-arrow-left-s-line"></i></button>
                        <button class="btn btn-circle btn-sm" data-next aria-label="Slide sau"><i class="ri-arrow-right-s-line"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="grid md:grid-cols-4 gap-4" id="pricing">
    <?php foreach ($quickLinks as $link): ?>
        <a href="<?= $link['href'] ?>" class="group p-4 rounded-2xl bg-base-100 shadow hover:-translate-y-1 transition">
            <div class="flex items-center gap-3">
                <div class="h-12 w-12 rounded-xl bg-primary/10 text-primary grid place-items-center text-2xl group-hover:bg-primary group-hover:text-white transition">
                    <i class="<?= $link['icon'] ?>"></i>
                </div>
                <div>
                    <p class="font-semibold"><?= htmlspecialchars($link['label']) ?></p>
                    <p class="text-sm text-base-content/70">Xem chi tiết</p>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
</section>

<section id="services" class="space-y-4">
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <p class="badge badge-primary">Dịch vụ nổi bật</p>
            <h2 class="text-2xl font-semibold">Chuyên sâu cho từng nhu cầu</h2>
        </div>
        <div class="flex gap-2">
            <button class="btn btn-outline btn-sm" data-target="services-slider" data-prev><i class="ri-arrow-left-s-line"></i></button>
            <button class="btn btn-outline btn-sm" data-target="services-slider" data-next><i class="ri-arrow-right-s-line"></i></button>
        </div>
    </div>
    <div class="auto-slider" id="services-slider" data-auto-slider data-interval="4500">
        <div class="slider-track flex gap-4 overflow-hidden" data-track>
            <?php foreach ($featuredServices as $index => $service): ?>
                <div class="card bg-base-100 shadow service-card min-w-[280px] md:min-w-[320px]" data-slide <?= $index === 0 ? 'data-active' : '' ?> data-group="services-slider">
                    <div class="card-body space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="h-12 w-12 rounded-xl bg-accent/10 text-accent grid place-items-center text-2xl"><i class="ri-shield-star-line"></i></div>
                            <h3 class="card-title text-lg"><?= htmlspecialchars($service['name']) ?></h3>
                        </div>
                        <p class="text-base-content/70 line-clamp-3"><?= nl2br(htmlspecialchars($service['description'])) ?></p>
                        <?php if (!empty($service['price'])): ?>
                            <div class="badge badge-outline">Giá từ <?= number_format($service['price']) ?> đ</div>
                        <?php endif; ?>
                        <a href="#booking" class="btn btn-primary btn-sm">Đặt lịch ngay</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section id="about" class="grid lg:grid-cols-2 gap-8 items-center">
    <div class="space-y-4">
        <p class="badge badge-secondary">Giới thiệu</p>
        <h2 class="text-3xl font-bold">Chúng tôi chăm sóc nụ cười bằng sự tận tâm và công nghệ</h2>
        <p class="text-base-content/70">SmileCare Clinic áp dụng quy trình chuẩn quốc tế, kết hợp hệ thống quản lý hồ sơ điện tử giúp bác sĩ theo dõi sát sao từng ca điều trị. Bạn có thể đặt lịch, xem kết quả, nhận tư vấn và nhắc nhở tái khám hoàn toàn trực tuyến.</p>
        <div class="grid sm:grid-cols-2 gap-3">
            <div class="p-4 rounded-2xl bg-base-100 shadow flex items-start gap-3">
                <div class="h-10 w-10 rounded-lg bg-primary/10 text-primary grid place-items-center"><i class="ri-heart-3-line"></i></div>
                <div>
                    <p class="font-semibold">Chăm sóc cá nhân hóa</p>
                    <p class="text-sm text-base-content/70">Phác đồ điều trị rõ ràng, cập nhật theo tiến triển thực tế.</p>
                </div>
            </div>
            <div class="p-4 rounded-2xl bg-base-100 shadow flex items-start gap-3">
                <div class="h-10 w-10 rounded-lg bg-primary/10 text-primary grid place-items-center"><i class="ri-shield-check-line"></i></div>
                <div>
                    <p class="font-semibold">An toàn & vệ sinh</p>
                    <p class="text-sm text-base-content/70">Tiệt trùng tiêu chuẩn, thiết bị hiện đại hỗ trợ điều trị nhẹ nhàng.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="relative">
        <img src="https://images.unsplash.com/photo-1582719478171-2f2df12c1a0d?auto=format&fit=crop&w=1200&q=80" class="rounded-3xl shadow-xl" alt="Phòng khám">
        <div class="absolute -bottom-6 -left-6 bg-base-100 shadow-xl p-4 rounded-2xl flex items-center gap-3">
            <div class="avatar">
                <div class="w-12 rounded-full"><img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=600&q=80" alt="doctor"></div>
            </div>
            <div>
                <p class="font-semibold">BS. Hạnh Phúc</p>
                <p class="text-sm text-base-content/70">Trưởng bộ phận điều trị</p>
            </div>
        </div>
    </div>
</section>

<section id="team" class="space-y-4">
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <p class="badge badge-accent">Đội ngũ bác sĩ</p>
            <h2 class="text-2xl font-semibold">Chuyên môn vững vàng, tận tâm với khách hàng</h2>
        </div>
        <div class="flex gap-2">
            <button class="btn btn-outline btn-sm" data-target="team-slider" data-prev><i class="ri-arrow-left-s-line"></i></button>
            <button class="btn btn-outline btn-sm" data-target="team-slider" data-next><i class="ri-arrow-right-s-line"></i></button>
        </div>
    </div>
    <div class="auto-slider" id="team-slider" data-auto-slider data-interval="5000">
        <div class="slider-track flex gap-4 overflow-hidden" data-track>
            <?php foreach ($teamMembers as $index => $member): ?>
                <div class="card bg-base-100 shadow team-card min-w-[260px]" data-slide <?= $index === 0 ? 'data-active' : '' ?> data-group="team-slider">
                    <div class="card-body items-center text-center space-y-3">
                        <div class="avatar">
                            <div class="w-20 h-20 rounded-full ring ring-primary ring-offset-2">
                                <img src="<?= htmlspecialchars($member['avatar']) ?>" alt="<?= htmlspecialchars($member['name']) ?>">
                            </div>
                        </div>
                        <h3 class="font-semibold text-lg"><?= htmlspecialchars($member['name']) ?></h3>
                        <p class="text-sm text-base-content/70"><?= htmlspecialchars($member['role'] ?? 'Bác sĩ điều trị') ?></p>
                        <?php if (!empty($member['email'])): ?>
                            <p class="text-xs text-base-content/60"><i class="ri-mail-line mr-1"></i><?= htmlspecialchars($member['email']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="grid md:grid-cols-4 gap-4">
    <div class="stat shadow bg-base-100">
        <div class="stat-figure text-primary"><i class="ri-user-smile-line text-3xl"></i></div>
        <div class="stat-title">Khách hàng</div>
        <div class="stat-value"><?= number_format($stats['customers']) ?></div>
    </div>
    <div class="stat shadow bg-base-100">
        <div class="stat-figure text-secondary"><i class="ri-shield-star-line text-3xl"></i></div>
        <div class="stat-title">Dịch vụ</div>
        <div class="stat-value"><?= number_format($stats['services']) ?></div>
    </div>
    <div class="stat shadow bg-base-100">
        <div class="stat-figure text-accent"><i class="ri-user-voice-line text-3xl"></i></div>
        <div class="stat-title">Bác sĩ</div>
        <div class="stat-value"><?= number_format($stats['doctors']) ?></div>
    </div>
    <div class="stat shadow bg-base-100">
        <div class="stat-figure text-info"><i class="ri-calendar-check-line text-3xl"></i></div>
        <div class="stat-title">Ca điều trị</div>
        <div class="stat-value"><?= number_format($stats['appointments']) ?></div>
    </div>
</section>

<section id="articles" class="space-y-4">
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <p class="badge badge-outline">Bài viết mới</p>
            <h2 class="text-2xl font-semibold">Kiến thức chăm sóc răng miệng</h2>
        </div>
        <div class="flex gap-2">
            <button class="btn btn-outline btn-sm" data-target="article-slider" data-prev><i class="ri-arrow-left-s-line"></i></button>
            <button class="btn btn-outline btn-sm" data-target="article-slider" data-next><i class="ri-arrow-right-s-line"></i></button>
        </div>
    </div>
    <div class="auto-slider" id="article-slider" data-auto-slider data-interval="5000">
        <div class="slider-track flex gap-4 overflow-hidden" data-track>
            <?php foreach ($articles as $index => $article): ?>
                <div class="card bg-base-100 shadow article-card min-w-[280px] md:min-w-[320px]" data-slide <?= $index === 0 ? 'data-active' : '' ?> data-group="article-slider">
                    <?php if (!empty($article['thumbnail'])): ?>
                        <img src="<?= htmlspecialchars($article['thumbnail']) ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="h-40 w-full object-cover">
                    <?php endif; ?>
                    <div class="card-body space-y-3">
                        <div class="flex items-center gap-2 text-sm text-base-content/60">
                            <i class="ri-user-line"></i>
                            <span><?= htmlspecialchars($article['author_name'] ?? 'Ẩn danh') ?></span>
                        </div>
                        <h3 class="card-title text-lg"><?= htmlspecialchars($article['title']) ?></h3>
                        <?php $excerpt = strip_tags($article['content']); ?>
                        <p class="text-base-content/70 line-clamp-3"><?= nl2br(htmlspecialchars(mb_substr($excerpt, 0, 160))) ?>...</p>
                        <a href="#" class="link">Đọc tiếp</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section id="booking" class="grid lg:grid-cols-2 gap-8 items-start">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body space-y-3">
            <p class="badge badge-primary">Đặt lịch hẹn</p>
            <h2 class="card-title text-2xl">Đặt lịch nhanh chóng</h2>
            <p class="text-base-content/70">Điền thông tin để được gọi xác nhận. Mọi yêu cầu sẽ ở trạng thái "Chờ xác nhận".</p>
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
                    <div class="flex items-center gap-2 mt-2">
                        <button type="button" id="suggest-slot-btn" class="btn btn-outline btn-sm"><i class="ri-magic-line mr-1"></i>Gợi ý giờ trống</button>
                        <span id="suggest-meta" class="text-xs text-gray-500"></span>
                    </div>
                    <div id="slot-suggestions" class="flex flex-wrap gap-2 mt-2"></div>
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Ghi chú triệu chứng</span></label>
                    <textarea name="notes" class="textarea textarea-bordered" rows="3" placeholder="Đau nhức, ê buốt..."></textarea>
                </div>
                <button class="btn btn-primary w-full" type="submit"><i class="ri-send-plane-line mr-2"></i>Gửi yêu cầu</button>
            </form>
        </div>
    </div>
    <div class="space-y-4">
        <div class="p-6 bg-primary text-primary-content rounded-3xl shadow-lg space-y-2">
            <h3 class="text-xl font-semibold flex items-center gap-2"><i class="ri-service-line"></i>Quy trình tiếp nhận</h3>
            <ol class="list-decimal list-inside space-y-1 text-sm">
                <li>Tiếp nhận yêu cầu và gọi xác nhận.</li>
                <li>Sắp xếp lịch, gửi thông tin chuẩn bị.</li>
                <li>Khám, điều trị và hướng dẫn chăm sóc.</li>
                <li>Tái khám (nếu cần) và theo dõi định kỳ.</li>
            </ol>
            <p class="text-sm opacity-80">Khách có tài khoản vui lòng <a class="link link-hover text-white font-semibold" href="/index.php?page=login">đăng nhập</a> để theo dõi lịch hẹn và hồ sơ.</p>
        </div>
        <div class="grid sm:grid-cols-2 gap-4">
            <div class="p-4 rounded-2xl bg-base-100 shadow">
                <div class="flex items-center gap-2 text-primary"><i class="ri-map-pin-2-line"></i><span>Địa chỉ</span></div>
                <p class="text-sm text-base-content/70">123 Lê Lợi, Quận 1, TP.HCM</p>
            </div>
            <div class="p-4 rounded-2xl bg-base-100 shadow">
                <div class="flex items-center gap-2 text-primary"><i class="ri-time-line"></i><span>Giờ làm việc</span></div>
                <p class="text-sm text-base-content/70">08:00 - 20:00 (T2 - CN)</p>
            </div>
        </div>
    </div>
</section>

<section id="partners" class="bg-base-100 shadow-inner rounded-3xl p-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-2 text-primary font-semibold"><i class="ri-hand-heart-line"></i>Đối tác & khách hàng</div>
        <div class="flex flex-wrap gap-4 text-3xl text-base-content/50">
            <i class="ri-shake-hands-line"></i>
            <i class="ri-home-smile-line"></i>
            <i class="ri-bank-card-line"></i>
            <i class="ri-hand-heart-line"></i>
            <i class="ri-shield-cross-line"></i>
        </div>
    </div>
</section>
