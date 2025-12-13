<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/../models/Article.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Appointment.php';
require_once __DIR__ . '/../helpers/Csrf.php';

$serviceModel = new Service($pdo);
$articleModel = new Article($pdo);
$userModel = new User($pdo);
$appointmentModel = new Appointment($pdo);

$services = $serviceModel->allActive();
$articles = $articleModel->published();
$doctors = $userModel->listDoctors();

$stats = [
    'customers' => $userModel->countAll(),
    'services' => $serviceModel->count(),
    'articles' => $articleModel->count(),
    'appointments' => $appointmentModel->count(),
    'doctors' => count($doctors),
];

$title = 'Phòng khám nha khoa - Trang chủ';
$isHomePage = true;
ob_start();
include __DIR__ . '/../views/home.php';
$content = ob_get_clean();
include __DIR__ . '/../views/layout.php';
