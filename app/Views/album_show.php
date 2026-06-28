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
            <div style="margin-bottom: 30px;">
                <a href="<?= BASE_URL ?>/album/edit?id=<?= $album['id'] ?>" class="btn" style="margin-right: 15px;">Éditer l'album</a>
                <a href="<?= BASE_URL ?>/share/manage?id=<?= $album['id'] ?>" class="btn" style="background-color: var(--success-color); margin-right: 15px;">Gérer les partages</a>
                <form action="<?= BASE_URL ?>/album/delete" method="POST" style="display:inline; padding: 0; box-shadow: none; background: transparent;" onsubmit="return confirm('Action irréversible. Confirmer la suppression ?');">
                    <input type="hidden" name="id" value="<?= $album['id'] ?>">
                    <button type="submit" style="background-color: var(--danger-color);">Supprimer l'album</button>
                </form>
            </div>
        <?php endif; ?>

        <?php if (!empty($photos)): ?>
            <div class="photo-grid">
                <?php foreach ($photos as $photo): ?>
                    <div class="photo-card">
                        <img src="<?= BASE_URL ?><?= htmlspecialchars($photo['file_path']) ?>" alt="Photo" class="photo-trigger">
                        
                        <p style="flex-grow: 1; margin-bottom: 15px; font-weight: 500;"><?= nl2br(htmlspecialchars((string)$photo['description'])) ?></p>
                        
                        <?php if (!empty($photo['capture_date'])): ?>
                            <small style="color:#7f8c8d;">Prise le : <?= htmlspecialchars(date('d/m/Y', strtotime($photo['capture_date']))) ?></small>
                        <?php endif; ?>
                        
                        <?php if (!empty($photo['location'])): ?>
                            <small style="color:#7f8c8d; margin-bottom: 10px;">Lieu : <?= htmlspecialchars($photo['location']) ?></small>
                        <?php endif; ?>

                        <div style="margin-top: 15px; padding-bottom: 15px; border-bottom: 1px solid var(--border-color); display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">
                            <form action="<?= BASE_URL ?>/favorite/toggle" method="POST" style="box-shadow:none; padding:0; margin:0; background: transparent;">
                                <input type="hidden" name="photo_id" value="<?= $photo['id'] ?>">
                                <input type="hidden" name="album_id" value="<?= $album_id ?>">
                                <button type="submit" style="padding:6px 10px; font-size:0.85rem; background:var(--warning-color); color:#333;">★ Favoris</button>
                            </form>

                            <?php if (isset($album['user_id']) && $album['user_id'] === $_SESSION['user_id']): ?>
                                <a href="<?= BASE_URL ?>/photo/edit?id=<?= $photo['id'] ?>" style="font-size: 0.9rem;">Éditer</a>
                                <form action="<?= BASE_URL ?>/photo/delete" method="POST" style="box-shadow:none; padding:0; margin:0; background: transparent;" onsubmit="return confirm('Supprimer définitivement cette photo ?');">
                                    <input type="hidden" name="id" value="<?= $photo['id'] ?>">
                                    <input type="hidden" name="album_id" value="<?= $album_id ?>">
                                    <button type="submit" style="padding:6px 10px; font-size:0.85rem; background-color: var(--danger-color);">Supprimer</button>
                                </form>
                            <?php endif; ?>
                        </div>

                        <h3 style="margin-top: 15px; font-size: 1.1rem;">Commentaires</h3>
                        <?php if (!empty($photo['comments'])): ?>
                            <ul style="display: block; padding-left: 0; margin-top: 10px;">
                                <?php foreach ($photo['comments'] as $comment): ?>
                                    <li style="margin-bottom: 10px; padding: 10px; background: var(--bg-color); border-radius: var(--border-radius); display: flex; justify-content: space-between; align-items: flex-start; box-shadow: none; border: none;">
                                        <div style="font-size: 0.9rem;">
                                            <strong style="color: var(--primary-color); display: block; margin-bottom: 2px;"><?= htmlspecialchars($comment['username']) ?></strong> 
                                            <?= nl2br(htmlspecialchars($comment['content'])) ?>
                                        </div>
                                        <?php if ($comment['user_id'] === $_SESSION['user_id']): ?>
                                            <form action="<?= BASE_URL ?>/comment/delete" method="POST" style="box-shadow:none; padding:0; margin:0; background: transparent;" onsubmit="return confirm('Supprimer ce commentaire ?');">
                                                <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                                                <input type="hidden" name="album_id" value="<?= $album_id ?>">
                                                <button type="submit" style="padding: 4px 8px; font-size: 0.8rem; background-color: var(--danger-color);">X</button>
                                            </form>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p style="font-size: 0.9rem; color: #95a5a6; margin-top: 10px;">Aucun commentaire.</p>
                        <?php endif; ?>
                        
                        <form action="<?= BASE_URL ?>/comment/create" method="POST" style="margin-top: 15px; box-shadow: none; padding: 0; background: transparent; max-width: 100%;">
                            <input type="hidden" name="photo_id" value="<?= $photo['id'] ?>">
                            <input type="hidden" name="album_id" value="<?= $album_id ?>">
                            <input type="text" name="content" placeholder="Ajouter un commentaire..." required style="margin-bottom: 10px; padding: 8px;">
                            <button type="submit" style="padding: 8px 15px;">Envoyer</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (isset($totalPages) && $totalPages > 1): ?>
                <div class="pagination">
                    <?php if ($currentPage > 1): ?>
                        <a href="<?= BASE_URL ?>/album/show?id=<?= $album_id ?>&page=<?= $currentPage - 1 ?>">&laquo; Précédent</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <?php if ($i === $currentPage): ?>
                            <span class="active"><?= $i ?></span>
                        <?php else: ?>
                            <a href="<?= BASE_URL ?>/album/show?id=<?= $album_id ?>&page=<?= $i ?>"><?= $i ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <a href="<?= BASE_URL ?>/album/show?id=<?= $album_id ?>&page=<?= $currentPage + 1 ?>">Suivant &raquo;</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
        <?php else: ?>
            <p>Cet album ne contient aucune photo pour le moment.</p>
        <?php endif; ?>
    </main>

    <script src="<?= BASE_URL ?>/js/app.js"></script>
</body>
</html>