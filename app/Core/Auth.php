<?php

namespace App\Core;

class Auth {
    public static function check(): void {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

    public static function id(): ?int {
        return $_SESSION['user_id'] ?? null;
    }

    public static function logout(): void {
        session_unset();
        session_destroy();
        header('Location: /login');
        exit;
    }
}