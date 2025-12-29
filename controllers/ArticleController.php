<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Article.php';

$articleModel = new Article($pdo);
$articleId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$articleId) {
    header('Location: /index.php');
    exit;
}

$article = $articleModel->findById($articleId);

if (!$article || ($article['status'] ?? '') !== 'published') {
    http_response_code(404);
    $title = 'Bài viết không tìm thấy';
    $article = null;
} else {
    $title = $article['title'] . ' - Bài viết';
}

$isHomePage = false;
ob_start();
include __DIR__ . '/../views/article_detail.php';
$content = ob_get_clean();
include __DIR__ . '/../views/layout.php';
