<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\Photo;

class SearchController extends Controller {
    public function __construct() {
        Auth::check();
    }

    public function index(): void {
        $query = trim($_GET['q'] ?? '');
        $tagFilter = trim($_GET['tag'] ?? '');
        $dateFilter = trim($_GET['date'] ?? '');

        $photos = [];
        if (!empty($query) || !empty($tagFilter) || !empty($dateFilter)) {
            $photoModel = new Photo();
            $photos = $photoModel->searchPhotos(Auth::id(), $query, $tagFilter, $dateFilter);
        }

        $this->render('search', [
            'photos' => $photos,
            'query' => $query,
            'tagFilter' => $tagFilter,
            'dateFilter' => $dateFilter
        ]);
    }
}