<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class AlbumAccess {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function hasAccess(int $albumId, int $userId): bool {
        $stmt = $this->db->prepare("SELECT 1 FROM album_access WHERE album_id = :album_id AND user_id = :user_id");
        $stmt->execute(['album_id' => $albumId, 'user_id' => $userId]);
        return (bool)$stmt->fetch();
    }

    public function canEdit(int $albumId, int $userId): bool {
        $stmt = $this->db->prepare("SELECT 1 FROM album_access WHERE album_id = :album_id AND user_id = :user_id AND permission = 'edit'");
        $stmt->execute(['album_id' => $albumId, 'user_id' => $userId]);
        return (bool)$stmt->fetch();
    }

    public function addAccess(int $albumId, int $userId, string $permission = 'view'): bool {
        $stmt = $this->db->prepare("INSERT INTO album_access (album_id, user_id, permission) VALUES (:album_id, :user_id, :permission) ON DUPLICATE KEY UPDATE permission = :permission");
        return $stmt->execute(['album_id' => $albumId, 'user_id' => $userId, 'permission' => $permission]);
    }

    public function removeAccess(int $albumId, int $userId): bool {
        $stmt = $this->db->prepare("DELETE FROM album_access WHERE album_id = :album_id AND user_id = :user_id");
        return $stmt->execute(['album_id' => $albumId, 'user_id' => $userId]);
    }

    public function getAuthorizedUsers(int $albumId): array {
        $stmt = $this->db->prepare("SELECT u.id, u.username, u.email, aa.permission FROM album_access aa JOIN users u ON aa.user_id = u.id WHERE aa.album_id = :album_id");
        $stmt->execute(['album_id' => $albumId]);
        return $stmt->fetchAll();
    }
}