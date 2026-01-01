<?php

class AppointmentChange
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function log(int $appointmentId, string $oldDate, string $newDate, int $changedBy, string $role): bool
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO appointment_changes (appointment_id, old_date, new_date, changed_by, changed_by_role, created_at)
             VALUES (:appointment_id, :old_date, :new_date, :changed_by, :changed_by_role, NOW())'
        );

        return $stmt->execute([
            ':appointment_id' => $appointmentId,
            ':old_date' => $oldDate,
            ':new_date' => $newDate,
            ':changed_by' => $changedBy,
            ':changed_by_role' => $role,
        ]);
    }

    public function latestForAppointments(array $appointmentIds): array
    {
        if (empty($appointmentIds)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($appointmentIds), '?'));
        $sql = "SELECT ac.*
                FROM appointment_changes ac
                WHERE ac.appointment_id IN ({$placeholders})
                ORDER BY ac.created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($appointmentIds));
        $rows = $stmt->fetchAll();

        $latest = [];
        foreach ($rows as $row) {
            $appId = (int)$row['appointment_id'];
            if (!isset($latest[$appId])) {
                $latest[$appId] = $row;
            }
        }

        return $latest;
    }
}
