<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\Photo;
use App\Models\Album;

class PhotoController extends Controller {
    private const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/gif'];
    private const MAX_SIZE = 5242880;

    public function __construct() {
        Auth::check();
    }

    public function upload(): void {
        $albumId = filter_input(INPUT_GET, 'album_id', FILTER_VALIDATE_INT);

        if (!$albumId) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $description = trim($_POST['description'] ?? '');
            
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['photo']['tmp_name'];
                $fileSize = $_FILES['photo']['size'];
                $fileType = mime_content_type($fileTmpPath);

                if (in_array($fileType, self::ALLOWED_TYPES) && $fileSize <= self::MAX_SIZE) {
                    $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                    $newFileName = uniqid('img_', true) . '.' . $extension;
                    $uploadDir = __DIR__ . '/../../public/uploads/';
                    $destPath = $uploadDir . $newFileName;

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }

                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        $photoModel = new Photo();
                        $relativePath = '/uploads/' . $newFileName;
                        
                        if ($photoModel->create($albumId, $relativePath, $description)) {
                            header('Location: ' . BASE_URL . '/dashboard');
                            exit;
                        }
                    }
                }
            }
        }

        $this->render('upload_photo', ['album_id' => $albumId]);
    }
}