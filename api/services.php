<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/Csrf.php';
require_once __DIR__ . '/../helpers/Response.php';
require_once __DIR__ . '/../helpers/Auth.php';
require_once __DIR__ . '/../models/Service.php';

$user = Auth::user();
if (!$user) {
    Response::json('error', 'Vui lòng đăng nhập.');
}
Auth::requireRole(['admin']);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::json('error', 'Phương thức không hỗ trợ.');
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? ($data['csrf_token'] ?? '');
if (!Csrf::verify($token)) {
    Response::json('error', 'CSRF token không hợp lệ');
}

$name = trim($data['name'] ?? '');
if ($name === '') {
    Response::json('error', 'Tên dịch vụ là bắt buộc');
}

$serviceModel = new Service($pdo);
$serviceModel->create([
    'name' => $name,
    'description' => trim($data['description'] ?? ''),
    'price' => $data['price'] !== '' ? $data['price'] : null,
    'is_active' => (int)($data['is_active'] ?? 1),
]);

Response::json('success', 'Lưu dịch vụ thành công');
