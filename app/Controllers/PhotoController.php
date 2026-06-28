<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\Photo;
use App\Core\Logger;

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
            // Récupération des nouveaux champs
            $captureDate = !empty($_POST['capture_date']) ? trim($_POST['capture_date']) : null;
            $location = trim($_POST['location'] ?? '');
            
            if (isset($_FILES['photos'])) {
                $photoModel = new \App\Models\Photo();
                $uploadDir = __DIR__ . '/../../public/uploads/';
                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $fileCount = count($_FILES['photos']['name']);
                $successCount = 0;

                for ($i = 0; $i < $fileCount; $i++) {
                    if ($_FILES['photos']['error'][$i] === UPLOAD_ERR_OK) {
                        $fileTmpPath = $_FILES['photos']['tmp_name'][$i];
                        $fileSize = $_FILES['photos']['size'][$i];
                        $fileType = mime_content_type($fileTmpPath);

                        if (in_array($fileType, self::ALLOWED_TYPES) && $fileSize <= self::MAX_SIZE) {
                            $extension = pathinfo($_FILES['photos']['name'][$i], PATHINFO_EXTENSION);
                            $newFileName = uniqid('img_', true) . '.' . $extension;
                            $destPath = $uploadDir . $newFileName;

                            if (move_uploaded_file($fileTmpPath, $destPath)) {
                                $relativePath = '/uploads/' . $newFileName;
                                
                                // Ajout des variables $captureDate et $location à la création
                                if ($photoModel->create($albumId, $relativePath, $description, $captureDate, $location)) {
                                    \App\Core\Logger::log("Photo téléchargée avec succès. Chemin : " . $relativePath, 'INFO');
                                    $successCount++;
                                }
                            }
                        }
                    }
                }
                
                if ($successCount > 0) {
                    header("Location: " . BASE_URL . "/album/show?id=" . $albumId);
                    exit;
                }
            }
        }

        $this->render('upload_photo', ['album_id' => $albumId]);
    }

    public function edit(): void {
        $photoId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$photoId) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }

        $photoModel = new Photo();
        $photo = $photoModel->getById($photoId);

        if (!$photo || (int)$photo['user_id'] !== Auth::id()) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $description = trim($_POST['description'] ?? '');
            $captureDate = trim($_POST['capture_date'] ?? '');
            $location = trim($_POST['location'] ?? '');

            $photoModel->update($photoId, $description, $captureDate, $location);
            Logger::log("Photo métadonnées mises à jour ID : " . $photoId, 'INFO');
            header('Location: ' . BASE_URL . '/album/show?id=' . $photo['album_id']);
            exit;
        }

        $this->render('photo_edit', ['photo' => $photo]);
    }

    public function delete(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $photoId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $albumId = filter_input(INPUT_POST, 'album_id', FILTER_VALIDATE_INT);

            if ($photoId) {
                $photoModel = new Photo();
                $photo = $photoModel->getById($photoId);

                if ($photo && (int)$photo['user_id'] === Auth::id()) {
                    $filePath = __DIR__ . '/../../public' . $photo['file_path'];
                    if (file_exists($filePath)) {
                        unlink($filePath);
                        Logger::log("Fichier photo supprimé physiquement du disque : " . $filePath, 'WARNING');
                    }
                    $photoModel->delete($photoId);
                    Logger::log("Enregistrement photo supprimé de la BDD ID : " . $photoId, 'WARNING');
                }
            }
            $redirectUrl = $albumId ? '/album/show?id=' . $albumId : '/dashboard';
            header('Location: ' . BASE_URL . $redirectUrl);
            exit;
        }
    }
}