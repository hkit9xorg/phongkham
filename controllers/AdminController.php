<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/../models/Article.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Appointment.php';
require_once __DIR__ . '/../helpers/Csrf.php';
require_once __DIR__ . '/../helpers/Auth.php';

$user = Auth::user();
if (!$user || $user['role'] !== 'admin') {
    http_response_code(403);
    die('Bạn không có quyền truy cập trang này');
}

$serviceModel = new Service($pdo);
$articleModel = new Article($pdo);
$userModel = new User($pdo);
$appointmentModel = new Appointment($pdo);

$module = $_GET['module'] ?? 'services';
$page = max(1, (int)($_GET['p'] ?? 1));
$keyword = trim($_GET['q'] ?? '');
$status = $_GET['status'] ?? '';
$perPage = 10;
$currentRecord = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!Csrf::verify($token)) {
        $_SESSION['flash'] = 'CSRF token không hợp lệ.';
        header("Location: /index.php?page=admin&module={$module}");
        exit;
    }

    if ($module === 'services') {
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'price' => $_POST['price'] !== '' ? $_POST['price'] : null,
            'description' => trim($_POST['description'] ?? ''),
            'is_active' => (int)($_POST['is_active'] ?? 1),
        ];
        if ($id > 0) {
            $serviceModel->update($id, $data);
            $_SESSION['flash'] = 'Đã cập nhật dịch vụ.';
        } else {
            $serviceModel->create($data);
            $_SESSION['flash'] = 'Đã thêm dịch vụ.';
        }
    } elseif ($module === 'articles') {
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'content' => trim($_POST['content'] ?? ''),
            'category' => trim($_POST['category'] ?? 'news'),
            'status' => $_POST['status'] ?? 'draft',
            'author_id' => $user['id'],
        ];
        if ($id > 0) {
            $articleModel->update($id, $data);
            $_SESSION['flash'] = 'Đã cập nhật bài viết.';
        } else {
            $articleModel->create($data);
            $_SESSION['flash'] = 'Đã thêm bài viết.';
        }
    } elseif ($module === 'appointments') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $appointmentModel->updateStatus($id, [
                'status' => $_POST['status'] ?? 'pending',
                'doctor_id' => $_POST['doctor_id'] !== '' ? (int)$_POST['doctor_id'] : null,
                'appointment_date' => $_POST['appointment_date'] ?? null,
                'notes' => trim($_POST['notes'] ?? ''),
            ]);
            $_SESSION['flash'] = 'Đã cập nhật lịch hẹn.';
        }
    }

    header("Location: /index.php?page=admin&module={$module}");
    exit;
}

if (isset($_GET['edit_id'])) {
    $editId = (int)$_GET['edit_id'];
    if ($module === 'services') {
        $currentRecord = $serviceModel->findById($editId);
    } elseif ($module === 'articles') {
        $currentRecord = $articleModel->findById($editId);
    } elseif ($module === 'appointments') {
        $currentRecord = $appointmentModel->findById($editId);
    }
}

if ($module === 'services') {
    $result = $serviceModel->searchPaginated($keyword, $page, $perPage);
    $items = $result['data'];
    $total = $result['total'];
} elseif ($module === 'articles') {
    $result = $articleModel->searchPaginated($keyword, $page, $perPage);
    $items = $result['data'];
    $total = $result['total'];
} else {
    $filters = ['keyword' => $keyword];
    if ($status !== '') {
        $filters['status'] = $status;
    }
    $result = $appointmentModel->searchPaginated($filters, $page, $perPage);
    $items = $result['data'];
    $total = $result['total'];
}

$totalPages = max(1, (int)ceil($total / $perPage));
$doctors = $userModel->listDoctors();

$title = 'Quản trị chi tiết';
ob_start();
include __DIR__ . '/../views/admin.php';
$content = ob_get_clean();
include __DIR__ . '/../views/layout.php';
