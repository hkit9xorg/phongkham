<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/Csrf.php';
require_once __DIR__ . '/../models/User.php';

$title = 'Đăng nhập';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $token = $_POST['csrf_token'] ?? '';

    if (!Csrf::verify($token)) {
        $errors[] = 'CSRF token không hợp lệ.';
    }

    if (empty($email) || empty($password)) {
        $errors[] = 'Email và mật khẩu là bắt buộc.';
    }

    if (!$errors) {
        $userModel = new User($pdo);
        $user = $userModel->findByEmail($email);
        if (!$user || !password_verify($password, $user['password'])) {
            $errors[] = 'Thông tin đăng nhập không đúng.';
        } else {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
            ];
            $_SESSION['flash'] = 'Đăng nhập thành công.';
            header('Location: /index.php');
            exit;
        }
    }
}

ob_start();
include __DIR__ . '/../views/login.php';
$content = ob_get_clean();
include __DIR__ . '/../views/layout.php';
