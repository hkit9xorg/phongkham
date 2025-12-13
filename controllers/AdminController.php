<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/../models/Article.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Appointment.php';
require_once __DIR__ . '/../models/Doctor.php';
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
$doctorModel = new Doctor($pdo);

$module = $_GET['module'] ?? 'services';
$page = max(1, (int)($_GET['p'] ?? 1));
$keyword = trim($_GET['q'] ?? '');
$status = $_GET['status'] ?? '';
$perPage = 10;
$currentRecord = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    $action = $_POST['action'] ?? 'save';
    if (!Csrf::verify($token)) {
        $_SESSION['flash'] = 'CSRF token không hợp lệ.';
        header("Location: /index.php?page=admin&module={$module}");
        exit;
    }

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            if ($module === 'services') {
                $serviceModel->delete($id);
                $_SESSION['flash'] = 'Đã xóa dịch vụ.';
            } elseif ($module === 'articles') {
                $articleModel->delete($id);
                $_SESSION['flash'] = 'Đã xóa bài viết.';
            } elseif ($module === 'users') {
                $userModel->delete($id);
                $_SESSION['flash'] = 'Đã xóa người dùng.';
            } elseif ($module === 'doctors') {
                $doctorModel->delete($id);
                $_SESSION['flash'] = 'Đã xóa hồ sơ bác sĩ.';
            } elseif ($module === 'appointments') {
                $appointmentModel->delete($id);
                $_SESSION['flash'] = 'Đã xóa lịch hẹn.';
            }
        }
    } else {
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
        } elseif ($module === 'doctors') {
            $id = (int)($_POST['id'] ?? 0);
            $data = [
                'full_name' => trim($_POST['full_name'] ?? ''),
                'academic_title' => trim($_POST['academic_title'] ?? ''),
                'specialty' => trim($_POST['specialty'] ?? ''),
                'avatar_url' => trim($_POST['avatar_url'] ?? ''),
                'philosophy' => trim($_POST['philosophy'] ?? ''),
                'joined_at' => $_POST['joined_at'] ?? null,
                'is_active' => (int)($_POST['is_active'] ?? 1),
            ];

            if ($id > 0) {
                $doctorModel->update($id, $data);
                $_SESSION['flash'] = 'Đã cập nhật bác sĩ.';
            } else {
                $doctorModel->create($data);
                $_SESSION['flash'] = 'Đã thêm bác sĩ.';
            }
        } elseif ($module === 'users') {
            $id = (int)($_POST['id'] ?? 0);
            $role = $_POST['role'] ?? '';
            if ($id > 0 && in_array($role, ['admin', 'doctor', 'customer'], true)) {
                $userModel->updateRole($id, $role);
                $_SESSION['flash'] = 'Đã cập nhật quyền người dùng.';
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
    } elseif ($module === 'doctors') {
        $currentRecord = $doctorModel->findById($editId);
    } elseif ($module === 'users') {
        $currentRecord = $userModel->findById($editId);
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
} elseif ($module === 'doctors') {
    $result = $doctorModel->searchPaginated($keyword, $page, $perPage);
    $items = $result['data'];
    $total = $result['total'];
} elseif ($module === 'users') {
    $result = $userModel->paginate($keyword, $page, $perPage);
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
$doctorUsers = $userModel->listDoctors();

$title = 'Quản trị chi tiết';
ob_start();
include __DIR__ . '/../views/admin.php';
$content = ob_get_clean();
include __DIR__ . '/../views/layout.php';
