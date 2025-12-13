<?php

class User
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function createCustomer(array $data): int
    {
        $sql = 'INSERT INTO users (full_name, email, phone, password_hash, role, is_active, created_at, updated_at) 
                VALUES (:full_name, :email, :phone, :password_hash, "customer", 1, NOW(), NOW())';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':full_name' => $data['full_name'],
            ':email' => $data['email'],
            ':phone' => $data['phone'] ?? null,
            ':password_hash' => $data['password_hash'],
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function listDoctors(): array
    {
        $stmt = $this->pdo->query("SELECT id, full_name, email FROM users WHERE role = 'doctor' AND is_active = 1 ORDER BY full_name");
        return $stmt->fetchAll();
    }

    public function updateProfile(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare('UPDATE users SET full_name = :full_name, phone = :phone, updated_at = NOW() WHERE id = :id');
        return $stmt->execute([
            ':id' => $id,
            ':full_name' => $data['full_name'],
            ':phone' => $data['phone'] ?? null,
        ]);
    }

    public function updatePassword(int $id, string $passwordHash): bool
    {
        $stmt = $this->pdo->prepare('UPDATE users SET password_hash = :password_hash, updated_at = NOW() WHERE id = :id');
        return $stmt->execute([
            ':id' => $id,
            ':password_hash' => $passwordHash,
        ]);
    }

    public function paginateByRole(string $role, string $keyword = '', int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $like = '%' . $keyword . '%';

        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM users WHERE role = :role AND (full_name LIKE :keyword OR email LIKE :keyword)');
        $stmt->execute([':role' => $role, ':keyword' => $like]);
        $total = (int)$stmt->fetchColumn();

        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE role = :role AND (full_name LIKE :keyword OR email LIKE :keyword) ORDER BY created_at DESC LIMIT :limit OFFSET :offset');
        $stmt->bindValue(':role', $role, PDO::PARAM_STR);
        $stmt->bindValue(':keyword', $like, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'data' => $stmt->fetchAll(),
            'total' => $total,
        ];
    }

    public function countAll(): int
    {
        $stmt = $this->pdo->query('SELECT COUNT(*) AS total FROM users');
        $row = $stmt->fetch();
        return (int)($row['total'] ?? 0);
    }

    public function countByRole(): array
    {
        $stmt = $this->pdo->query('SELECT role, COUNT(*) AS total FROM users GROUP BY role');
        $results = $stmt->fetchAll();

        $counts = [];
        foreach ($results as $row) {
            $counts[$row['role']] = (int)$row['total'];
        }

        return $counts;
    }
}
