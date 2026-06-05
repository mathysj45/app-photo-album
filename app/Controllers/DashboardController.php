<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;

class DashboardController extends Controller {
    public function __construct() {
        Auth::check();
    }

    public function index(): void {
        $this->render('dashboard');
    }

    public function logout(): void {
        Auth::logout();
    }
}