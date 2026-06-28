<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\Album;
use App\Models\Tag;
use App\Models\AlbumAccess;
use App\Models\Photo;
use App\Models\Comment;
use App\Core\Logger;

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
                    Logger::log("Album créé ID : " . $albumId . " par l'utilisateur ID : " . $userId, 'INFO');
                    if (!empty($tagsInput)) {
                        $tagModel = new Tag();
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

        $albumModel = new Album();
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
                $accessModel = new AlbumAccess();
                if (!$accessModel->hasAccess($albumId, $userId)) {
                    header('Location: ' . BASE_URL . '/dashboard');
                    exit;
                }
            }
        }

        $photoModel = new Photo();
        $commentModel = new Comment();
        
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

    public function edit(): void {
        $albumId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$albumId) { 
            header('Location: ' . BASE_URL . '/dashboard'); 
            exit; 
        }

        $albumModel = new Album();
        $album = $albumModel->getById($albumId);

        if (!$album || (int)$album['user_id'] !== Auth::id()) {
            header('Location: ' . BASE_URL . '/dashboard'); 
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? null);
            $visibility = $_POST['visibility'] ?? 'private';

            if (!empty($title)) {
                $albumModel->update($albumId, $title, $description, $visibility);
                Logger::log("Album mis à jour ID : " . $albumId, 'INFO');
                header('Location: ' . BASE_URL . '/album/show?id=' . $albumId);
                exit;
            }
        }
        $this->render('album_edit', ['album' => $album]);
    }

    public function delete(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $albumId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            if ($albumId) {
                $albumModel = new Album();
                $album = $albumModel->getById($albumId);
                if ($album && (int)$album['user_id'] === Auth::id()) {
                    $albumModel->delete($albumId);
                    Logger::log("Album supprimé ID : " . $albumId, 'WARNING');
                }
            }
        }
        header('Location: ' . BASE_URL . '/dashboard');
        exit;
    }
}