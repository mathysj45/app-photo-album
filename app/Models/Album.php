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

    public function update(int $id, string $title, ?string $description, string $visibility): bool {
        $stmt = $this->db->prepare("UPDATE albums SET title = :title, description = :description, visibility = :visibility WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'visibility' => $visibility
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM albums WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function getByUser(int $userId): array {
        $stmt = $this->db->prepare("SELECT * FROM albums WHERE user_id = :user_id ORDER BY created_at DESC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function getById(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM albums WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function updateShareToken(int $id, ?string $token): bool {
        $stmt = $this->db->prepare("UPDATE albums SET share_token = :token WHERE id = :id");
        return $stmt->execute(['id' => $id, 'token' => $token]);
    }

    public function getByToken(string $token): array|false {
        $stmt = $this->db->prepare("SELECT * FROM albums WHERE share_token = :token");
        $stmt->execute(['token' => $token]);
        return $stmt->fetch();
    }
}