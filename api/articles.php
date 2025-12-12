<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/Csrf.php';
require_once __DIR__ . '/../helpers/Response.php';
require_once __DIR__ . '/../helpers/Auth.php';
require_once __DIR__ . '/../models/Article.php';

$user = Auth::user();
if (!$user) {
    Response::json('error', 'Vui lòng đăng nhập.');
}
Auth::requireRole(['admin', 'doctor']);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Response::json('error', 'Phương thức không hỗ trợ.');
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? ($data['csrf_token'] ?? '');
if (!Csrf::verify($token)) {
    Response::json('error', 'CSRF token không hợp lệ');
}

$title = trim($data['title'] ?? '');
$content = trim($data['content'] ?? '');

if ($title === '' || $content === '') {
    Response::json('error', 'Vui lòng nhập tiêu đề và nội dung');
}

$articleModel = new Article($pdo);
$articleModel->create([
    'title' => $title,
    'content' => $content,
    'category' => trim($data['category'] ?? 'news'),
    'status' => $data['status'] ?? 'draft',
    'author_id' => $user['id'],
]);

Response::json('success', 'Lưu bài viết thành công');
