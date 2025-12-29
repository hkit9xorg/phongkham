<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/Csrf.php';
require_once __DIR__ . '/../helpers/Response.php';
require_once __DIR__ . '/../helpers/Auth.php';
require_once __DIR__ . '/../models/Appointment.php';

$user = Auth::user();
if (!$user || $user['role'] !== 'customer') {
    Response::json('error', 'Chỉ khách hàng mới có thể thao tác với lịch hẹn của mình.');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::json('error', 'Phương thức không hỗ trợ.');
}

$payload = json_decode(file_get_contents('php://input'), true) ?? [];
$token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? ($payload['csrf_token'] ?? '');
if (!Csrf::verify($token)) {
    Response::json('error', 'CSRF token không hợp lệ');
}

$appointmentId = (int)($payload['id'] ?? 0);
$note = trim($payload['note'] ?? '');

if ($appointmentId <= 0) {
    Response::json('error', 'Thiếu mã lịch hẹn.');
}

$appointmentModel = new Appointment($pdo);
$appointment = $appointmentModel->findById($appointmentId);

if (!$appointment || (int)$appointment['customer_id'] !== (int)$user['id']) {
    Response::json('error', 'Bạn không thể chỉnh sửa lịch hẹn này.');
}

$allowedStatus = ['pending', 'confirmed', 'rescheduled'];
if (!in_array($appointment['status'], $allowedStatus, true)) {
    Response::json('error', 'Chỉ có thể hủy lịch hẹn chưa hoàn tất.');
}

$appointmentModel->cancelByCustomer($appointmentId, (int)$user['id'], $note ?: null);

Response::json('success', 'Đã hủy lịch hẹn của bạn.');
