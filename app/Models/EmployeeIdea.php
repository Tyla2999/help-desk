<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\Database;
use PDO;

class EmployeeIdea
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function recent(int $limit = 8): array
    {
        $stmt = $this->db->prepare('SELECT ei.id, ei.title, ei.description, ei.vote_count, ei.created_at, u.full_name FROM employee_ideas ei INNER JOIN users u ON u.id = ei.user_id ORDER BY ei.vote_count DESC, ei.created_at DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll();

        return is_array($rows) ? $rows : [];
    }

    public function create(int $userId, string $title, string $description): void
    {
        $stmt = $this->db->prepare('INSERT INTO employee_ideas (user_id, title, description, vote_count, created_at, updated_at) VALUES (:user_id, :title, :description, 0, NOW(), NOW())');
        $stmt->execute([
            'user_id' => $userId,
            'title' => $title,
            'description' => $description,
        ]);
    }

    public function incrementVote(int $ideaId): void
    {
        $stmt = $this->db->prepare('UPDATE employee_ideas SET vote_count = vote_count + 1, updated_at = NOW() WHERE id = :id');
        $stmt->execute(['id' => $ideaId]);
    }
}
