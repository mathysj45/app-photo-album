<?php

namespace App\Core;

class Router {
    private array $routes =[];

    public function add(string $method, string $path, string $controller, string $action): void {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function dispatch(string $uri): void {
        $parsedUrl = parse_url($uri);
        $path = $parsedUrl['path'] ?? '/';
        
        $basePath = '/app-photo-album/public';
        if (strpos($path, $basePath) === 0) {
            $path = substr($path, strlen($basePath));
        }
        
        if ($path === '') {
            $path = '/';
        }

        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['path'] === $path && $route['method'] === $method) {
                $controllerClass = "\\App\\Controllers\\" . $route['controller'];
                
                if (class_exists($controllerClass)) {
                    $controllerInstance = new $controllerClass();
                    if (method_exists($controllerInstance, $route['action'])) {
                        $controllerInstance->{$route['action']}();
                        return;
                    }
                }
            }
        }
        
        http_response_code(404);
        echo "404 Not Found";
    }
}