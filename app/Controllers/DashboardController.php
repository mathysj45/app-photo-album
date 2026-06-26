<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\Album;

class DashboardController extends Controller {
    public function __construct() {
        Auth::check();
    }

    public function index(): void {
        $userId = Auth::id();
        
        $albumModel = new Album();
        $tagModel = new \App\Models\Tag();
        $accessModel = new \App\Models\AlbumAccess();
        $favoriteModel = new \App\Models\Favorite();
        
        $albums = $albumModel->getByUser($userId);
        foreach ($albums as &$album) {
            $album['tags'] = $tagModel->getByAlbum($album['id']);
        }
        unset($album);

        $sharedAlbums = $accessModel->getSharedWithUser($userId);
        $favoritePhotos = $favoriteModel->getByUser($userId);

        $this->render('dashboard', [
            'albums' => $albums,
            'sharedAlbums' => $sharedAlbums,
            'favoritePhotos' => $favoritePhotos
        ]);
    }
}