<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les partages</title>
</head>
<body>
    <nav>
        <a href="<?= BASE_URL ?>/album/show?id=<?= $album['id'] ?>">Retour à l'album</a>
    </nav>
    <main>
        <h1>Partage : <?= htmlspecialchars($album['title']) ?></h1>

        <section style="background: #fff; padding: 20px; border-radius: var(--border-radius); margin-bottom: 20px;">
            <h2>Lien public</h2>
            <?php if (!empty($album['share_token'])): ?>
                <?php $shareLink = "http://" . $_SERVER['HTTP_HOST'] . BASE_URL . "/album/shared?token=" . $album['share_token']; ?>
                <p>Lien de partage : <br><strong><a href="<?= $shareLink ?>" target="_blank"><?= $shareLink ?></a></strong></p>
                <div style="margin-top: 15px; margin-bottom: 15px;">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($shareLink) ?>" target="_blank" style="margin-right: 10px; background: #3b5998; color: white; padding: 5px 10px; border-radius: 4px;">Partager sur Facebook</a>
                    <a href="https://twitter.com/intent/tweet?url=<?= urlencode($shareLink) ?>&text=Regardez%20cet%20album%20photo!" target="_blank" style="margin-right: 10px; background: #1DA1F2; color: white; padding: 5px 10px; border-radius: 4px;">Partager sur X (Twitter)</a>
                    <a href="https://api.whatsapp.com/send?text=<?= urlencode("Regarde cet album : " . $shareLink) ?>" target="_blank" style="background: #25D366; color: white; padding: 5px 10px; border-radius: 4px;">WhatsApp</a>
                </div>
                <form action="<?= BASE_URL ?>/share/token" method="POST" style="box-shadow: none; padding: 0; max-width: 100%;">
                    <input type="hidden" name="album_id" value="<?= $album['id'] ?>">
                    <input type="hidden" name="action" value="revoke">
                    <button type="submit" style="background-color: #e74c3c;">Révoquer le lien public</button>
                </form>
            <?php else: ?>
                <p>Cet album n'a pas de lien public actif.</p>
                <form action="<?= BASE_URL ?>/share/token" method="POST" style="box-shadow: none; padding: 0; max-width: 100%;">
                    <input type="hidden" name="album_id" value="<?= $album['id'] ?>">
                    <input type="hidden" name="action" value="generate">
                    <button type="submit">Générer un lien public</button>
                </form>
            <?php endif; ?>
        </section>

        <section style="background: #fff; padding: 20px; border-radius: var(--border-radius);">
            <h2>Inviter un utilisateur (Accès Restreint)</h2>
            <form action="<?= BASE_URL ?>/share/add" method="POST" style="box-shadow: none; padding: 0; max-width: 100%;">
                <input type="hidden" name="album_id" value="<?= $album['id'] ?>">
                <input type="email" name="email" placeholder="Email de l'utilisateur" required>
                <select name="permission">
                    <option value="view">Peut consulter</option>
                    <option value="edit">Peut consulter et modifier les photos</option>
                </select>
                <button type="submit">Ajouter l'accès</button>
            </form>

            <h3 style="margin-top: 20px;">Utilisateurs autorisés</h3>
            <ul>
                <?php foreach ($authorizedUsers as $user): ?>
                    <li style="padding: 10px; flex-direction: row; justify-content: space-between; align-items: center;">
                        <span><strong><?= htmlspecialchars($user['username']) ?></strong> (<?= htmlspecialchars($user['permission']) ?>)</span>
                        <form action="<?= BASE_URL ?>/share/remove" method="POST" style="box-shadow: none; padding: 0; margin: 0; min-width: auto;">
                            <input type="hidden" name="album_id" value="<?= $album['id'] ?>">
                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                            <button type="submit" style="background-color: #e74c3c; padding: 5px 10px; font-size: 0.8rem;">Retirer</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>
</body>
</html>