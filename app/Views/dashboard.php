<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
</head>
<body>
    <h1>Tableau de bord</h1>
    <nav>
        <a href="<?= BASE_URL ?>/logout">Se déconnecter</a>
    </nav>
    <main>
    <h2>Mes albums personnels</h2>
    <a href="<?= BASE_URL ?>/album/create" style="display:inline-block; margin-bottom:15px; padding:8px 12px; background:var(--accent-color); color:#fff; border-radius:4px;">Créer un album</a>
    <ul>
        <?php foreach ($albums as $album): ?>
            <li>
                <strong><a href="<?= BASE_URL ?>/album/show?id=<?= $album['id'] ?>"><?= htmlspecialchars($album['title']) ?></a></strong>
                <p><?= htmlspecialchars((string)$album['description']) ?></p>
                <small>Visibilité: <?= htmlspecialchars($album['visibility']) ?></small><br>
                <small>Étiquettes: <?= htmlspecialchars(implode(', ', $album['tags'])) ?></small><br>
                <a href="<?= BASE_URL ?>/photo/upload?album_id=<?= $album['id'] ?>">Ajouter une photo</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <h2 style="margin-top: 40px;">Albums partagés avec moi</h2>
    <?php if (empty($sharedAlbums)): ?>
        <p>Aucun album partagé.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($sharedAlbums as $shared): ?>
                <li>
                    <strong><a href="<?= BASE_URL ?>/album/show?id=<?= $shared['id'] ?>"><?= htmlspecialchars($shared['title']) ?></a></strong>
                    <p><?= htmlspecialchars((string)$shared['description']) ?></p>
                    <small>Propriétaire: <?= htmlspecialchars($shared['owner_name']) ?></small><br>
                    <small>Permission: <?= htmlspecialchars($shared['permission']) === 'edit' ? 'Lecture et Écriture' : 'Lecture seule' ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <h2 style="margin-top: 40px;">Mes photos favorites</h2>
    <?php if (empty($favoritePhotos)): ?>
        <p>Aucune photo favorite.</p>
    <?php else: ?>
        <ul style="grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));">
            <?php foreach ($favoritePhotos as $fav): ?>
                <li>
                    <a href="<?= BASE_URL ?>/album/show?id=<?= $fav['album_id'] ?>">
                        <img src="<?= BASE_URL ?><?= htmlspecialchars($fav['file_path']) ?>" alt="Favorite" style="width:100%; height:150px; object-fit:cover;">
                    </a>
                    <small>Album: <?= htmlspecialchars($fav['album_title']) ?></small>
                    <form action="<?= BASE_URL ?>/favorite/toggle" method="POST" style="box-shadow:none; padding:0; margin-top:10px;">
                        <input type="hidden" name="photo_id" value="<?= $fav['id'] ?>">
                        <button type="submit" style="padding:4px 8px; font-size:0.8rem; background:#e74c3c;">Retirer des favoris</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</main>
</body>
</html>