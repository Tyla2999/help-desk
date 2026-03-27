<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\Database;
use PDO;

class Announcement
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function all(): array
    {
        $stmt = $this->db->query('SELECT id, title, detail, image_url, created_at FROM announcements ORDER BY created_at DESC');
        $rows = $stmt->fetchAll();

        return is_array($rows) ? $rows : [];
    }

    public function create(array $payload): void
    {
        $stmt = $this->db->prepare('INSERT INTO announcements (title, detail, image_url, created_at, updated_at) VALUES (:title, :detail, :image_url, NOW(), NOW())');
        $stmt->execute([
            'title' => $payload['title'],
            'detail' => $payload['detail'],
            'image_url' => $payload['image_url'],
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM announcements WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
