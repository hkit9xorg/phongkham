<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/Csrf.php';
require_once __DIR__ . '/../helpers/Response.php';
require_once __DIR__ . '/../helpers/Auth.php';
require_once __DIR__ . '/../models/AppointmentChange.php';
require_once __DIR__ . '/../models/AppointmentChangeView.php';
require_once __DIR__ . '/../models/Doctor.php';

$user = Auth::user();
if (!$user) {
    Response::json('error', 'Vui lòng đăng nhập.');
}

Auth::requireRole(['admin', 'doctor', 'customer']);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::json('error', 'Phương thức không hỗ trợ.');
}

$payload = json_decode(file_get_contents('php://input'), true) ?? [];
$token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? ($payload['csrf_token'] ?? '');
if (!Csrf::verify($token)) {
    Response::json('error', 'CSRF token không hợp lệ');
}

$changeId = (int)($payload['change_id'] ?? 0);
$mark = $payload['mark'] ?? 'read';
$isRead = $mark === 'read';

if ($changeId <= 0) {
    Response::json('error', 'Thiếu mã thay đổi lịch.');
}

$changeModel = new AppointmentChange($pdo);
$changeViewModel = new AppointmentChangeView($pdo);
$doctorModel = new Doctor($pdo);

$change = $changeModel->find($changeId);
if (!$change) {
    Response::json('error', 'Không tìm thấy thay đổi lịch hẹn.');
}

$canAccess = false;
if ($user['role'] === 'admin') {
    $canAccess = true;
} elseif ($user['role'] === 'customer' && (int)$change['customer_id'] === (int)$user['id']) {
    $canAccess = true;
} elseif ($user['role'] === 'doctor') {
    $doctorProfile = $doctorModel->findByUserId($user['id']);
    if ($doctorProfile && (int)$change['doctor_id'] === (int)$doctorProfile['id']) {
        $canAccess = true;
    }
}

if (!$canAccess) {
    Response::json('error', 'Bạn không thể cập nhật thông báo này.');
}

$changeViewModel->setReadStatus($changeId, (int)$user['id'], $isRead);
$message = $isRead ? 'Đã đánh dấu là đã xem.' : 'Đã đánh dấu là chưa xem.';

Response::json('success', $message);
