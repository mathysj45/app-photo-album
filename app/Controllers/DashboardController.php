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
        $albums = $albumModel->getByUser(Auth::id());
        $this->render('dashboard', ['albums' => $albums]);
    }

    public function logout(): void {
        Auth::logout();
    }
}