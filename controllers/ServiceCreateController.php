<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/../helpers/Csrf.php';
require_once __DIR__ . '/../helpers/Auth.php';

$user = Auth::user();
if (!$user || $user['role'] !== 'admin') {
    http_response_code(403);
    die('Bạn không có quyền truy cập trang này');
}

$serviceModel = new Service($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!Csrf::verify($token)) {
        $_SESSION['flash'] = 'CSRF token không hợp lệ.';
        header('Location: /index.php?page=create_service');
        exit;
    }

    $serviceModel->create([
        'name' => trim($_POST['name'] ?? ''),
        'price' => $_POST['price'] !== '' ? $_POST['price'] : null,
        'description' => trim($_POST['description'] ?? ''),
        'is_active' => (int)($_POST['is_active'] ?? 1),
    ]);

    $_SESSION['flash'] = 'Đã thêm dịch vụ mới thành công.';
    header('Location: /index.php?page=create_service');
    exit;
}

$title = 'Thêm dịch vụ mới';
ob_start();
include __DIR__ . '/../views/service_form.php';
$content = ob_get_clean();
include __DIR__ . '/../views/layout.php';
