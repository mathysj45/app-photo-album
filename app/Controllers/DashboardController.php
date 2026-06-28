<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\Album;
use App\Models\AlbumAccess;
use App\Models\Favorite;
use App\Models\Tag;
use App\Core\Logger;

class DashboardController extends Controller {
    public function __construct() {
        Auth::check();
    }

    public function index(): void {
        $userId = Auth::id();
        
        $albumModel = new Album();
        $tagModel = new Tag();
        $accessModel = new AlbumAccess();
        $favoriteModel = new Favorite();
        
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

    public function logout(): void {
        Logger::log("Déconnexion volontaire de l'utilisateur ID : " . Auth::id(), 'INFO');
        Auth::logout();
    }
}