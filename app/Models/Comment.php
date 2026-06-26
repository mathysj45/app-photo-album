<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Comment {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create(int $photoId, int $userId, string $content): bool {
        $stmt = $this->db->prepare("INSERT INTO comments (photo_id, user_id, content) VALUES (:photo_id, :user_id, :content)");
        return $stmt->execute([
            'photo_id' => $photoId,
            'user_id' => $userId,
            'content' => $content
        ]);
    }

    public function getByPhoto(int $photoId): array {
        $stmt = $this->db->prepare("SELECT c.*, u.username FROM comments c JOIN users u ON c.user_id = u.id WHERE c.photo_id = :photo_id ORDER BY c.created_at ASC");
        $stmt->execute(['photo_id' => $photoId]);
        return $stmt->fetchAll();
    }

    public function getById(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM comments WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM comments WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}