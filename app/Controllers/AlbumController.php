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
}