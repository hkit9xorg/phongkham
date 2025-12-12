<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/../models/Article.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Appointment.php';
require_once __DIR__ . '/../models/DoctorSchedule.php';
require_once __DIR__ . '/../models/Patient.php';
require_once __DIR__ . '/../helpers/Csrf.php';
require_once __DIR__ . '/../helpers/Auth.php';

$user = Auth::user();
if (!$user) {
    header('Location: /index.php?page=login');
    exit;
}

$serviceModel = new Service($pdo);
$articleModel = new Article($pdo);
$userModel = new User($pdo);
$appointmentModel = new Appointment($pdo);
$scheduleModel = new DoctorSchedule($pdo);
$patientModel = new Patient($pdo);

$userDetails = $userModel->findById($user['id']);

$stats = [
    'customers' => $userModel->countAll(),
    'services' => $serviceModel->count(),
    'articles' => $articleModel->count(),
    'appointments' => $appointmentModel->count(),
];

$appointments = [];
$doctorSchedules = [];
$patientProfile = null;
if ($user['role'] === 'customer') {
    $appointments = $appointmentModel->listForUser($user['id']);
    $patientProfile = $patientModel->findByUserId($user['id']);
} elseif ($user['role'] === 'doctor') {
    $appointments = $appointmentModel->listForDoctor($user['id']);
    $doctorSchedules = $scheduleModel->listForDoctor($user['id']);
} else {
    $appointments = $appointmentModel->all();
}

$title = 'Dashboard';
ob_start();
include __DIR__ . '/../views/dashboard.php';
$content = ob_get_clean();
include __DIR__ . '/../views/layout.php';
