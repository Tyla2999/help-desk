<?php

declare(strict_types=1);

namespace App\Models;

use App\Services\Database;
use PDO;

class SiteContent
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function getValue(string $key, string $default = ''): string
    {
        $stmt = $this->db->prepare('SELECT content_value FROM site_contents WHERE content_key = :key LIMIT 1');
        $stmt->execute(['key' => $key]);
        $row = $stmt->fetch();

        return is_array($row) ? (string) ($row['content_value'] ?? $default) : $default;
    }

    public function getMany(array $keys): array
    {
        if ($keys === []) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($keys), '?'));
        $stmt = $this->db->prepare("SELECT content_key, content_value FROM site_contents WHERE content_key IN ($placeholders)");
        $stmt->execute($keys);
        $rows = $stmt->fetchAll();

        $result = [];
        if (!is_array($rows)) {
            return $result;
        }

        foreach ($rows as $row) {
            $result[(string) ($row['content_key'] ?? '')] = (string) ($row['content_value'] ?? '');
        }

        return $result;
    }

    public function upsertMany(array $values): void
    {
        $stmt = $this->db->prepare('INSERT INTO site_contents (content_key, content_value, updated_at) VALUES (:content_key, :content_value, NOW()) ON DUPLICATE KEY UPDATE content_value = VALUES(content_value), updated_at = NOW()');

        foreach ($values as $key => $value) {
            $stmt->execute([
                'content_key' => (string) $key,
                'content_value' => (string) $value,
            ]);
        }
    }
}
