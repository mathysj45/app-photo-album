<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Album {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create(int $userId, string $title, ?string $description, string $visibility): int|false {
        $stmt = $this->db->prepare("INSERT INTO albums (user_id, title, description, visibility) VALUES (:user_id, :title, :description, :visibility)");
        $success = $stmt->execute([
            'user_id' => $userId,
            'title' => $title,
            'description' => $description,
            'visibility' => $visibility
        ]);
        return $success ? (int)$this->db->lastInsertId() : false;
    }

    public function getByUser(int $userId): array {
        $stmt = $this->db->prepare("SELECT * FROM albums WHERE user_id = :user_id ORDER BY created_at DESC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }
}