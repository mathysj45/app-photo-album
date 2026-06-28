<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class User {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create(string $username, string $email, string $password): bool {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password_hash)");
        return $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password_hash' => $hash
        ]);
    }

    public function findByEmail(string $email): array|false {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT id, username, email, bio, profile_picture FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function updateProfile(int $id, string $bio, ?string $profilePicture): bool {
        if ($profilePicture) {
            $stmt = $this->db->prepare("UPDATE users SET bio = :bio, profile_picture = :profile_picture WHERE id = :id");
            return $stmt->execute(['id' => $id, 'bio' => $bio, 'profile_picture' => $profilePicture]);
        }
        $stmt = $this->db->prepare("UPDATE users SET bio = :bio WHERE id = :id");
        return $stmt->execute(['id' => $id, 'bio' => $bio]);
    }
}