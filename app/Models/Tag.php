<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Tag {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findOrCreate(string $name): int {
        $name = strtolower(trim($name));
        $stmt = $this->db->prepare("SELECT id FROM tags WHERE name = :name");
        $stmt->execute(['name' => $name]);
        $tag = $stmt->fetch();

        if ($tag) {
            return (int)$tag['id'];
        }

        $stmt = $this->db->prepare("INSERT INTO tags (name) VALUES (:name)");
        $stmt->execute(['name' => $name]);
        return (int)$this->db->lastInsertId();
    }

    public function attachToAlbum(int $albumId, int $tagId): void {
        $stmt = $this->db->prepare("INSERT IGNORE INTO album_tags (album_id, tag_id) VALUES (:album_id, :tag_id)");
        $stmt->execute(['album_id' => $albumId, 'tag_id' => $tagId]);
    }

    public function getByAlbum(int $albumId): array {
        $stmt = $this->db->prepare("SELECT t.name FROM tags t JOIN album_tags at ON t.id = at.tag_id WHERE at.album_id = :album_id");
        $stmt->execute(['album_id' => $albumId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}