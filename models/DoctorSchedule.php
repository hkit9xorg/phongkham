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
}
