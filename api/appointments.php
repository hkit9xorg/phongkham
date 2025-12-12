<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/Csrf.php';
require_once __DIR__ . '/../helpers/Response.php';
require_once __DIR__ . '/../models/Appointment.php';
require_once __DIR__ . '/../models/User.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'POST') {
    Response::json('error', 'Phương thức không được hỗ trợ');
}

$payload = json_decode(file_get_contents('php://input'), true) ?? [];
$token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? ($payload['csrf_token'] ?? '');
if (!Csrf::verify($token)) {
    Response::json('error', 'CSRF token không hợp lệ');
}

$fullName = trim($payload['full_name'] ?? '');
$phone = trim($payload['phone'] ?? '');
$email = trim($payload['email'] ?? '');
$appointmentDate = trim($payload['appointment_date'] ?? '');
$serviceId = !empty($payload['service_id']) ? (int)$payload['service_id'] : null;
$notes = trim($payload['notes'] ?? '');

if ($fullName === '' || $phone === '' || $appointmentDate === '') {
    Response::json('error', 'Vui lòng nhập đầy đủ họ tên, số điện thoại và thời gian.');
}

$appointmentModel = new Appointment($pdo);
$userModel = new User($pdo);

$customerId = null;
if (!empty($_SESSION['user'])) {
    $customerId = $_SESSION['user']['id'];
} elseif ($email) {
    $existing = $userModel->findByEmail($email);
    if ($existing) {
        $customerId = $existing['id'];
    }
}

$appointmentModel->create([
    'customer_id' => $customerId,
    'doctor_id' => null,
    'service_id' => $serviceId,
    'full_name' => $fullName,
    'phone' => $phone,
    'email' => $email,
    'appointment_date' => $appointmentDate,
    'status' => 'pending',
    'type' => 'standard',
    'notes' => $notes,
]);

Response::json('success', 'Đã nhận yêu cầu đặt lịch. Chúng tôi sẽ xác nhận sớm nhất.');
