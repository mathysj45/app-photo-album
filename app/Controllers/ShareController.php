<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\Album;
use App\Models\AlbumAccess;
use App\Models\User;

class ShareController extends Controller {
    public function __construct() {
        Auth::check();
    }

    public function manage(): void {
        $albumId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$albumId) { header('Location: ' . BASE_URL . '/dashboard'); exit; }

        $albumModel = new Album();
        $album = $albumModel->getById($albumId);

        if (!$album || (int)$album['user_id'] !== Auth::id()) {
            header('Location: ' . BASE_URL . '/dashboard'); exit;
        }

        $accessModel = new AlbumAccess();
        $authorizedUsers = $accessModel->getAuthorizedUsers($albumId);

        $this->render('share_manage', ['album' => $album, 'authorizedUsers' => $authorizedUsers]);
    }

    public function add(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $albumId = filter_input(INPUT_POST, 'album_id', FILTER_VALIDATE_INT);
            $email = trim($_POST['email'] ?? '');
            $permission = $_POST['permission'] ?? 'view';

            $albumModel = new Album();
            $album = $albumModel->getById($albumId);

            if ($album && (int)$album['user_id'] === Auth::id()) {
                $userModel = new User();
                $user = $userModel->findByEmail($email);

                if ($user) {
                    $accessModel = new AlbumAccess();
                    $accessModel->addAccess($albumId, $user['id'], $permission);
                }
            }
            header('Location: ' . BASE_URL . '/share/manage?id=' . $albumId);
            exit;
        }
    }

    public function remove(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $albumId = filter_input(INPUT_POST, 'album_id', FILTER_VALIDATE_INT);
            $userId = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

            $albumModel = new Album();
            $album = $albumModel->getById($albumId);

            if ($album && (int)$album['user_id'] === Auth::id()) {
                $accessModel = new AlbumAccess();
                $accessModel->removeAccess($albumId, $userId);
            }
            header('Location: ' . BASE_URL . '/share/manage?id=' . $albumId);
            exit;
        }
    }

    public function token(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $albumId = filter_input(INPUT_POST, 'album_id', FILTER_VALIDATE_INT);
            $action = $_POST['action'] ?? 'generate';

            $albumModel = new Album();
            $album = $albumModel->getById($albumId);

            if ($album && (int)$album['user_id'] === Auth::id()) {
                $token = ($action === 'generate') ? bin2hex(random_bytes(16)) : null;
                $albumModel->updateShareToken($albumId, $token);
            }
            header('Location: ' . BASE_URL . '/share/manage?id=' . $albumId);
            exit;
        }
    }
}