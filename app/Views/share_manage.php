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

        <section style="background: var(--card-bg); padding: 25px; border-radius: var(--border-radius); box-shadow: var(--box-shadow); margin-bottom: 30px;">
            <h2 style="margin-top: 0;">Lien public</h2>
            
            <?php if (!empty($album['share_token'])): ?>
                <?php $shareLink = "http://" . $_SERVER['HTTP_HOST'] . BASE_URL . "/album/shared?token=" . $album['share_token']; ?>
                
                <p style="margin-bottom: 20px; padding: 15px; background: var(--bg-color); border: 1px solid var(--border-color); border-radius: var(--border-radius); word-break: break-all;">
                    Lien de partage : <br><strong><a href="<?= $shareLink ?>" target="_blank"><?= $shareLink ?></a></strong>
                </p>
                
                <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; align-items: stretch;">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($shareLink) ?>" target="_blank" class="btn" style="background-color: #3b5998; display: flex; align-items: center;">Facebook</a>
                    <a href="https://twitter.com/intent/tweet?url=<?= urlencode($shareLink) ?>&text=Regardez%20cet%20album%20photo!" target="_blank" class="btn" style="background-color: #1DA1F2; display: flex; align-items: center;">X (Twitter)</a>
                    <a href="https://api.whatsapp.com/send?text=<?= urlencode("Regarde cet album : " . $shareLink) ?>" target="_blank" class="btn" style="background-color: #25D366; display: flex; align-items: center;">WhatsApp</a>
                </div>
                
                <form action="<?= BASE_URL ?>/share/token" method="POST" style="margin: 0; padding: 0; box-shadow: none; background: transparent; max-width: 100%;">
                    <input type="hidden" name="album_id" value="<?= $album['id'] ?>">
                    <input type="hidden" name="action" value="revoke">
                    <button type="submit" class="btn" style="background-color: var(--danger-color);">Révoquer le lien public</button>
                </form>
                
            <?php else: ?>
                <p style="margin-bottom: 20px; color: var(--text-muted);">Cet album n'a pas de lien public actif.</p>
                <form action="<?= BASE_URL ?>/share/token" method="POST" style="margin: 0; padding: 0; box-shadow: none; background: transparent; max-width: 100%;">
                    <input type="hidden" name="album_id" value="<?= $album['id'] ?>">
                    <input type="hidden" name="action" value="generate">
                    <button type="submit" class="btn">Générer un lien public</button>
                </form>
            <?php endif; ?>
        </section>

        <section style="background: var(--card-bg); padding: 25px; border-radius: var(--border-radius); box-shadow: var(--box-shadow);">
            <h2 style="margin-top: 0;">Inviter un utilisateur (Accès Restreint)</h2>
            
            <form action="<?= BASE_URL ?>/share/add" method="POST" style="margin: 0 0 30px 0; padding: 0; box-shadow: none; background: transparent; max-width: 100%; display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end;">
                <input type="hidden" name="album_id" value="<?= $album['id'] ?>">
                
                <div style="flex: 1; min-width: 250px;">
                    <label for="email" style="margin-bottom: 5px; display: block;">Email de l'utilisateur</label>
                    <input type="email" name="email" id="email" placeholder="Ex: jean@mail.com" required style="margin-bottom: 0;">
                </div>
                
                <div style="flex: 1; min-width: 250px;">
                    <label for="permission" style="margin-bottom: 5px; display: block;">Niveau d'accès</label>
                    <select name="permission" id="permission" style="margin-bottom: 0;">
                        <option value="view">Peut consulter</option>
                        <option value="edit">Peut consulter et modifier</option>
                    </select>
                </div>
                
                <button type="submit" class="btn" style="height: 44px; margin-bottom: 0;">Ajouter l'accès</button>
            </form>

            <h3 style="border-bottom: 1px solid var(--border-color); padding-bottom: 10px; margin-bottom: 15px;">Utilisateurs autorisés</h3>
            
            <?php if (empty($authorizedUsers)): ?>
                <p style="color: var(--text-muted);">Aucun utilisateur n'a accès à cet album.</p>
            <?php else: ?>
                <ul style="display: flex; flex-direction: column; gap: 10px; margin: 0; padding: 0;">
                    <?php foreach ($authorizedUsers as $user): ?>
                        <li style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: var(--bg-color); border: 1px solid var(--border-color); border-radius: var(--border-radius); box-shadow: none; flex-direction: row; margin: 0;">
                            <div>
                                <strong style="color: var(--primary-color); display: block; font-size: 1.1rem;"><?= htmlspecialchars($user['username']) ?></strong>
                                <span style="color: var(--text-muted); font-size: 0.9rem;">
                                    <?= htmlspecialchars($user['permission']) === 'edit' ? 'Lecture et Écriture' : 'Lecture seule' ?>
                                </span>
                            </div>
                            <form action="<?= BASE_URL ?>/share/remove" method="POST" style="margin: 0; padding: 0; box-shadow: none; background: transparent; min-width: auto;">
                                <input type="hidden" name="album_id" value="<?= $album['id'] ?>">
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                <button type="submit" class="btn" style="background-color: var(--danger-color); margin: 0;">Retirer</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>