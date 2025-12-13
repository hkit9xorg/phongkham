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

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM services WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function searchPaginated(string $keyword, int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $like = '%' . $keyword . '%';

        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM services WHERE name LIKE :keyword OR description LIKE :keyword');
        $stmt->execute([':keyword' => $like]);
        $total = (int)$stmt->fetchColumn();

        $stmt = $this->pdo->prepare('SELECT * FROM services WHERE name LIKE :keyword OR description LIKE :keyword ORDER BY updated_at DESC LIMIT :limit OFFSET :offset');
        $stmt->bindValue(':keyword', $like, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'data' => $stmt->fetchAll(),
            'total' => $total,
        ];
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

    public function countActive(): int
    {
        $stmt = $this->pdo->query('SELECT COUNT(*) AS total FROM services WHERE is_active = 1');
        $row = $stmt->fetch();
        return (int)($row['total'] ?? 0);
    }
}
