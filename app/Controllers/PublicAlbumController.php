<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Album;
use App\Models\Photo;
use App\Models\Comment;

class PublicAlbumController extends Controller {
    // Aucune restriction Auth::check() ici
    
    public function showShared(): void {
        $token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_SPECIAL_CHARS);
        if (!$token) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $albumModel = new Album();
        $album = $albumModel->getByToken($token);

        if (!$album) {
            http_response_code(404);
            echo "Ce lien de partage n'existe pas ou a été révoqué.";
            exit;
        }

        $photoModel = new Photo();
        $commentModel = new Comment();
        $photos = $photoModel->getByAlbum($album['id']);

        foreach ($photos as &$photo) {
            $photo['comments'] = $commentModel->getByPhoto($photo['id']);
        }
        unset($photo);

        $this->render('album_shared', ['album' => $album, 'photos' => $photos, 'token' => $token]);
    }
}