<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Favorite {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function toggle(int $userId, int $photoId): void {
        $stmt = $this->db->prepare("SELECT 1 FROM favorite_photos WHERE user_id = :user_id AND photo_id = :photo_id");
        $stmt->execute(['user_id' => $userId, 'photo_id' => $photoId]);
        
        if ($stmt->fetch()) {
            $stmt = $this->db->prepare("DELETE FROM favorite_photos WHERE user_id = :user_id AND photo_id = :photo_id");
        } else {
            $stmt = $this->db->prepare("INSERT INTO favorite_photos (user_id, photo_id) VALUES (:user_id, :photo_id)");
        }
        $stmt->execute(['user_id' => $userId, 'photo_id' => $photoId]);
    }

    public function getByUser(int $userId): array {
        $stmt = $this->db->prepare("
            SELECT p.*, a.title as album_title 
            FROM favorite_photos f 
            JOIN photos p ON f.photo_id = p.id 
            JOIN albums a ON p.album_id = a.id 
            WHERE f.user_id = :user_id
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }
}