<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/Csrf.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Patient.php';
require_once __DIR__ . '/../models/Appointment.php';

$title = 'Đăng ký khách hàng';
$errors = [];
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';
    $token = $_POST['csrf_token'] ?? '';

    if (!Csrf::verify($token)) {
        $errors[] = 'CSRF token không hợp lệ.';
    }

    if ($fullName === '' || $phone === '') {
        $errors[] = 'Họ tên và số điện thoại là bắt buộc.';
    }

    if ($password === '' || $passwordConfirm === '') {
        $errors[] = 'Vui lòng nhập mật khẩu và xác nhận mật khẩu.';
    } elseif ($password !== $passwordConfirm) {
        $errors[] = 'Mật khẩu nhập lại không khớp.';
    }

    $userModel = new User($pdo);
    if (!$errors && $userModel->findByPhone($phone)) {
        $errors[] = 'Số điện thoại đã được đăng ký.';
    }

    if (!$errors) {
        $emailFallback = $phone . '@smilecare.local';
        $userId = $userModel->createCustomer([
            'full_name' => $fullName,
            'email' => $emailFallback,
            'phone' => $phone,
            'password_hash' => password_hash($password, PASSWORD_BCRYPT),
        ]);
        $patientModel = new Patient($pdo);
        $patientModel->create($userId, []);

        $appointmentModel = new Appointment($pdo);
        $appointmentModel->assignCustomerByPhone($phone, $userId);
        $_SESSION['user'] = [
            'id' => $userId,
            'name' => $fullName,
            'email' => $emailFallback,
            'phone' => $phone,
            'role' => 'customer',
        ];
        $success = 'Đăng ký thành công. Bạn đã được đăng nhập với vai trò khách hàng.';
    }
}

ob_start();
include __DIR__ . '/../views/register.php';
$content = ob_get_clean();
include __DIR__ . '/../views/layout.php';
