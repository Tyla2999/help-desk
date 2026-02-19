<?php

declare(strict_types=1);

namespace App\Models;

class JsonStore
{
    public function __construct(private string $filePath)
    {
        if (!file_exists($this->filePath)) {
            $this->write([]);
        }
    }

    public function all(): array
    {
        $raw = file_get_contents($this->filePath);
        if ($raw === false || trim($raw) === '') {
            return [];
        }

        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }

    public function prepend(array $item): void
    {
        $items = $this->all();
        array_unshift($items, $item);
        $this->write($items);
    }

    private function write(array $data): void
    {
        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if ($json === false) {
            return;
        }

        file_put_contents($this->filePath, $json, LOCK_EX);
    }
}
