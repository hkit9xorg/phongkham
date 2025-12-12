<?php

class Article
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function published(): array
    {
        $stmt = $this->pdo->query("SELECT a.*, u.full_name AS author_name FROM articles a LEFT JOIN users u ON a.author_id = u.id WHERE a.status = 'published' ORDER BY a.created_at DESC");
        return $stmt->fetchAll();
    }

    public function all(): array
    {
        $stmt = $this->pdo->query("SELECT a.*, u.full_name AS author_name FROM articles a LEFT JOIN users u ON a.author_id = u.id ORDER BY a.created_at DESC");
        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO articles (title, content, category, status, author_id, created_at, updated_at) VALUES (:title, :content, :category, :status, :author_id, NOW(), NOW())');
        $stmt->execute([
            ':title' => $data['title'],
            ':content' => $data['content'],
            ':category' => $data['category'] ?? 'news',
            ':status' => $data['status'] ?? 'draft',
            ':author_id' => $data['author_id'],
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare('UPDATE articles SET title = :title, content = :content, category = :category, status = :status, updated_at = NOW() WHERE id = :id');
        return $stmt->execute([
            ':id' => $id,
            ':title' => $data['title'],
            ':content' => $data['content'],
            ':category' => $data['category'] ?? 'news',
            ':status' => $data['status'] ?? 'draft',
        ]);
    }

    public function count(): int
    {
        $stmt = $this->pdo->query('SELECT COUNT(*) AS total FROM articles');
        $row = $stmt->fetch();
        return (int)($row['total'] ?? 0);
    }
}
