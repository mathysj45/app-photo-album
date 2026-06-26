<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Photo {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create(int $albumId, string $filePath, ?string $description): bool {
        $stmt = $this->db->prepare("INSERT INTO photos (album_id, file_path, description) VALUES (:album_id, :file_path, :description)");
        return $stmt->execute([
            'album_id' => $albumId,
            'file_path' => $filePath,
            'description' => $description
        ]);
    }

    public function getByAlbum(int $albumId): array {
        $stmt = $this->db->prepare("SELECT * FROM photos WHERE album_id = :album_id ORDER BY created_at DESC");
        $stmt->execute(['album_id' => $albumId]);
        return $stmt->fetchAll();
    }

    public function getById(int $id): array|false {
        $stmt = $this->db->prepare("SELECT p.*, a.user_id FROM photos p JOIN albums a ON p.album_id = a.id WHERE p.id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function update(int $id, ?string $description, ?string $captureDate, ?string $location): bool {
        $stmt = $this->db->prepare("UPDATE photos SET description = :description, capture_date = :capture_date, location = :location WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'description' => $description,
            'capture_date' => empty($captureDate) ? null : $captureDate,
            'location' => $location
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM photos WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}