<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\User;
use App\Models\Album;
use App\Core\Logger;

class ProfileController extends Controller {
    public function __construct() {
        Auth::check();
    }

    public function show(): void {
        $userId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: Auth::id();
        $userModel = new User();
        $user = $userModel->getById($userId);

        if (!$user) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }

        $albumModel = new Album();
        $albums = $albumModel->getPublicOrSharedAlbumsByOwner($userId, Auth::id());

        $this->render('profile_show', [
            'user' => $user,
            'albums' => $albums,
            'isOwnProfile' => ($userId === Auth::id())
        ]);
    }

    public function edit(): void {
        $userId = Auth::id();
        $userModel = new User();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bio = trim($_POST['bio'] ?? '');
            $profilePic = null;

            if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/uploads/profiles/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $ext = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
                $filename = 'profile_' . $userId . '_' . time() . '.' . $ext;
                
                if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $uploadDir . $filename)) {
                    $profilePic = '/uploads/profiles/' . $filename;
                }
            }

            $userModel->updateProfile($userId, $bio, $profilePic);
            Logger::log("Profil mis à jour pour l'utilisateur ID : " . $userId, 'INFO');
            header('Location: ' . BASE_URL . '/profile/show');
            exit;
        }

        $user = $userModel->getById($userId);
        $this->render('profile_edit', ['user' => $user]);
    }
}