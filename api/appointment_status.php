<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/Csrf.php';
require_once __DIR__ . '/../helpers/Response.php';
require_once __DIR__ . '/../helpers/Auth.php';
require_once __DIR__ . '/../models/Appointment.php';
require_once __DIR__ . '/../models/Doctor.php';
require_once __DIR__ . '/../models/AppointmentChange.php';

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
$doctorModel = new Doctor($pdo);
$appointmentChangeModel = new AppointmentChange($pdo);
$appointment = $appointmentModel->findById($id);
if (!$appointment) {
    Response::json('error', 'Không tìm thấy lịch hẹn.');
}

$status = $payload['status'] ?? $appointment['status'];
$notes = $payload['notes'] ?? $appointment['notes'];
$appointmentDate = $payload['appointment_date'] ?? $appointment['appointment_date'];
$doctorId = $payload['doctor_id'] ?? $appointment['doctor_id'];
$previousDate = $appointment['appointment_date'];

if ($user['role'] === 'doctor') {
    $doctorProfile = $doctorModel->findByUserId($user['id']);
    if (!$doctorProfile) {
        Response::json('error', 'Tài khoản bác sĩ chưa được liên kết hồ sơ.');
    }
    if ($appointment['doctor_id'] && (int)$appointment['doctor_id'] !== (int)$doctorProfile['id']) {
        Response::json('error', 'Bạn không thể cập nhật lịch hẹn của bác sĩ khác.');
    }
    $doctorId = $doctorProfile['id'];
}

$appointmentModel->updateStatus($id, [
    'status' => $status,
    'doctor_id' => $doctorId,
    'appointment_date' => $appointmentDate,
    'notes' => $notes,
]);

if ($appointmentDate && $previousDate !== $appointmentDate) {
    $appointmentChangeModel->log($id, $previousDate, $appointmentDate, (int)$user['id'], $user['role']);
}

Response::json('success', 'Đã cập nhật lịch hẹn.');
