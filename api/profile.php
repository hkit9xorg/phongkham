<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/Csrf.php';
require_once __DIR__ . '/../helpers/Response.php';
require_once __DIR__ . '/../helpers/Auth.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Patient.php';

$user = Auth::user();
if (!$user) {
    Response::json('error', 'Vui lòng đăng nhập.');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::json('error', 'Phương thức không hỗ trợ.');
}

$payload = json_decode(file_get_contents('php://input'), true) ?? [];
$token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? ($payload['csrf_token'] ?? '');
if (!Csrf::verify($token)) {
    Response::json('error', 'CSRF token không hợp lệ');
}

$action = $payload['action'] ?? '';
$userModel = new User($pdo);
$patientModel = new Patient($pdo);

if ($action === 'change_password') {
    $current = $payload['current_password'] ?? '';
    $new = $payload['new_password'] ?? '';
    $confirm = $payload['confirm_password'] ?? '';

    if ($new === '' || $confirm === '' || $current === '') {
        Response::json('error', 'Vui lòng nhập đầy đủ thông tin.');
    }

    if ($new !== $confirm) {
        Response::json('error', 'Mật khẩu mới không trùng khớp.');
    }

    if (strlen($new) < 6) {
        Response::json('error', 'Mật khẩu mới tối thiểu 6 ký tự.');
    }

    $fullUser = $userModel->findById($user['id']);
    if (!$fullUser || !password_verify($current, $fullUser['password_hash'])) {
        Response::json('error', 'Mật khẩu hiện tại không đúng.');
    }

    $userModel->updatePassword($user['id'], password_hash($new, PASSWORD_BCRYPT));
    Response::json('success', 'Đã đổi mật khẩu thành công.');
}

if ($action === 'update_profile') {
    $fullName = trim($payload['full_name'] ?? '');
    if ($fullName === '') {
        Response::json('error', 'Họ tên là bắt buộc');
    }

    try {
        $userModel->updateProfile($user['id'], [
            'full_name' => $fullName,
            'phone' => trim($payload['phone'] ?? ''),
        ]);
    } catch (Exception $e) {
        Response::json('error', $e->getMessage());
    }

    $patient = $patientModel->findByUserId($user['id']);
    $patientData = [
        'dob' => $payload['dob'] ?? null,
        'gender' => $payload['gender'] ?? null,
        'address' => $payload['address'] ?? null,
        'medical_history' => $payload['medical_history'] ?? null,
        'allergies' => $payload['allergies'] ?? null,
    ];

    if ($patient) {
        $patientModel->updateByUser($user['id'], $patientData);
    } else {
        $patientModel->create($user['id'], $patientData);
    }

    $_SESSION['user']['name'] = $fullName;
    Response::json('success', 'Đã cập nhật hồ sơ bệnh nhân.');
}

Response::json('error', 'Yêu cầu không hợp lệ.');
