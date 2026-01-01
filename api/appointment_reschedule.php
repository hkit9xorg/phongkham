<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/Csrf.php';
require_once __DIR__ . '/../helpers/Response.php';
require_once __DIR__ . '/../helpers/Auth.php';
require_once __DIR__ . '/../models/Appointment.php';
require_once __DIR__ . '/../models/AppointmentChange.php';

$user = Auth::user();
if (!$user || $user['role'] !== 'customer') {
    Response::json('error', 'Chỉ khách hàng mới có thể dời lịch hẹn của mình.');
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
$newDate = trim($payload['appointment_date'] ?? '');
$note = trim($payload['note'] ?? '');
$previousDate = '';

if ($appointmentId <= 0 || $newDate === '') {
    Response::json('error', 'Thiếu mã lịch hẹn hoặc thời gian mới.');
}

$appointmentModel = new Appointment($pdo);
$appointmentChangeModel = new AppointmentChange($pdo);
$appointment = $appointmentModel->findById($appointmentId);
$previousDate = $appointment['appointment_date'] ?? '';

if (!$appointment || (int)$appointment['customer_id'] !== (int)$user['id']) {
    Response::json('error', 'Bạn không thể chỉnh sửa lịch hẹn này.');
}

$allowedStatus = ['pending', 'confirmed', 'rescheduled'];
if (!in_array($appointment['status'], $allowedStatus, true)) {
    Response::json('error', 'Chỉ có thể dời lịch khi lịch hẹn chưa hoàn tất.');
}

$appointmentModel->requestReschedule($appointmentId, (int)$user['id'], $newDate, $note ?: null);

if ($previousDate && $previousDate !== $newDate) {
    $appointmentChangeModel->log($appointmentId, $previousDate, $newDate, (int)$user['id'], $user['role']);
}

Response::json('success', 'Đã gửi yêu cầu dời lịch.');
