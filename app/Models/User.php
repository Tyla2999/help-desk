<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\Database;
use PDO;

class User
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT id, full_name, email, role, status, created_at FROM users WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();

        return is_array($user) ? $user : null;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        return is_array($user) ? $user : null;
    }

    public function create(array $payload): void
    {
        $stmt = $this->db->prepare('INSERT INTO users (full_name, email, password_hash, role, status, created_at, updated_at) VALUES (:full_name, :email, :password_hash, :role, :status, NOW(), NOW())');
        $stmt->execute([
            'full_name' => $payload['full_name'],
            'email' => $payload['email'],
            'password_hash' => $payload['password_hash'],
            'role' => $payload['role'],
            'status' => $payload['status'],
        ]);
    }

    public function pendingUsers(): array
    {
        $stmt = $this->db->query("SELECT id, full_name, email, role, status, created_at FROM users WHERE status = 'pending' ORDER BY created_at ASC");
        $rows = $stmt->fetchAll();

        return is_array($rows) ? $rows : [];
    }

    public function updateStatus(int $userId, string $status): void
    {
        $stmt = $this->db->prepare('UPDATE users SET status = :status, updated_at = NOW() WHERE id = :id');
        $stmt->execute([
            'status' => $status,
            'id' => $userId,
        ]);
    }
}
