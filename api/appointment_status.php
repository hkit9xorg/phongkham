<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/Csrf.php';
require_once __DIR__ . '/../helpers/Response.php';
require_once __DIR__ . '/../helpers/Auth.php';
require_once __DIR__ . '/../models/Appointment.php';

$user = Auth::user();
if (!$user) {
    Response::json('error', 'Vui lòng đăng nhập.');
}
Auth::requireRole(['admin', 'doctor']);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::json('error', 'Phương thức không hỗ trợ.');
}

$payload = json_decode(file_get_contents('php://input'), true) ?? [];
$token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? ($payload['csrf_token'] ?? '');
if (!Csrf::verify($token)) {
    Response::json('error', 'CSRF token không hợp lệ');
}

$id = (int)($payload['id'] ?? 0);
if ($id <= 0) {
    Response::json('error', 'Thiếu mã lịch hẹn.');
}

$appointmentModel = new Appointment($pdo);
$appointment = $appointmentModel->findById($id);
if (!$appointment) {
    Response::json('error', 'Không tìm thấy lịch hẹn.');
}

if ($user['role'] === 'doctor' && $appointment['doctor_id'] && (int)$appointment['doctor_id'] !== (int)$user['id']) {
    Response::json('error', 'Bạn không thể cập nhật lịch hẹn của bác sĩ khác.');
}

$status = $payload['status'] ?? $appointment['status'];
$notes = $payload['notes'] ?? $appointment['notes'];
$appointmentDate = $payload['appointment_date'] ?? $appointment['appointment_date'];
$doctorId = $payload['doctor_id'] ?? $appointment['doctor_id'];

if ($user['role'] === 'doctor') {
    $doctorId = $user['id'];
}

$appointmentModel->updateStatus($id, [
    'status' => $status,
    'doctor_id' => $doctorId,
    'appointment_date' => $appointmentDate,
    'notes' => $notes,
]);

Response::json('success', 'Đã cập nhật lịch hẹn.');
