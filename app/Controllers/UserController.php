<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Core\Logger;

class UserController extends Controller {
    public function register(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (!empty($username) && !empty($email) && !empty($password)) {
                $userModel = new User();
                if ($userModel->create($username, $email, $password)) {
                    Logger::log("Inscription réussie pour l'email : " . $email, 'INFO');
                    header('Location: ' . BASE_URL . '/login');
                    exit;
                }
            }
        }
        $this->render('register');
    }

    public function login(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (!empty($email) && !empty($password)) {
                $userModel = new User();
                $user = $userModel->findByEmail($email);

                if ($user && password_verify($password, $user['password_hash'])) {
                    $_SESSION['user_id'] = $user['id'];
                    Logger::log("Connexion réussie de l'utilisateur ID : " . $user['id'], 'INFO');
                    header('Location: ' . BASE_URL . '/dashboard');
                    exit;
                } else {
                    Logger::log("Échec de connexion pour l'email : " . $email, 'WARNING');
                }
            }
        }
        $this->render('login');
    }
}