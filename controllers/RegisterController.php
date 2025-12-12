<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/Csrf.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Patient.php';

$title = 'Đăng ký khách hàng';
$errors = [];
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $token = $_POST['csrf_token'] ?? '';
    $fixedHash = '$2y$10$XmYFYy.VNeY/L4/8SSeO0.ODMgBk0.ujvcCb4WB.XBF40sWia7zLa';

    if (!Csrf::verify($token)) {
        $errors[] = 'CSRF token không hợp lệ.';
    }

    if ($fullName === '' || $email === '') {
        $errors[] = 'Họ tên và email là bắt buộc.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email không hợp lệ.';
    }

    $userModel = new User($pdo);
    if (!$errors && $userModel->findByEmail($email)) {
        $errors[] = 'Email đã tồn tại trong hệ thống.';
    }

    if (!$errors) {
        $userId = $userModel->createCustomer([
            'full_name' => $fullName,
            'email' => $email,
            'phone' => $phone,
            'password_hash' => $fixedHash,
        ]);
        $patientModel = new Patient($pdo);
        $patientModel->create($userId, []);
        $_SESSION['user'] = [
            'id' => $userId,
            'name' => $fullName,
            'email' => $email,
            'role' => 'customer',
        ];
        $success = 'Đăng ký thành công, mật khẩu mặc định: 123456. Bạn đã được đăng nhập.';
    }
}

ob_start();
include __DIR__ . '/../views/register.php';
$content = ob_get_clean();
include __DIR__ . '/../views/layout.php';
