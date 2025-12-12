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
    <title><?= htmlspecialchars($title ?? 'Tin tức đa người dùng') ?></title>
    <meta name="csrf-token" content="<?= htmlspecialchars(Csrf::token()) ?>">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.5/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.tailwindcss.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-base-200 min-h-screen">
    <div class="navbar bg-base-100 shadow">
        <div class="flex-1">
            <a href="<?= $baseUrl ?>/index.php" class="btn btn-ghost normal-case text-xl"><i class="ri-newspaper-line mr-2"></i>Tin tức</a>
        </div>
        <div class="flex-none gap-2">
            <?php if ($user): ?>
                <a class="btn btn-sm btn-primary" href="<?= $baseUrl ?>/index.php?page=editor"><i class="ri-quill-pen-line mr-1"></i>Soạn bài</a>
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full">
                            <img src="https://api.dicebear.com/7.x/identicon/svg?seed=<?= urlencode($user['email']) ?>" alt="avatar">
                        </div>
                    </label>
                    <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                        <li class="menu-title"><?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['role']) ?>)</li>
                        <li><a href="#"><i class="ri-notification-2-line"></i>Thông báo</a></li>
                        <li><a href="#"><i class="ri-bookmark-line"></i>Bookmarks</a></li>
                        <li><a href="<?= $baseUrl ?>/index.php?page=logout"><i class="ri-logout-circle-r-line"></i>Đăng xuất</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <a class="btn btn-ghost" href="<?= $baseUrl ?>/index.php?page=login"><i class="ri-login-circle-line mr-2"></i>Đăng nhập</a>
            <?php endif; ?>
        </div>
    </div>
    <main class="container mx-auto p-4">
        <?php if (!empty($_SESSION['flash'])): ?>
            <div class="alert alert-info shadow-lg mb-4">
                <div>
                    <i class="ri-information-line"></i>
                    <span><?= htmlspecialchars($_SESSION['flash']); unset($_SESSION['flash']); ?></span>
                </div>
            </div>
        <?php endif; ?>
        <?= $content ?? '' ?>
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

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.tailwindcss.min.js"></script>
    <script src="<?= $baseUrl ?>/assets/js/main.js"></script>
</body>
</html>
