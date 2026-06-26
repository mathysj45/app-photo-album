<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éditer l'album</title>
</head>
<body>
    <nav>
        <a href="<?= BASE_URL ?>/album/show?id=<?= $album['id'] ?>">Annuler</a>
    </nav>
    <main>
        <h1>Éditer : <?= htmlspecialchars($album['title']) ?></h1>
        <form action="<?= BASE_URL ?>/album/edit?id=<?= $album['id'] ?>" method="POST">
            <input type="text" name="title" value="<?= htmlspecialchars($album['title']) ?>" required>
            <textarea name="description"><?= htmlspecialchars((string)$album['description']) ?></textarea>
            <select name="visibility">
                <option value="private" <?= $album['visibility'] === 'private' ? 'selected' : '' ?>>Privé</option>
                <option value="public" <?= $album['visibility'] === 'public' ? 'selected' : '' ?>>Public</option>
                <option value="restricted" <?= $album['visibility'] === 'restricted' ? 'selected' : '' ?>>Restreint</option>
            </select>
            <button type="submit">Mettre à jour</button>
        </form>
    </main>
</body>
</html>