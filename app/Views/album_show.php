<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visionnage de l'album</title>
</head>
<body>
    <nav>
        <a href="<?= BASE_URL ?>/dashboard">Retour au tableau de bord</a>
    </nav>
    <main>
        <h1>Photos de l'album : <?= htmlspecialchars($album['title'] ?? '') ?></h1>
        
        <?php if (isset($album['user_id']) && $album['user_id'] === $_SESSION['user_id']): ?>
            <div style="margin-bottom: 20px;">
                <a href="<?= BASE_URL ?>/album/edit?id=<?= $album['id'] ?>" style="margin-right: 15px;">Éditer l'album</a>
                <a href="<?= BASE_URL ?>/share/manage?id=<?= $album['id'] ?>" style="margin-right: 15px; color: #2ecc71;">Gérer les partages</a>
                <form action="<?= BASE_URL ?>/album/delete" method="POST" style="display:inline;" onsubmit="return confirm('Action irréversible. Confirmer la suppression ?');">
                    <input type="hidden" name="id" value="<?= $album['id'] ?>">
                    <button type="submit" style="background-color: #e74c3c;">Supprimer l'album</button>
                </form>
            </div>
        <?php endif; ?>

        <?php if (!empty($photos)): ?>
            <?php foreach ($photos as $photo): ?>
                <div style="border: 1px solid var(--border-color); padding: 15px; margin-bottom: 20px; border-radius: var(--border-radius); background: #fff;">
                    <img src="<?= BASE_URL ?><?= htmlspecialchars($photo['file_path']) ?>" alt="Photo" style="max-width: 100%; display: block; border-radius: var(--border-radius); margin-bottom: 10px;">
                    <p><?= nl2br(htmlspecialchars((string)$photo['description'])) ?></p>
                    
                    <?php if (!empty($photo['capture_date'])): ?>
                        <small style="display:block; color:#555;">Prise le : <?= htmlspecialchars(date('d/m/Y', strtotime($photo['capture_date']))) ?></small>
                    <?php endif; ?>
                    
                    <?php if (!empty($photo['location'])): ?>
                        <small style="display:block; color:#555; margin-bottom: 10px;">Lieu : <?= htmlspecialchars($photo['location']) ?></small>
                    <?php endif; ?>

                    <?php if (isset($album['user_id']) && $album['user_id'] === $_SESSION['user_id']): ?>
                        <div style="margin-top: 10px; padding-bottom: 15px; border-bottom: 1px solid var(--border-color);">
                            <a href="<?= BASE_URL ?>/photo/edit?id=<?= $photo['id'] ?>" style="font-size: 0.9rem; margin-right: 15px;">Éditer la photo</a>
                            <form action="<?= BASE_URL ?>/photo/delete" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer définitivement cette photo ?');">
                                <input type="hidden" name="id" value="<?= $photo['id'] ?>">
                                <input type="hidden" name="album_id" value="<?= $album_id ?>">
                                <button type="submit" style="padding: 4px 8px; font-size: 0.8rem; background-color: #e74c3c;">Supprimer</button>
                            </form>
                        </div>
                    <?php endif; ?>

                    <h3 style="margin-top: 15px;">Commentaires</h3>
                    <?php if (!empty($photo['comments'])): ?>
                        <ul style="display: block; padding-left: 0;">
                            <?php foreach ($photo['comments'] as $comment): ?>
                                <li style="margin-bottom: 10px; padding: 10px; background: var(--background-color); border-radius: var(--border-radius); display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <strong><?= htmlspecialchars($comment['username']) ?>:</strong> 
                                        <?= nl2br(htmlspecialchars($comment['content'])) ?>
                                    </div>
                                    <?php if ($comment['user_id'] === $_SESSION['user_id']): ?>
                                        <form action="<?= BASE_URL ?>/comment/delete" method="POST" style="display:inline; margin-left: 10px;" onsubmit="return confirm('Supprimer ce commentaire ?');">
                                            <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                            <input type="hidden" name="album_id" value="<?= $album_id ?>">
                                            <button type="submit" style="padding: 5px 10px; font-size: 0.8rem; background-color: #e74c3c;">X</button>
                                        </form>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p style="font-size: 0.9rem; color: #666;">Aucun commentaire.</p>
                    <?php endif; ?>
                    
                    <form action="<?= BASE_URL ?>/comment/create" method="POST" style="margin-top: 15px; box-shadow: none; padding: 0; max-width: 100%;">
                        <input type="hidden" name="photo_id" value="<?= $photo['id'] ?>">
                        <input type="hidden" name="album_id" value="<?= $album_id ?>">
                        <input type="text" name="content" placeholder="Ajouter un commentaire..." required style="margin-bottom: 10px;">
                        <button type="submit">Envoyer</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Cet album ne contient aucune photo pour le moment.</p>
        <?php endif; ?>
    </main>
</body>
</html>