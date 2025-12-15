<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Article.php';
require_once __DIR__ . '/../helpers/Csrf.php';
require_once __DIR__ . '/../helpers/Auth.php';
require_once __DIR__ . '/../helpers/Upload.php';

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

    $thumbnailPath = null;
    if (!empty($_FILES['thumbnail'])) {
        $uploadResult = Upload::image($_FILES['thumbnail'], 'articles');
        if ($uploadResult['status'] === 'error') {
            $_SESSION['flash'] = $uploadResult['message'];
            header('Location: /index.php?page=create_article');
            exit;
        }
        if ($uploadResult['status'] === 'success') {
            $thumbnailPath = $uploadResult['path'];
        }
    }

    $articleModel->create([
        'title' => trim($_POST['title'] ?? ''),
        'content' => trim($_POST['content'] ?? ''),
        'category' => trim($_POST['category'] ?? 'news'),
        'status' => $_POST['status'] ?? 'draft',
        'author_id' => $user['id'],
        'thumbnail' => $thumbnailPath,
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
