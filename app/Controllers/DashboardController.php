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
        $albumModel = new Album();
        $tagModel = new \App\Models\Tag();
        
        $albums = $albumModel->getByUser(Auth::id());
        
        foreach ($albums as &$album) {
            $album['tags'] = $tagModel->getByAlbum($album['id']);
        }
        unset($album);

        $this->render('dashboard', ['albums' => $albums]);
    }

    public function logout(): void {
        Auth::logout();
    }
}