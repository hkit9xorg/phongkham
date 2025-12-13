<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Article.php';
require_once __DIR__ . '/../helpers/Csrf.php';
require_once __DIR__ . '/../helpers/Auth.php';

$user = Auth::user();
if (!$user || !in_array($user['role'], ['admin', 'doctor'], true)) {
    http_response_code(403);
    die('Bạn không có quyền truy cập trang này');
}

$articleModel = new Article($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!Csrf::verify($token)) {
        $_SESSION['flash'] = 'CSRF token không hợp lệ.';
        header('Location: /index.php?page=create_article');
        exit;
    }

    $articleModel->create([
        'title' => trim($_POST['title'] ?? ''),
        'content' => trim($_POST['content'] ?? ''),
        'category' => trim($_POST['category'] ?? 'news'),
        'status' => $_POST['status'] ?? 'draft',
        'author_id' => $user['id'],
    ]);

    $_SESSION['flash'] = 'Đã lưu bài viết mới.';
    header('Location: /index.php?page=create_article');
    exit;
}

$title = 'Viết bài mới';
ob_start();
include __DIR__ . '/../views/article_form.php';
$content = ob_get_clean();
include __DIR__ . '/../views/layout.php';
