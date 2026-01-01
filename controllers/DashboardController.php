<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/../models/Article.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Appointment.php';
require_once __DIR__ . '/../models/AppointmentChange.php';
require_once __DIR__ . '/../models/DoctorSchedule.php';
require_once __DIR__ . '/../models/Patient.php';
require_once __DIR__ . '/../models/Doctor.php';
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
$appointmentChangeModel = new AppointmentChange($pdo);
$scheduleModel = new DoctorSchedule($pdo);
$patientModel = new Patient($pdo);
$doctorModel = new Doctor($pdo);

$userDetails = $userModel->findById($user['id']);

$stats = [
    'customers' => $userModel->countAll(),
    'services' => $serviceModel->count(),
    'articles' => $articleModel->count(),
    'appointments' => $appointmentModel->count(),
];

$appointmentStatusCounts = $appointmentModel->countByStatus();
$activeServices = $serviceModel->countActive();
$serviceVisibility = [
    'active' => $activeServices,
    'hidden' => max(0, $serviceModel->count() - $activeServices),
];
$roleDistribution = $userModel->countByRole();
$doctorStats = [];

$appointments = [];
$appointmentChanges = [];
$customerAppointments = [];
$appointmentHistory = [];
$doctorSchedules = [];
$patientProfile = null;
$doctorProfile = null;
if ($user['role'] === 'customer') {
    $appointments = $appointmentModel->listForUser($user['id']);
    $customerAppointments = array_filter($appointments, static function ($appointment) {
        return in_array($appointment['status'], ['pending', 'confirmed', 'rescheduled'], true);
    });
    $appointmentHistory = array_filter($appointments, static function ($appointment) {
        return !in_array($appointment['status'], ['pending', 'confirmed', 'rescheduled'], true);
    });
    $patientProfile = $patientModel->findByUserId($user['id']);
} elseif ($user['role'] === 'doctor') {
    $doctorProfile = $doctorModel->findByUserId($user['id']);
    if ($doctorProfile) {
        $appointments = $appointmentModel->listForDoctor((int)$doctorProfile['id']);
        $doctorSchedules = $scheduleModel->listForDoctor((int)$doctorProfile['id']);
        $doctorStats = [
            'appointments' => count($appointments),
            'schedules' => count($doctorSchedules),
        ];
    }
} else {
    $appointments = $appointmentModel->all();
}

if (!empty($appointments)) {
    $appointmentChanges = $appointmentChangeModel->latestForAppointments(array_column($appointments, 'id'));
}

$title = 'Dashboard';
ob_start();
include __DIR__ . '/../views/dashboard.php';
$content = ob_get_clean();
include __DIR__ . '/../views/layout.php';
