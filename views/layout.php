<?php
require_once __DIR__ . '/../helpers/Env.php';
require_once __DIR__ . '/../helpers/Csrf.php';
Env::load();
$baseUrl = Env::get('APP_BASE_URL', '');
$user = $_SESSION['user'] ?? null;
?>
<!DOCTYPE html>
<html lang="vi" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Phòng khám nha khoa') ?></title>
    <meta name="csrf-token" content="<?= htmlspecialchars(Csrf::token()) ?>">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.5/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.tailwindcss.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-base-200 min-h-screen">
    <div class="bg-primary text-primary-content text-sm">
        <div class="container mx-auto flex flex-wrap items-center justify-between gap-4 px-4 py-2">
            <div class="flex items-center gap-3 overflow-hidden">
                <span class="font-semibold uppercase tracking-wide">SmileCare Live</span>
                <div class="ticker">
                    <div class="ticker__track">
                        <span>Đội ngũ bác sĩ giàu kinh nghiệm - Thiết bị nha khoa hiện đại - Không gian thoải mái.</span>
                        <span>Ưu đãi niềng răng và tẩy trắng mùa hè lên tới 20%.</span>
                        <span>Đặt lịch online để nhận lịch khám ưu tiên.</span>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-4">
                <a class="flex items-center gap-1" href="tel:19001234"><i class="ri-phone-fill"></i><span>1900 1234</span></a>
                <a class="flex items-center gap-1" href="mailto:hello@smilecare.vn"><i class="ri-mail-line"></i><span>hello@smilecare.vn</span></a>
                <span class="flex items-center gap-1"><i class="ri-map-pin-2-line"></i>123 Lê Lợi, Quận 1, TP.HCM</span>
            </div>
        </div>
    </div>

    <header class="sticky top-0 z-30 backdrop-blur bg-base-100/90 shadow">
        <div class="container mx-auto flex items-center justify-between gap-4 px-4 py-3">
            <div class="flex items-center gap-3">
                <a href="<?= $baseUrl ?>/index.php" class="flex items-center gap-2 text-xl font-semibold">
                    <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-primary to-accent text-white grid place-items-center shadow-lg">
                        <i class="ri-shield-cross-line text-2xl"></i>
                    </div>
                    <div class="leading-tight">
                        <div>SmileCare</div>
                        <div class="text-sm text-base-content/70">Digital Dental Clinic</div>
                    </div>
                </a>
                <nav class="hidden lg:flex items-center gap-2">
                    <a href="<?= $baseUrl ?>/index.php#home" class="btn btn-ghost btn-sm">Trang chủ</a>
                    <a href="<?= $baseUrl ?>/index.php#services" class="btn btn-ghost btn-sm">Dịch vụ</a>
                    <a href="<?= $baseUrl ?>/index.php#about" class="btn btn-ghost btn-sm">Giới thiệu</a>
                    <a href="<?= $baseUrl ?>/index.php#team" class="btn btn-ghost btn-sm">Đội ngũ</a>
                    <a href="<?= $baseUrl ?>/index.php#articles" class="btn btn-ghost btn-sm">Bài viết</a>
                </nav>
            </div>
            <div class="flex items-center gap-2">
                <a class="btn btn-outline btn-primary btn-sm" href="tel:19001234"><i class="ri-phone-fill mr-1"></i>Gọi ngay</a>
                <a class="btn btn-primary btn-sm" href="<?= $baseUrl ?>/index.php#booking"><i class="ri-calendar-check-line mr-1"></i>Đặt lịch</a>
                <?php if ($user): ?>
                    <?php if (($user['role'] ?? '') === 'admin'): ?>
                        <a class="btn btn-sm" href="<?= $baseUrl ?>/index.php?page=admin"><i class="ri-settings-5-line mr-1"></i>Quản trị</a>
                    <?php endif; ?>
                    <a class="btn btn-sm btn-secondary" href="<?= $baseUrl ?>/index.php?page=dashboard"><i class="ri-dashboard-line mr-1"></i>Dashboard</a>
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                            <div class="w-10 rounded-full">
                                <img src="https://api.dicebear.com/7.x/identicon/svg?seed=<?= urlencode($user['email']) ?>" alt="avatar">
                            </div>
                        </label>
                        <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                            <li class="menu-title"><?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['role']) ?>)</li>
                            <li><a href="<?= $baseUrl ?>/index.php?page=logout"><i class="ri-logout-circle-r-line"></i>Đăng xuất</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a class="btn btn-ghost btn-sm" href="<?= $baseUrl ?>/index.php?page=login"><i class="ri-login-circle-line mr-2"></i>Đăng nhập</a>
                    <a class="btn btn-outline btn-sm" href="<?= $baseUrl ?>/index.php?page=register"><i class="ri-user-add-line mr-2"></i>Đăng ký</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="bg-gradient-to-b from-base-200 via-base-100 to-base-200">
        <div class="container mx-auto px-4 py-8 space-y-10" id="home">
        <?php if (!empty($_SESSION['flash'])): ?>
            <div class="alert alert-info shadow-lg mb-4">
                <div>
                    <i class="ri-information-line"></i>
                    <span><?= htmlspecialchars($_SESSION['flash']); unset($_SESSION['flash']); ?></span>
                </div>
            </div>
        <?php endif; ?>
        <?= $content ?? '' ?>
        </div>
    </main>

    <dialog id="modal-message" class="modal">
        <form method="dialog" class="modal-box">
            <h3 class="font-bold text-lg" id="modal-title">Thông báo</h3>
            <p class="py-4" id="modal-body">Nội dung thông báo</p>
            <div class="modal-action">
                <button class="btn">Đóng</button>
            </div>
        </form>
    </dialog>

    <a href="#booking" class="btn btn-primary btn-lg rounded-full shadow-xl fixed right-4 bottom-6 animate-bounce-subtle"><i class="ri-calendar-check-line mr-2"></i>Đặt lịch ngay</a>

    <footer class="bg-base-100 border-t">
        <div class="container mx-auto px-4 py-10 grid gap-8 lg:grid-cols-4">
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-primary to-accent text-white grid place-items-center shadow-lg">
                        <i class="ri-shield-cross-line text-2xl"></i>
                    </div>
                    <div>
                        <div class="text-xl font-semibold">SmileCare Clinic</div>
                        <p class="text-sm text-base-content/70">Chăm sóc răng miệng toàn diện cho cả gia đình.</p>
                    </div>
                </div>
                <p class="text-sm text-base-content/70">Kết nối công nghệ với sự tận tâm của bác sĩ để mang lại trải nghiệm nha khoa an toàn, tiện lợi.</p>
                <div class="flex gap-3 text-xl text-primary">
                    <a href="https://facebook.com" target="_blank" rel="noreferrer" aria-label="Facebook"><i class="ri-facebook-circle-fill"></i></a>
                    <a href="https://www.youtube.com" target="_blank" rel="noreferrer" aria-label="YouTube"><i class="ri-youtube-fill"></i></a>
                    <a href="https://zalo.me" target="_blank" rel="noreferrer" aria-label="Zalo"><i class="ri-message-3-fill"></i></a>
                    <a href="https://www.instagram.com" target="_blank" rel="noreferrer" aria-label="Instagram"><i class="ri-instagram-fill"></i></a>
                </div>
            </div>
            <div>
                <h3 class="font-semibold mb-3">Liên kết nhanh</h3>
                <ul class="space-y-2 text-sm">
                    <li><a class="link" href="#services">Dịch vụ nổi bật</a></li>
                    <li><a class="link" href="#about">Giới thiệu</a></li>
                    <li><a class="link" href="#team">Đội ngũ bác sĩ</a></li>
                    <li><a class="link" href="#articles">Tin tức & tư vấn</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-semibold mb-3">Liên hệ</h3>
                <ul class="space-y-2 text-sm text-base-content/80">
                    <li class="flex items-start gap-2"><i class="ri-map-pin-2-line mt-1"></i><span>123 Lê Lợi, Quận 1, TP.HCM</span></li>
                    <li class="flex items-start gap-2"><i class="ri-phone-fill mt-1"></i><a class="link" href="tel:19001234">1900 1234</a></li>
                    <li class="flex items-start gap-2"><i class="ri-mail-line mt-1"></i><a class="link" href="mailto:hello@smilecare.vn">hello@smilecare.vn</a></li>
                    <li class="flex items-start gap-2"><i class="ri-time-line mt-1"></i><span>08:00 - 20:00 (T2 - CN)</span></li>
                </ul>
            </div>
            <div class="space-y-2">
                <h3 class="font-semibold">Địa chỉ trên bản đồ</h3>
                <div class="rounded-xl overflow-hidden shadow">
                    <iframe class="w-full h-48" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.5092989647413!2d106.7009850767148!3d10.772215059271492!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f3fa6b0f3a7%3A0x22e7b83c89d12b21!2zMjMgTMaw4budbmcgVsSDbiBBbiwgU8OibiBUaOG7nSBIw6AsIFF14bqtbiAxLCBUUC4gSMOyIENow60gTWluaA!5e0!3m2!1svi!2svi!4v1716715700000!5m2!1svi!2svi" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
        <div class="border-t py-4 text-center text-sm text-base-content/70">© <?= date('Y') ?> SmileCare Clinic. All rights reserved.</div>
    </footer>

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.tailwindcss.min.js"></script>
    <script src="<?= $baseUrl ?>/assets/js/main.js"></script>
</body>
</html>
