<?php
namespace App\Core;

abstract class Controller {
    protected function render(string $view, array $data = []): void {
        extract($data);
        $viewFile = __DIR__ . '/../Views/' . $view . '.php';

        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            http_response_code(404);
            echo "View not found";
        }
    }
}