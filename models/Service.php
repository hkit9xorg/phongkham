<?php

class Service
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function allActive(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM services WHERE is_active = 1 ORDER BY name');
        return $stmt->fetchAll();
    }

    public function all(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM services ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO services (name, description, price, is_active, created_at, updated_at) VALUES (:name, :description, :price, :is_active, NOW(), NOW())');
        $stmt->execute([
            ':name' => $data['name'],
            ':description' => $data['description'] ?? null,
            ':price' => $data['price'] ?? null,
            ':is_active' => $data['is_active'] ?? 1,
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare('UPDATE services SET name = :name, description = :description, price = :price, is_active = :is_active, updated_at = NOW() WHERE id = :id');
        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['name'],
            ':description' => $data['description'] ?? null,
            ':price' => $data['price'] ?? null,
            ':is_active' => $data['is_active'] ?? 1,
        ]);
    }

    public function count(): int
    {
        $stmt = $this->pdo->query('SELECT COUNT(*) AS total FROM services');
        $row = $stmt->fetch();
        return (int)($row['total'] ?? 0);
    }
}
