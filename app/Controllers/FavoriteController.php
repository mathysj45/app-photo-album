<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\Favorite;

class FavoriteController extends Controller {
    public function __construct() {
        Auth::check();
    }

    public function toggle(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $photoId = filter_input(INPUT_POST, 'photo_id', FILTER_VALIDATE_INT);
            $albumId = filter_input(INPUT_POST, 'album_id', FILTER_VALIDATE_INT);

            if ($photoId) {
                $favoriteModel = new Favorite();
                $favoriteModel->toggle(Auth::id(), $photoId);
            }

            $redirectUrl = $albumId ? '/album/show?id=' . $albumId : '/dashboard';
            header('Location: ' . BASE_URL . $redirectUrl);
            exit;
        }
    }
}