<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/Csrf.php';
require_once __DIR__ . '/../models/User.php';

$title = 'Đăng nhập';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $token = $_POST['csrf_token'] ?? '';

    if (!Csrf::verify($token)) {
        $errors[] = 'CSRF token không hợp lệ.';
    }

    if (empty($phone) || empty($password)) {
        $errors[] = 'Số điện thoại và mật khẩu là bắt buộc.';
    }

    if (!$errors) {
        $userModel = new User($pdo);
        $user = $userModel->findByPhone($phone);
        if (!$user || !password_verify($password, $user['password_hash'])) {
            $errors[] = 'Thông tin đăng nhập không đúng.';
        } elseif ((int)$user['is_active'] !== 1) {
            $errors[] = 'Tài khoản đang bị khóa.';
        } else {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['full_name'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'role' => $user['role'],
            ];
            $_SESSION['flash'] = 'Đăng nhập thành công.';
            header('Location: /index.php?page=dashboard');
            exit;
        }
    }
}

ob_start();
include __DIR__ . '/../views/login.php';
$content = ob_get_clean();
include __DIR__ . '/../views/layout.php';
