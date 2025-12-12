<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/Response.php';
require_once __DIR__ . '/../models/DoctorSchedule.php';
require_once __DIR__ . '/../models/Appointment.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    Response::json('error', 'Phương thức không được hỗ trợ.');
}

$dateParam = $_GET['date'] ?? date('Y-m-d');
$doctorId = isset($_GET['doctor_id']) ? (int)$_GET['doctor_id'] : null;

try {
    $dateObj = new DateTime($dateParam);
} catch (Exception $e) {
    Response::json('error', 'Ngày không hợp lệ.');
}

$date = $dateObj->format('Y-m-d');

$appointmentModel = new Appointment($pdo);
$scheduleModel = new DoctorSchedule($pdo);

$targetDoctor = $doctorId;

if (!$targetDoctor) {
    $nextSchedule = $scheduleModel->findNextSchedule($date);
    if ($nextSchedule) {
        $targetDoctor = (int)$nextSchedule['doctor_id'];
        $date = $nextSchedule['work_date'];
    }
}

if (!$targetDoctor) {
    Response::json('error', 'Chưa thiết lập lịch làm việc cho bác sĩ.');
}

$occupied = $appointmentModel->getOccupiedSlots($targetDoctor, $date);
$slots = $scheduleModel->availableSlots($date, $targetDoctor, $occupied);

if (!$slots) {
    Response::json('error', 'Không tìm thấy khung giờ trống, vui lòng chọn ngày khác.');
}

Response::json('success', 'Gợi ý khung giờ trống', [
    'date' => $date,
    'doctor_id' => $targetDoctor,
    'slots' => $slots,
]);
