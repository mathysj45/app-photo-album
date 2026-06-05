<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
</head>
<body>
    <h1>Tableau de bord</h1>
    <nav>
        <a href="/logout">Se déconnecter</a>
    </nav>
    <main>
    <h2>Vos albums</h2>
    <a href="/album/create">Créer un album</a>
    <ul>
        <?php foreach ($albums as $album): ?>
            <li>
                <strong><a href="/album/show?id=<?= $album['id'] ?>"><?= htmlspecialchars($album['title']) ?></a></strong>
                <p><?= htmlspecialchars((string)$album['description']) ?></p>
                <small>Visibilité: <?= htmlspecialchars($album['visibility']) ?></small><br>
                    <small>Étiquettes: <?= htmlspecialchars(implode(', ', $album['tags'])) ?></small>
                <br>
                <a href="/photo/upload?album_id=<?= $album['id'] ?>">Ajouter une photo</a>
            </li>
        <?php endforeach; ?>
    </ul>
</main>
</body>
</html>