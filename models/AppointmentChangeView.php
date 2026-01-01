<?php

class AppointmentChangeView
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function recentForUser(array $user, ?int $doctorId = null, int $limit = 8): array
    {
        $conditions = [];
        $params = [
            ':user_id' => $user['id'],
            ':limit' => $limit,
        ];

        switch ($user['role']) {
            case 'admin':
                $conditions[] = '1=1';
                break;
            case 'doctor':
                if ($doctorId) {
                    $conditions[] = 'a.doctor_id = :doctor_id';
                    $params[':doctor_id'] = $doctorId;
                } else {
                    return [];
                }
                break;
            case 'customer':
                $conditions[] = 'a.customer_id = :customer_id';
                $params[':customer_id'] = $user['id'];
                break;
            default:
                return [];
        }

        $where = implode(' AND ', $conditions);

        $sql = "SELECT ac.id AS change_id, ac.appointment_id, ac.old_date, ac.new_date, ac.created_at, ac.changed_by, ac.changed_by_role,
                       a.full_name AS appointment_name, a.customer_id, a.doctor_id, a.status AS appointment_status,
                       s.name AS service_name, u.full_name AS changer_name,
                       COALESCE(acv.is_read, 0) AS is_read, acv.read_at
                FROM appointment_changes ac
                INNER JOIN appointments a ON ac.appointment_id = a.id
                LEFT JOIN services s ON a.service_id = s.id
                LEFT JOIN users u ON ac.changed_by = u.id
                LEFT JOIN appointment_change_views acv ON acv.change_id = ac.id AND acv.user_id = :user_id
                WHERE {$where}
                ORDER BY ac.created_at DESC
                LIMIT :limit";

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $value) {
            if ($key === ':limit') {
                $stmt->bindValue($key, (int)$value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($key, $value);
            }
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function setReadStatus(int $changeId, int $userId, bool $isRead): bool
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO appointment_change_views (change_id, user_id, is_read, read_at, created_at)
             VALUES (:change_id, :user_id, :is_read, :read_at, NOW())
             ON DUPLICATE KEY UPDATE is_read = VALUES(is_read), read_at = VALUES(read_at)'
        );

        return $stmt->execute([
            ':change_id' => $changeId,
            ':user_id' => $userId,
            ':is_read' => $isRead ? 1 : 0,
            ':read_at' => $isRead ? date('Y-m-d H:i:s') : null,
        ]);
    }
}
