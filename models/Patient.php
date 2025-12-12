<?php

class Patient
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(int $userId, array $data = []): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO patients (user_id, dob, gender, address, medical_history, allergies, created_at, updated_at) VALUES (:user_id, :dob, :gender, :address, :medical_history, :allergies, NOW(), NOW())');
        $stmt->execute([
            ':user_id' => $userId,
            ':dob' => $data['dob'] ?? null,
            ':gender' => $data['gender'] ?? null,
            ':address' => $data['address'] ?? null,
            ':medical_history' => $data['medical_history'] ?? null,
            ':allergies' => $data['allergies'] ?? null,
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function findByUserId(int $userId): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM patients WHERE user_id = :user_id LIMIT 1');
        $stmt->execute([':user_id' => $userId]);
        $patient = $stmt->fetch();
        return $patient ?: null;
    }
}
