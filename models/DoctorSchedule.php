<?php

class DoctorSchedule
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function listForDoctor(int $doctorId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM doctor_schedules WHERE doctor_id = :doctor_id ORDER BY work_date ASC');
        $stmt->execute([':doctor_id' => $doctorId]);
        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO doctor_schedules (doctor_id, work_date, start_time, end_time, note, created_at, updated_at) VALUES (:doctor_id, :work_date, :start_time, :end_time, :note, NOW(), NOW())');
        $stmt->execute([
            ':doctor_id' => $data['doctor_id'],
            ':work_date' => $data['work_date'],
            ':start_time' => $data['start_time'],
            ':end_time' => $data['end_time'],
            ':note' => $data['note'] ?? null,
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function findByDate(string $date, ?int $doctorId = null): array
    {
        $sql = 'SELECT ds.*, d.full_name AS doctor_name FROM doctor_schedules ds JOIN doctors d ON ds.doctor_id = d.id WHERE ds.work_date = :date';
        $params = [':date' => $date];

        if ($doctorId) {
            $sql .= ' AND ds.doctor_id = :doctor_id';
            $params[':doctor_id'] = $doctorId;
        }

        $sql .= ' ORDER BY ds.start_time ASC';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findNextSchedule(string $fromDate): ?array
    {
        $stmt = $this->pdo->prepare('SELECT ds.*, d.full_name AS doctor_name FROM doctor_schedules ds JOIN doctors d ON ds.doctor_id = d.id WHERE ds.work_date >= :date ORDER BY ds.work_date ASC, ds.start_time ASC LIMIT 1');
        $stmt->execute([':date' => $fromDate]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function availableSlots(string $date, ?int $doctorId, array $occupied, int $slotMinutes = 30): array
    {
        $schedules = $this->findByDate($date, $doctorId);
        if (!$schedules && !$doctorId) {
            $next = $this->findNextSchedule($date);
            $schedules = $next ? [$next] : [];
        }

        $slots = [];
        $now = new DateTime();

        foreach ($schedules as $schedule) {
            $start = new DateTime("{$schedule['work_date']} {$schedule['start_time']}");
            $end = new DateTime("{$schedule['work_date']} {$schedule['end_time']}");

            while ($start < $end) {
                $slotLabel = $start->format('Y-m-d H:i');
                $timeLabel = $start->format('H:i');

                if ($start >= $now && !in_array($timeLabel, $occupied, true)) {
                    $slots[] = [
                        'doctor_id' => $schedule['doctor_id'],
                        'doctor_name' => $schedule['doctor_name'] ?? 'Bác sĩ',
                        'datetime' => $slotLabel,
                    ];
                }

                $start->modify("+{$slotMinutes} minutes");
            }
        }

        return array_slice($slots, 0, 10);
    }
}
