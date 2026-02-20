<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\Database;
use PDO;

class Ticket
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function create(array $payload): void
    {
        $stmt = $this->db->prepare('INSERT INTO tickets (name, department, problem, priority, status, created_at, updated_at) VALUES (:name, :department, :problem, :priority, :status, NOW(), NOW())');
        $stmt->execute([
            'name' => $payload['name'],
            'department' => $payload['department'],
            'problem' => $payload['problem'],
            'priority' => $payload['priority'],
            'status' => $payload['status'],
        ]);
    }

    public function recent(int $limit = 5): array
    {
        $stmt = $this->db->prepare('SELECT id, name, department, problem, priority, status, created_at FROM tickets ORDER BY created_at DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll();

        return is_array($rows) ? $rows : [];
    }

    public function all(): array
    {
        $stmt = $this->db->query('SELECT id, name, department, problem, priority, status, created_at FROM tickets ORDER BY created_at DESC');
        $rows = $stmt->fetchAll();

        return is_array($rows) ? $rows : [];
    }
}
