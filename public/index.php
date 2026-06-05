<?php

session_start();

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';
    $len = strlen($prefix);

    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

$router = new App\Core\Router();
$router->add('GET', '/register', 'UserController', 'register');
$router->add('POST', '/register', 'UserController', 'register');
$router->add('GET', '/login', 'UserController', 'login');
$router->add('POST', '/login', 'UserController', 'login');
$router->add('GET', '/dashboard', 'DashboardController', 'index');
$router->add('GET', '/logout', 'DashboardController', 'logout');
$router->add('GET', '/album/create', 'AlbumController', 'create');
$router->add('POST', '/album/create', 'AlbumController', 'create');
$router->add('GET', '/photo/upload', 'PhotoController', 'upload');
$router->add('POST', '/photo/upload', 'PhotoController', 'upload');
$router->dispatch($_SERVER['REQUEST_URI'];