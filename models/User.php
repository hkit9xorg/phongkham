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

    public function countAll(): int
    {
        $stmt = $this->pdo->query('SELECT COUNT(*) AS total FROM users');
        $row = $stmt->fetch();
        return (int)($row['total'] ?? 0);
    }
}
