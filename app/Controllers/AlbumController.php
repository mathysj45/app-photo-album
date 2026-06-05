<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\Album;

class AlbumController extends Controller {
    public function __construct() {
        Auth::check();
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? null);
            $visibility = $_POST['visibility'] ?? 'private';

            if (!empty($title)) {
                $albumModel = new Album();
                $userId = Auth::id();
                
                if ($albumModel->create($userId, $title, $description, $visibility)) {
                    header('Location: /dashboard');
                    exit;
                }
            }
        }
        $this->render('create_album');
    }

    public function show(): void {
        $albumId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        
        if (!$albumId) {
            header('Location: /dashboard');
            exit;
        }

        $photoModel = new \App\Models\Photo();
        $commentModel = new \App\Models\Comment();
        
        $photos = $photoModel->getByAlbum($albumId);
        
        foreach ($photos as &$photo) {
            $photo['comments'] = $commentModel->getByPhoto($photo['id']);
        }
        unset($photo);

        $this->render('album_show', [
            'photos' => $photos,
            'album_id' => $albumId
        ]);
    }
}