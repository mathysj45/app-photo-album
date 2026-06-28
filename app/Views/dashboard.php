<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
</head>
<body>
    <nav>
        <span style="color: white; font-weight: bold;">Mon Application Photo</span>
        <a href="<?= BASE_URL ?>/logout" style="color: var(--danger-color);">Se déconnecter</a>
    </nav>
    <main>
        <h2>Mes albums personnels</h2>
        <a href="<?= BASE_URL ?>/album/create" class="btn" style="margin-bottom: 20px;">Créer un album</a>
        
        <?php if (empty($albums)): ?>
            <p>Aucun album personnel.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($albums as $album): ?>
                    <li>
                        <strong><a href="<?= BASE_URL ?>/album/show?id=<?= $album['id'] ?>"><?= htmlspecialchars($album['title']) ?></a></strong>
                        <p><?= htmlspecialchars((string)$album['description']) ?></p>
                        <small>Visibilité: <?= htmlspecialchars($album['visibility']) ?></small><br>
                        <small>Étiquettes: <?= htmlspecialchars(implode(', ', $album['tags'])) ?></small><br>
                        
                        <div style="margin-top: auto; display: flex; gap: 10px; align-items: stretch; border-top: 1px solid var(--border-color); padding-top: 15px;">
                            <a href="<?= BASE_URL ?>/photo/upload?album_id=<?= $album['id'] ?>" class="btn" style="flex: 1; display: flex; align-items: center; justify-content: center; text-align: center; padding: 8px; margin: 0;">Ajouter photo</a>
                            <form action="<?= BASE_URL ?>/album/delete" method="POST" style="margin: 0; padding: 0; box-shadow: none; background: transparent; flex: 1; display: flex;" onsubmit="return confirm('Action irréversible. Confirmer la suppression de cet album et de toutes ses photos ?');">
                                <input type="hidden" name="id" value="<?= $album['id'] ?>">
                                <button type="submit" class="btn" style="background-color: var(--danger-color); width: 100%; margin: 0; padding: 8px; display: flex; align-items: center; justify-content: center; font-family: inherit;">Supprimer</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

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
            <ul class="photo-grid">
                <?php foreach ($favoritePhotos as $fav): ?>
                    <li class="photo-card" style="padding: 0; overflow: hidden;">
                        <a href="<?= BASE_URL ?>/album/show?id=<?= $fav['album_id'] ?>" style="display: block;">
                            <img src="<?= BASE_URL ?><?= htmlspecialchars($fav['file_path']) ?>" alt="Favorite" style="width: 100%; height: 200px; object-fit: cover; border-bottom: 1px solid var(--border-color); border-radius: 0;">
                        </a>
                        <div style="padding: 15px;">
                            <small style="display: block; margin-bottom: 10px;">Album: <?= htmlspecialchars($fav['album_title']) ?></small>
                            <form action="<?= BASE_URL ?>/favorite/toggle" method="POST" style="box-shadow:none; padding:0; margin:0; background: transparent;">
                                <input type="hidden" name="photo_id" value="<?= $fav['id'] ?>">
                                <button type="submit" class="btn" style="background-color: var(--danger-color); width: 100%;">Retirer des favoris</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </main>
</body>
</html>