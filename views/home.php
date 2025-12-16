<?php
$heroSlides = [
    [
        'title' => 'Nụ cười khỏe đẹp với công nghệ số',
        'desc' => 'Tư vấn, đặt lịch và theo dõi lộ trình điều trị ngay trên nền tảng SmileCare.',
        'image' => 'https://trungtamnhakhoaquocte.com/wp-content/uploads/2024/11/241122_1_qte.png',
    ],
    [
        'title' => 'Đội ngũ bác sĩ tận tâm',
        'desc' => 'Chuyên gia nhiều năm kinh nghiệm, luôn đồng hành cùng khách hàng.',
        'image' => 'https://trungtamnhakhoaquocte.com/wp-content/uploads/2024/11/241120_3_qte-1024x390.png',
    ],
    [
        'title' => 'Không gian thư giãn, thiết bị hiện đại',
        'desc' => 'Trải nghiệm dịch vụ nha khoa an toàn, chuẩn quốc tế.',
        'image' => 'https://trungtamnhakhoaquocte.com/wp-content/uploads/2024/11/241101_1_haviqte-1.png',
    ],
    [
        'title' => 'Không gian thư giãn, thiết bị hiện đại',
        'desc' => 'Trải nghiệm dịch vụ nha khoa an toàn, chuẩn quốc tế.',
        'image' => 'https://trungtamnhakhoaquocte.com/wp-content/uploads/2024/11/241115_1_qte-1.png',
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
    $rolePieces = array_filter([
        $doctor['academic_title'] ?? '',
        $doctor['specialty'] ?? '',
    ]);

    return [
        'name' => $doctor['full_name'] ?? 'Bác sĩ SmileCare',
        'role' => $rolePieces ? implode(' • ', $rolePieces) : 'Bác sĩ điều trị',
        'avatar' => $doctor['avatar_url'] ?? 'https://api.dicebear.com/7.x/identicon/svg?seed=' . urlencode($doctor['full_name'] ?? 'doctor'),
        'philosophy' => $doctor['philosophy'] ?? '',
        'joined_at' => $doctor['joined_at'] ?? null,
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

<section class="items-center">
    <div class="col-12 mb-6">
        <div class="card bg-base-100 shadow-xl overflow-hidden">
            <div class="card-body p-0">
                <div class="auto-slider" data-auto-slider data-interval="5000">
                    <?php foreach ($heroSlides as $index => $slide): ?>
                        <div class="hero-slide" data-slide <?= $index === 0 ? 'data-active' : '' ?>>
                            <div class="relative">
                                <img src="<?= htmlspecialchars($slide['image']) ?>" class="h-[32rem] w-full object-cover" alt="Slide">
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
            <h2 class="text-3xl font-semibold">DỊCH VỤ NHA KHOA NỔI BẬT</h2>
        </div>
        <div class="flex gap-2">
            <button class="btn btn-outline btn-sm" data-target="services-slider" data-prev><i class="ri-arrow-left-s-line"></i></button>
            <button class="btn btn-outline btn-sm" data-target="services-slider" data-next><i class="ri-arrow-right-s-line"></i></button>
        </div>
    </div>
    <div class="auto-slider" id="services-slider" data-auto-slider data-interval="4500" data-visible="4">
        <div class="slider-track flex gap-4 overflow-hidden" data-track>
            <?php foreach ($featuredServices as $index => $service): ?>
                <div class="card bg-base-100 shadow service-card min-w-[220px] md:min-w-[240px] lg:min-w-[260px]" data-slide <?= $index === 0 ? 'data-active' : '' ?> data-group="services-slider">
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

<section id="about" class="grid lg:grid-cols-3 gap-12 items-center bg-base-100 p-6 rounded-3xl shadow-xl">
    <!-- ẢNH BÊN TRÁI -->
    <div class="relative order-1">
        <img 
            src="https://trungtamnhakhoaquocte.com/wp-content/uploads/2024/11/Thiet-ke-chua-co-ten-1-768x768.png"
            class="rounded-3xl shadow-xl w-full object-cover"
            alt="Phòng khám">

        <!-- doctor card -->
        <div class="absolute -bottom-6 -right-6 bg-base-100 shadow-xl p-4 rounded-2xl flex items-center gap-3">
            <div class="avatar">
                <div class="w-12 rounded-full">
                    <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=600&q=80" alt="doctor">
                </div>
            </div>
            <div>
                <p class="font-semibold">BS. Hạnh Phúc</p>
                <p class="text-sm text-base-content/70">Trưởng bộ phận điều trị</p>
            </div>
        </div>
    </div>

    <!-- NỘI DUNG BÊN PHẢI -->
    <div class="space-y-5 order-2 lg:col-span-2">
        <span class="badge badge-secondary badge-outline w-fit">Giới thiệu</span>

        <h2 class="text-3xl md:text-4xl font-bold leading-tight">
            Chúng tôi chăm sóc nụ cười <br class="hidden md:block">
            bằng sự tận tâm và công nghệ
        </h2>

        <p class="text-base-content/70 text-lg">
            SmileCare Clinic áp dụng quy trình chuẩn quốc tế, kết hợp hệ thống quản lý hồ sơ điện tử giúp bác sĩ theo dõi sát sao từng ca điều trị. Bạn có thể đặt lịch, xem kết quả, nhận tư vấn và nhắc nhở tái khám hoàn toàn trực tuyến.
        </p>

        <div class="grid sm:grid-cols-3 gap-4 pt-4">
            <div class="p-5 rounded-2xl bg-base-100 shadow flex items-start gap-4 hover:shadow-lg transition">
                <div class="h-11 w-11 rounded-xl bg-primary/10 text-primary grid place-items-center text-lg">
                    <i class="ri-heart-3-line"></i>
                </div>
                <div>
                    <p class="font-semibold">Chăm sóc cá nhân hóa</p>
                    <p class="text-sm text-base-content/70">
                        Phác đồ điều trị rõ ràng, cập nhật theo tiến triển thực tế.
                    </p>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-base-100 shadow flex items-start gap-4 hover:shadow-lg transition">
                <div class="h-11 w-11 rounded-xl bg-primary/10 text-primary grid place-items-center text-lg">
                    <i class="ri-shield-check-line"></i>
                </div>
                <div>
                    <p class="font-semibold">An toàn & vệ sinh</p>
                    <p class="text-sm text-base-content/70">
                        Tiệt trùng tiêu chuẩn, thiết bị hiện đại, điều trị nhẹ nhàng.
                    </p>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-base-100 shadow flex items-start gap-4 hover:shadow-lg transition">
                <div class="h-11 w-11 rounded-xl bg-primary/10 text-primary grid place-items-center text-lg">
                    <i class="ri-shield-check-line"></i>
                </div>
                <div>
                    <p class="font-semibold">Trang thiết bị hiện đại</p>
                    <p class="text-sm text-base-content/70">
                        Hệ thống chẩn đoán hình ảnh kỹ thuật số, công nghệ điều trị tiên tiến.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>


<section id="team" class="space-y-4">
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <h2 class="text-3xl font-semibold">ĐỘI NGŨ CHUYÊN GIA NHA KHOA</h2>
        </div>
        <div class="flex gap-2">
            <button class="btn btn-outline btn-sm" data-target="team-slider" data-prev><i class="ri-arrow-left-s-line"></i></button>
            <button class="btn btn-outline btn-sm" data-target="team-slider" data-next><i class="ri-arrow-right-s-line"></i></button>
        </div>
    </div>
    <div class="auto-slider" id="team-slider" data-auto-slider data-interval="5000" data-visible="4">
        <div class="slider-track flex gap-4 overflow-hidden" data-track>
            <?php foreach ($teamMembers as $index => $member): ?>
                <div class="card bg-base-100 shadow team-card min-w-[220px] md:min-w-[240px] lg:min-w-[260px]" data-slide <?= $index === 0 ? 'data-active' : '' ?> data-group="team-slider">
                    <div class="card-body items-center text-center space-y-3">
                        <div class="avatar">
                            <div class="w-20 h-20 rounded-full ring ring-primary ring-offset-2">
                                <img src="<?= htmlspecialchars($member['avatar']) ?>" alt="<?= htmlspecialchars($member['name']) ?>">
                            </div>
                        </div>
                        <h3 class="font-semibold text-lg"><?= htmlspecialchars($member['name']) ?></h3>
                        <p class="text-sm text-base-content/70"><?= htmlspecialchars($member['role'] ?? 'Bác sĩ điều trị') ?></p>
                        <?php if (!empty($member['philosophy'])): ?>
                            <p class="text-sm text-base-content/70 line-clamp-3">“<?= htmlspecialchars($member['philosophy']) ?>”</p>
                        <?php endif; ?>
                        <?php if (!empty($member['joined_at'])): ?>
                            <p class="text-xs text-base-content/60">Gia nhập: <?= date('m/Y', strtotime($member['joined_at'])) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section 
    class="relative py-16 px-6 text-white"
    style="background: url('https://nhakhoaanhdental.com/wp-content/uploads/2025/10/t10.png') center/cover no-repeat;">

    <div class="relative max-w-7xl mx-auto">
        <h2 class="font-bold text-3xl md:text-4xl text-center mb-12">
            Điểm đến tin cậy của khách hàng trong & ngoài nước
        </h2>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
            <!-- item -->
            <div class="stat bg-white/10 backdrop-blur-md rounded-xl shadow-lg hover:scale-105 transition">
                <div class="stat-figure">
                    <i class="ri-user-smile-line text-4xl"></i>
                </div>
                <div class="stat-title text-gray-200">Kinh nghiệm</div>
                <div class="stat-value text-white">10+</div>
            </div>

            <div class="stat bg-white/10 backdrop-blur-md rounded-xl shadow-lg hover:scale-105 transition">
                <div class="stat-figure">
                    <i class="ri-group-line text-4xl"></i>
                </div>
                <div class="stat-title text-gray-200">Khách hàng</div>
                <div class="stat-value"><?= number_format($stats['customers']) ?>+</div>
            </div>

            <div class="stat bg-white/10 backdrop-blur-md rounded-xl shadow-lg hover:scale-105 transition">
                <div class="stat-figure">
                    <i class="ri-shield-star-line text-4xl"></i>
                </div>
                <div class="stat-title text-gray-200">Dịch vụ</div>
                <div class="stat-value"><?= number_format($stats['services']) ?>+</div>
            </div>

            <div class="stat bg-white/10 backdrop-blur-md rounded-xl shadow-lg hover:scale-105 transition">
                <div class="stat-figure">
                    <i class="ri-user-voice-line text-4xl"></i>
                </div>
                <div class="stat-title text-gray-200">Bác sĩ</div>
                <div class="stat-value"><?= number_format($stats['doctors']) ?>+</div>
            </div>

            <div class="stat bg-white/10 backdrop-blur-md rounded-xl shadow-lg hover:scale-105 transition">
                <div class="stat-figure">
                    <i class="ri-calendar-check-line text-4xl"></i>
                </div>
                <div class="stat-title">Ca điều trị</div>
                <div class="stat-value"><?= number_format($stats['appointments']) ?>+</div>
            </div>
        </div>
    </div>
</section>

<section id="articles" class="space-y-4">
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div>
            <h2 class="text-3xl font-semibold">TIN TỨC VÀ SỰ KIỆN</h2>
        </div>
        <div class="flex gap-2">
            <button class="btn btn-outline btn-sm" data-target="article-slider" data-prev><i class="ri-arrow-left-s-line"></i></button>
            <button class="btn btn-outline btn-sm" data-target="article-slider" data-next><i class="ri-arrow-right-s-line"></i></button>
        </div>
    </div>
    <div class="auto-slider" id="article-slider" data-auto-slider data-interval="5000" data-visible="4">
        <div class="slider-track flex gap-4 overflow-hidden" data-track>
            <?php foreach ($articles as $index => $article): ?>
                <div class="card bg-base-100 shadow article-card min-w-[220px] md:min-w-[240px] lg:min-w-[260px]" data-slide <?= $index === 0 ? 'data-active' : '' ?> data-group="article-slider">
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

<section id="booking" class="space-y-8">

    <!-- TOP INFO (đưa lên trên) -->
    <div class="grid lg:grid-cols-12 gap-6 items-stretch">
        <!-- Quy trình -->
        <div class="lg:col-span-5 p-6 bg-blue-500 text-primary-content rounded-3xl shadow-lg space-y-3">
            <div class="flex items-center justify-between gap-3">
                <h3 class="text-xl font-semibold flex items-center gap-2">
                    <i class="ri-service-line"></i> Quy trình tiếp nhận
                </h3>
                <span class="badge badge-outline border-white/40 text-white">Nhanh · Rõ ràng</span>
            </div>

            <ol class="list-decimal list-inside space-y-1 text-sm leading-relaxed">
                <li>Tiếp nhận yêu cầu và gọi xác nhận trong giờ làm việc.</li>
                <li>Sắp xếp lịch phù hợp, gửi hướng dẫn chuẩn bị.</li>
                <li>Khám – chụp phim (nếu cần) – tư vấn phác đồ.</li>
                <li>Điều trị & hướng dẫn chăm sóc tại nhà.</li>
                <li>Nhắc lịch tái khám và theo dõi định kỳ.</li>
            </ol>

            <p class="text-sm opacity-90">
                Khách có tài khoản vui lòng
                <a class="link link-hover text-white font-semibold" href="/index.php?page=login">đăng nhập</a>
                để theo dõi lịch hẹn và hồ sơ.
            </p>
        </div>

        <!-- Thông tin nhanh -->
        <div class="lg:col-span-7 grid sm:grid-cols-2 gap-4">
            <div class="p-5 rounded-2xl bg-base-100 shadow flex gap-3">
                <div class="h-11 w-11 rounded-xl bg-primary/10 text-primary grid place-items-center text-lg">
                    <i class="ri-phone-line"></i>
                </div>
                <div class="space-y-1">
                    <p class="font-semibold">Hotline tư vấn</p>
                    <p class="text-sm text-base-content/70">Gọi nhanh để được ưu tiên khung giờ & hỗ trợ dịch vụ phù hợp.</p>
                    <a class="link link-primary font-semibold" href="tel:0900000000">0900 000 000</a>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-base-100 shadow flex gap-3">
                <div class="h-11 w-11 rounded-xl bg-primary/10 text-primary grid place-items-center text-lg">
                    <i class="ri-time-line"></i>
                </div>
                <div class="space-y-1">
                    <p class="font-semibold">Giờ làm việc</p>
                    <p class="text-sm text-base-content/70">08:00 – 20:00 (T2 – CN)</p>
                    <p class="text-xs text-base-content/50">Ngoài giờ: để lại form, chúng tôi liên hệ sớm nhất.</p>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-base-100 shadow flex gap-3">
                <div class="h-11 w-11 rounded-xl bg-primary/10 text-primary grid place-items-center text-lg">
                    <i class="ri-map-pin-2-line"></i>
                </div>
                <div class="space-y-1">
                    <p class="font-semibold">Địa chỉ phòng khám</p>
                    <p class="text-sm text-base-content/70">123 Lê Lợi, Quận 1, TP.HCM</p>
                    <a class="link link-primary text-sm" href="#map">Xem bản đồ</a>
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-base-100 shadow flex gap-3">
                <div class="h-11 w-11 rounded-xl bg-primary/10 text-primary grid place-items-center text-lg">
                    <i class="ri-shield-check-line"></i>
                </div>
                <div class="space-y-1">
                    <p class="font-semibold">Cam kết dịch vụ</p>
                    <ul class="text-sm text-base-content/70 list-disc list-inside space-y-0.5">
                        <li>Minh bạch chi phí trước điều trị</li>
                        <li>Vô trùng tiêu chuẩn</li>
                        <li>Nhắc lịch tái khám</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- FORM FULL WIDTH -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body space-y-4">
            <div class="flex items-start justify-between flex-wrap gap-3">
                <div class="space-y-1">
                    <p class="badge badge-primary">Đặt lịch hẹn</p>
                    <h2 class="text-2xl md:text-3xl font-bold">Đặt lịch nhanh chóng</h2>
                    <p class="text-base-content/70">
                        Điền thông tin để được gọi xác nhận. Mọi yêu cầu sẽ ở trạng thái <b>“Chờ xác nhận”</b>.
                    </p>
                </div>

                <div class="alert bg-base-200/70 text-base-content lg:max-w-md">
                    <i class="ri-information-line text-lg"></i>
                    <div class="text-sm">
                        <p class="font-semibold">Mẹo để được xếp lịch nhanh</p>
                        <p class="opacity-70">Chọn dịch vụ + ghi rõ triệu chứng (ê buốt/đau nhức/sưng...).</p>
                    </div>
                </div>
            </div>

            <form id="booking-form" class="grid lg:grid-cols-3 gap-4">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token()) ?>">

                <!-- col 1 -->
                <div class="form-control lg:col-span-1">
                    <label class="label"><span class="label-text">Họ tên *</span></label>
                    <input type="text" name="full_name" class="input input-bordered" required>
                </div>

                <div class="form-control lg:col-span-1">
                    <label class="label"><span class="label-text">Số điện thoại *</span></label>
                    <input type="tel" name="phone" class="input input-bordered" required pattern="[0-9+ ]{8,15}">
                </div>

                <div class="form-control lg:col-span-1">
                    <label class="label"><span class="label-text">Email</span></label>
                    <input type="email" name="email" class="input input-bordered" placeholder="you@example.com">
                </div>

                <!-- col 2 -->
                <div class="form-control lg:col-span-1">
                    <label class="label"><span class="label-text">Chọn dịch vụ</span></label>
                    <select name="service_id" class="select select-bordered">
                        <option value="">Tư vấn chung</option>
                        <?php foreach ($services as $service): ?>
                            <option value="<?= $service['id'] ?>"><?= htmlspecialchars($service['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-control lg:col-span-2">
                    <label class="label"><span class="label-text">Thời gian mong muốn *</span></label>
                    <input type="datetime-local" name="appointment_date" class="input input-bordered" required>

                    <div class="flex items-center gap-2 mt-2 flex-wrap">
                        <button type="button" id="suggest-slot-btn" class="btn btn-outline btn-sm">
                            <i class="ri-magic-line mr-1"></i>Gợi ý giờ trống
                        </button>
                        <span id="suggest-meta" class="text-xs text-base-content/50"></span>
                        <div id="slot-suggestions" class="flex flex-wrap gap-2"></div>
                    </div>
                </div>

                <!-- notes full -->
                <div class="form-control lg:col-span-3">
                    <label class="label"><span class="label-text">Ghi chú triệu chứng</span></label>
                    <textarea name="notes" class="textarea textarea-bordered" rows="4"
                        placeholder="Ví dụ: ê buốt khi uống lạnh, đau răng hàm dưới, sưng nướu 2 ngày..."></textarea>
                </div>

                <!-- extra content -->
                <div class="lg:col-span-3 grid md:grid-cols-3 gap-3">
                    <div class="p-4 rounded-2xl bg-base-200/60">
                        <p class="font-semibold flex items-center gap-2"><i class="ri-check-double-line text-primary"></i>Lợi ích đặt lịch online</p>
                        <p class="text-sm text-base-content/70 mt-1">Ưu tiên xếp lịch, giảm thời gian chờ, nhận nhắc lịch tự động.</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-base-200/60">
                        <p class="font-semibold flex items-center gap-2"><i class="ri-file-list-3-line text-primary"></i>Cần chuẩn bị gì?</p>
                        <p class="text-sm text-base-content/70 mt-1">Mang theo CCCD (nếu có), đơn thuốc cũ, chụp phim trước đó (nếu có).</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-base-200/60">
                        <p class="font-semibold flex items-center gap-2"><i class="ri-error-warning-line text-primary"></i>Lưu ý khi đến khám</p>
                        <p class="text-sm text-base-content/70 mt-1">Đến sớm 10 phút. Nếu đau cấp, ghi rõ để được ưu tiên xử lý.</p>
                    </div>
                </div>

                <div class="lg:col-span-3">
                    <button class="btn btn-primary w-full" type="submit">
                        <i class="ri-send-plane-line mr-2"></i>Gửi yêu cầu
                    </button>
                    <p class="text-xs text-base-content/50 mt-2 text-center">
                        Bằng việc gửi yêu cầu, bạn đồng ý để chúng tôi liên hệ tư vấn và xác nhận lịch hẹn.
                    </p>
                </div>
            </form>
        </div>
    </div>
</section>

<section id="partners" class="bg-base-100 shadow-inner rounded-3xl p-8 space-y-6">

    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <h3 class="flex items-center gap-2 text-primary font-semibold text-lg">
            <i class="ri-hand-heart-line text-xl"></i>
            Đối tác & Khách hàng tiêu biểu
        </h3>
        <p class="text-sm text-base-content/60 max-w-md">
            Đồng hành cùng các đơn vị uy tín trong và ngoài nước.
        </p>
    </div>

    <!-- LOGO GRID -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 items-center">
        <!-- logo item -->
        <div class="group bg-base-100 rounded-2xl p-4 grid place-items-center hover:bg-base-200 transition">
            <img src="https://nhakhoaanhdental.com/wp-content/uploads/2025/09/logo-implant-dentium-1741768852-png-300x150.webp"
                 alt="Partner 1"
                 class="h-10 object-contain transition">
        </div>

        <div class="group bg-base-100 rounded-2xl p-4 grid place-items-center hover:bg-base-200 transition">
            <img src="https://nhakhoaanhdental.com/wp-content/uploads/2025/09/etk-implant-4-1741251982-jpg-300x188.webp"
                 alt="Partner 2"
                 class="h-10 object-contain transition">
        </div>

        <div class="group bg-base-100 rounded-2xl p-4 grid place-items-center hover:bg-base-200 transition">
            <img src="https://nhakhoaanhdental.com/wp-content/uploads/2025/09/cong-ty-sic-4-1741251063-jpg-300x188.webp"
                 alt="Partner 3"
                 class="h-10 object-contain transition">
        </div>

        <div class="group bg-base-100 rounded-2xl p-4 grid place-items-center hover:bg-base-200 transition">
            <img src="https://nhakhoaanhdental.com/wp-content/uploads/2025/09/logo-cercon-1741411091-jpeg-300x216.webp"
                 alt="Partner 4"
                 class="h-10 object-contain transition">
        </div>

        <div class="group bg-base-100 rounded-2xl p-4 grid place-items-center hover:bg-base-200 transition">
            <img src="https://nhakhoaanhdental.com/wp-content/uploads/2025/09/untitled-design-1741254982-jpg.webp"
                 alt="Partner 5"
                 class="h-10 object-contain transition">
        </div>

        <div class="group bg-base-100 rounded-2xl p-4 grid place-items-center hover:bg-base-200 transition">
            <img src="https://nhakhoaanhdental.com/wp-content/uploads/2025/09/su-emax-1-1741835153-webp-300x188.webp"
                 alt="Partner 5"
                 class="h-10 object-contain transition">
        </div>

    </div>

</section>

