<?php

class Doctor
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(array $data): int
    {
        $sql = 'INSERT INTO doctors (full_name, academic_title, specialty, avatar_url, philosophy, joined_at, is_active, created_at, updated_at)
                VALUES (:full_name, :academic_title, :specialty, :avatar_url, :philosophy, :joined_at, :is_active, NOW(), NOW())';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':full_name' => $data['full_name'],
            ':academic_title' => $data['academic_title'] ?? null,
            ':specialty' => $data['specialty'] ?? null,
            ':avatar_url' => $data['avatar_url'] ?? null,
            ':philosophy' => $data['philosophy'] ?? null,
            ':joined_at' => $data['joined_at'] ?: null,
            ':is_active' => (int)($data['is_active'] ?? 1),
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $sql = 'UPDATE doctors
                SET full_name = :full_name,
                    academic_title = :academic_title,
                    specialty = :specialty,
                    avatar_url = :avatar_url,
                    philosophy = :philosophy,
                    joined_at = :joined_at,
                    is_active = :is_active,
                    updated_at = NOW()
                WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':full_name' => $data['full_name'],
            ':academic_title' => $data['academic_title'] ?? null,
            ':specialty' => $data['specialty'] ?? null,
            ':avatar_url' => $data['avatar_url'] ?? null,
            ':philosophy' => $data['philosophy'] ?? null,
            ':joined_at' => $data['joined_at'] ?: null,
            ':is_active' => (int)($data['is_active'] ?? 1),
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM doctors WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM doctors WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $doctor = $stmt->fetch();

        return $doctor ?: null;
    }

    public function searchPaginated(string $keyword = '', int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $like = '%' . $keyword . '%';

        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM doctors WHERE full_name LIKE :kw_name OR specialty LIKE :kw_specialty');
        $stmt->execute([
            ':kw_name' => $like,
            ':kw_specialty' => $like,
        ]);
        $total = (int)$stmt->fetchColumn();

        $stmt = $this->pdo->prepare('SELECT * FROM doctors
            WHERE full_name LIKE :kw_name OR specialty LIKE :kw_specialty
            ORDER BY joined_at DESC, created_at DESC
            LIMIT :limit OFFSET :offset');
        $stmt->bindValue(':kw_name', $like, \PDO::PARAM_STR);
        $stmt->bindValue(':kw_specialty', $like, \PDO::PARAM_STR);
        $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        return [
            'data' => $stmt->fetchAll(),
            'total' => $total,
        ];
    }

    public function allActive(int $limit = 0): array
    {
        $sql = 'SELECT * FROM doctors WHERE is_active = 1 ORDER BY joined_at DESC, created_at DESC';
        if ($limit > 0) {
            $sql .= ' LIMIT ' . (int)$limit;
        }
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function countActive(): int
    {
        $stmt = $this->pdo->query('SELECT COUNT(*) AS total FROM doctors WHERE is_active = 1');
        $row = $stmt->fetch();
        return (int)($row['total'] ?? 0);
    }
}
