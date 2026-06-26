<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éditer la photo</title>
</head>
<body>
    <nav>
        <a href="<?= BASE_URL ?>/album/show?id=<?= $photo['album_id'] ?>">Annuler</a>
    </nav>
    <main>
        <h1>Éditer les métadonnées</h1>
        <div style="margin-bottom: 20px;">
            <img src="<?= BASE_URL ?><?= htmlspecialchars($photo['file_path']) ?>" alt="Aperçu" style="max-width: 200px; border-radius: var(--border-radius);">
        </div>
        <form action="<?= BASE_URL ?>/photo/edit?id=<?= $photo['id'] ?>" method="POST">
            <label for="description">Description :</label>
            <textarea name="description" id="description"><?= htmlspecialchars((string)$photo['description']) ?></textarea>
            
            <label for="capture_date">Date de prise de vue :</label>
            <input type="date" name="capture_date" id="capture_date" value="<?= htmlspecialchars((string)$photo['capture_date']) ?>">
            
            <label for="location">Lieu / Événement :</label>
            <input type="text" name="location" id="location" value="<?= htmlspecialchars((string)$photo['location']) ?>">
            
            <button type="submit">Mettre à jour</button>
        </form>
    </main>
</body>
</html>