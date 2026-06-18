<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\Comment;

class CommentController extends Controller {
    public function __construct() {
        Auth::check();
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $photoId = filter_input(INPUT_POST, 'photo_id', FILTER_VALIDATE_INT);
            $albumId = filter_input(INPUT_POST, 'album_id', FILTER_VALIDATE_INT);
            $content = trim($_POST['content'] ?? '');

            if ($photoId && !empty($content)) {
                $commentModel = new Comment();
                $commentModel->create($photoId, Auth::id(), $content);
            }
            
            header('Location: ' . BASE_URL . '/album/show?id=' . $albumId);
            exit;
        }
    }
}