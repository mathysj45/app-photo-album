<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album : <?= htmlspecialchars($album['title']) ?></title>
</head>
<body>
    <main>
        <h1><?= htmlspecialchars($album['title']) ?></h1>
        <p><?= nl2br(htmlspecialchars((string)$album['description'])) ?></p>

        <?php if (!empty($photos)): ?>
            <?php foreach ($photos as $photo): ?>
                <div style="border: 1px solid var(--border-color); padding: 15px; margin-bottom: 20px; border-radius: var(--border-radius); background: #fff;">
                    <img src="<?= BASE_URL ?><?= htmlspecialchars($photo['file_path']) ?>" alt="Photo" style="max-width: 100%; display: block; border-radius: var(--border-radius); margin-bottom: 10px;">
                    <p><?= nl2br(htmlspecialchars((string)$photo['description'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Cet album ne contient aucune photo pour le moment.</p>
        <?php endif; ?>
    </main>
</body>
</html>