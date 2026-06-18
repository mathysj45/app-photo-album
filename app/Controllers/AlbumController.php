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
            $tagsInput = $_POST['tags'] ?? '';

            if (!empty($title)) {
                $albumModel = new Album();
                $userId = Auth::id();
                
                $albumId = $albumModel->create($userId, $title, $description, $visibility);
                
                if ($albumId) {
                    if (!empty($tagsInput)) {
                        $tagModel = new \App\Models\Tag();
                        $tagsArray = array_unique(array_filter(array_map('trim', explode(',', $tagsInput))));
                        
                        foreach ($tagsArray as $tagName) {
                            if (!empty($tagName)) {
                                $tagId = $tagModel->findOrCreate($tagName);
                                $tagModel->attachToAlbum($albumId, $tagId);
                            }
                        }
                    }
                    header('Location: ' . BASE_URL . '/dashboard');
                    exit;
                }
            }
        }
        $this->render('create_album');
    }

    public function show(): void {
        $albumId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        
        if (!$albumId) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }

        $albumModel = new \App\Models\Album();
        $album = $albumModel->getById($albumId);

        if (!$album) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }

        $userId = Auth::id();

        if ((int)$album['user_id'] !== $userId && $album['visibility'] !== 'public') {
            if ($album['visibility'] === 'private') {
                header('Location: ' . BASE_URL . '/dashboard');
                exit;
            }

            if ($album['visibility'] === 'restricted') {
                $accessModel = new \App\Models\AlbumAccess();
                if (!$accessModel->hasAccess($albumId, $userId)) {
                    header('Location: ' . BASE_URL . '/dashboard');
                    exit;
                }
            }
        }

        $photoModel = new \App\Models\Photo();
        $commentModel = new \App\Models\Comment();
        
        $photos = $photoModel->getByAlbum($albumId);
        
        foreach ($photos as &$photo) {
            $photo['comments'] = $commentModel->getByPhoto($photo['id']);
        }
        unset($photo);

        $this->render('album_show', [
            'album' => $album,
            'photos' => $photos,
            'album_id' => $albumId
        ]);
    }
}