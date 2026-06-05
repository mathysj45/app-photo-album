<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visionnage de l'album</title>
</head>
<body>
    <a href="/dashboard">Retour au tableau de bord</a>
    <h1>Photos de l'album</h1>
    
    <?php foreach ($photos as $photo): ?>
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 20px;">
            <img src="<?= htmlspecialchars($photo['file_path']) ?>" alt="Photo" style="max-width: 300px; display: block;">
            <p><?= htmlspecialchars((string)$photo['description']) ?></p>
            
            <h3>Commentaires</h3>
            <ul>
                <?php foreach ($photo['comments'] as $comment): ?>
                    <li>
                        <strong><?= htmlspecialchars($comment['username']) ?>:</strong> 
                        <?= htmlspecialchars($comment['content']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            
            <form action="/comment/create" method="POST">
                <input type="hidden" name="photo_id" value="<?= $photo['id'] ?>">
                <input type="hidden" name="album_id" value="<?= $album_id ?>">
                <input type="text" name="content" placeholder="Ajouter un commentaire..." required>
                <button type="submit">Envoyer</button>
            </form>
        </div>
    <?php endforeach; ?>
</body>
</html>