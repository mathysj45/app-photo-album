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
}