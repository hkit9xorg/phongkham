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

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT a.*, u.full_name AS author_name FROM articles a LEFT JOIN users u ON a.author_id = u.id WHERE a.id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function searchPaginated(string $keyword, int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $like = '%' . $keyword . '%';

        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM articles WHERE title LIKE :title_keyword OR content LIKE :content_keyword');
        $stmt->execute([':title_keyword' => $like, ':content_keyword' => $like]);
        $total = (int)$stmt->fetchColumn();

        $stmt = $this->pdo->prepare("SELECT a.*, u.full_name AS author_name FROM articles a LEFT JOIN users u ON a.author_id = u.id WHERE a.title LIKE :title_keyword OR a.content LIKE :content_keyword ORDER BY a.updated_at DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':title_keyword', $like, PDO::PARAM_STR);
        $stmt->bindValue(':content_keyword', $like, PDO::PARAM_STR);
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

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM articles WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }

    public function count(): int
    {
        $stmt = $this->pdo->query('SELECT COUNT(*) AS total FROM articles');
        $row = $stmt->fetch();
        return (int)($row['total'] ?? 0);
    }
}
