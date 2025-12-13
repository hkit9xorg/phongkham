<?php

class Appointment
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO appointments (customer_id, doctor_id, service_id, full_name, phone, email, appointment_date, status, type, notes, reschedule_request, created_at, updated_at) VALUES (:customer_id, :doctor_id, :service_id, :full_name, :phone, :email, :appointment_date, :status, :type, :notes, :reschedule_request, NOW(), NOW())');
        $stmt->execute([
            ':customer_id' => $data['customer_id'] ?? null,
            ':doctor_id' => $data['doctor_id'] ?? null,
            ':service_id' => $data['service_id'] ?? null,
            ':full_name' => $data['full_name'],
            ':phone' => $data['phone'],
            ':email' => $data['email'] ?? null,
            ':appointment_date' => $data['appointment_date'],
            ':status' => $data['status'] ?? 'pending',
            ':type' => $data['type'] ?? 'standard',
            ':notes' => $data['notes'] ?? null,
            ':reschedule_request' => $data['reschedule_request'] ?? null,
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function listForUser(int $userId): array
    {
        $stmt = $this->pdo->prepare("SELECT a.*, s.name AS service_name, d.full_name AS doctor_name FROM appointments a LEFT JOIN services s ON a.service_id = s.id LEFT JOIN users d ON a.doctor_id = d.id WHERE a.customer_id = :customer_id ORDER BY a.appointment_date DESC");
        $stmt->execute([':customer_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function listForDoctor(int $doctorId): array
    {
        $stmt = $this->pdo->prepare("SELECT a.*, s.name AS service_name, c.full_name AS customer_name FROM appointments a LEFT JOIN services s ON a.service_id = s.id LEFT JOIN users c ON a.customer_id = c.id WHERE a.doctor_id = :doctor_id ORDER BY a.appointment_date DESC");
        $stmt->execute([':doctor_id' => $doctorId]);
        return $stmt->fetchAll();
    }

    public function all(): array
    {
        $sql = "SELECT a.*, s.name AS service_name, c.full_name AS customer_name, d.full_name AS doctor_name FROM appointments a
                LEFT JOIN services s ON a.service_id = s.id
                LEFT JOIN users c ON a.customer_id = c.id
                LEFT JOIN users d ON a.doctor_id = d.id
                ORDER BY a.appointment_date DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT a.*, s.name AS service_name, c.full_name AS customer_name, d.full_name AS doctor_name FROM appointments a
                LEFT JOIN services s ON a.service_id = s.id
                LEFT JOIN users c ON a.customer_id = c.id
                LEFT JOIN users d ON a.doctor_id = d.id
                WHERE a.id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function searchPaginated(array $filters, int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $keyword = '%' . ($filters['keyword'] ?? '') . '%';
        $status = $filters['status'] ?? '';
        $doctorId = $filters['doctor_id'] ?? null;

        $where = ['(a.full_name LIKE :keyword OR a.phone LIKE :keyword)'];
        $params = [':keyword' => $keyword];

        if ($status !== '') {
            $where[] = 'a.status = :status';
            $params[':status'] = $status;
        }

        if ($doctorId) {
            $where[] = 'a.doctor_id = :doctor_id';
            $params[':doctor_id'] = $doctorId;
        }

        $whereSql = implode(' AND ', $where);

        $countSql = "SELECT COUNT(*) FROM appointments a WHERE {$whereSql}";
        $stmt = $this->pdo->prepare($countSql);
        $stmt->execute($params);
        $total = (int)$stmt->fetchColumn();

        $sql = "SELECT a.*, s.name AS service_name, c.full_name AS customer_name, d.full_name AS doctor_name FROM appointments a
                LEFT JOIN services s ON a.service_id = s.id
                LEFT JOIN users c ON a.customer_id = c.id
                LEFT JOIN users d ON a.doctor_id = d.id
                WHERE {$whereSql}
                ORDER BY a.appointment_date DESC
                LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'data' => $stmt->fetchAll(),
            'total' => $total,
        ];
    }

    public function updateStatus(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare('UPDATE appointments SET status = :status, doctor_id = :doctor_id, appointment_date = :appointment_date, notes = :notes, updated_at = NOW() WHERE id = :id');
        return $stmt->execute([
            ':id' => $id,
            ':status' => $data['status'],
            ':doctor_id' => $data['doctor_id'] ?? null,
            ':appointment_date' => $data['appointment_date'] ?? null,
            ':notes' => $data['notes'] ?? null,
        ]);
    }

    public function count(): int
    {
        $stmt = $this->pdo->query('SELECT COUNT(*) AS total FROM appointments');
        $row = $stmt->fetch();
        return (int)($row['total'] ?? 0);
    }

    public function countByStatus(): array
    {
        $stmt = $this->pdo->query('SELECT status, COUNT(*) AS total FROM appointments GROUP BY status');
        $results = $stmt->fetchAll();

        $counts = [];
        foreach ($results as $row) {
            $counts[$row['status']] = (int)$row['total'];
        }

        return $counts;
    }

    public function getOccupiedSlots(int $doctorId, string $date): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT appointment_date FROM appointments WHERE doctor_id = :doctor_id AND DATE(appointment_date) = :work_date AND status NOT IN ('cancelled')"
        );
        $stmt->execute([
            ':doctor_id' => $doctorId,
            ':work_date' => $date,
        ]);

        return array_map(
            static fn($row) => date('H:i', strtotime($row['appointment_date'])),
            $stmt->fetchAll()
        );
    }
}
