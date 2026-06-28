<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <meta charset="UTF-8">
    <title>Profil de <?= htmlspecialchars($user['username']) ?></title>
</head>
<body>
    <nav>
        <div>
            <a href="<?= BASE_URL ?>/dashboard">Tableau de bord</a>
            <a href="<?= BASE_URL ?>/profile/show">Mon Profil</a>
        </div>
    </nav>
    <main>
        <div style="background: var(--card-bg); padding: 30px; border-radius: var(--border-radius); box-shadow: var(--box-shadow); display: flex; gap: 30px; align-items: center; margin-bottom: 40px;">
            <div style="width: 120px; height: 120px; border-radius: 50%; overflow: hidden; background: #eee; display:flex; align-items:center; justify-content:center;">
                <?php if (!empty($user['profile_picture'])): ?>
                    <img src="<?= BASE_URL . $user['profile_picture'] ?>" alt="Avatar" style="width:100%; height:100%; object-fit:cover;">
                <?php else: ?>
                    <span style="font-size: 3rem; color: #ccc;">👤</span>
                <?php endif; ?>
            </div>
            <div style="flex: 1;">
                <h1 style="margin: 0 0 10px 0;"><?= htmlspecialchars($user['username']) ?></h1>
                <p style="color: var(--text-muted); margin-bottom: 15px;"><?= nl2br(htmlspecialchars($user['bio'] ?? 'Aucune biographie rédigée.')) ?></p>
                <?php if ($isOwnProfile): ?>
                    <a href="<?= BASE_URL ?>/profile/edit" class="btn">Modifier mon profil</a>
                <?php endif; ?>
            </div>
        </div>

        <h2>Albums accessibles de cet utilisateur</h2>
        <?php if (empty($albums)): ?>
            <p>Aucun album accessible pour le moment.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($albums as $album): ?>
                    <li>
                        <strong><a href="<?= BASE_URL ?>/album/show?id=<?= $album['id'] ?>"><?= htmlspecialchars($album['title']) ?></a></strong>
                        <p><?= htmlspecialchars((string)$album['description']) ?></p>
                        <small>Visibilité : <?= htmlspecialchars($album['visibility']) ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </main>
</body>
</html>