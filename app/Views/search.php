<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <meta charset="UTF-8">
    <title>Recherche de Photos</title>
</head>
<body>
    <nav>
        <a href="<?= BASE_URL ?>/dashboard">Retour au tableau de bord</a>
    </nav>
    <main>
        <h1>Rechercher des photos</h1>

        <form action="<?= BASE_URL ?>/search" method="GET" style="max-width: 100%; display: flex; flex-wrap: wrap; gap: 15px; align-items: flex-end;">
            <div style="flex: 2; min-width: 200px;">
                <label for="q">Mot-clé (Description, Album...) :</label>
                <input type="text" name="q" id="q" value="<?= htmlspecialchars($query) ?>" style="margin-bottom: 0;">
            </div>
            <div style="flex: 1; min-width: 150px;">
                <label for="tag">Étiquette (Tag) :</label>
                <input type="text" name="tag" id="tag" value="<?= htmlspecialchars($tagFilter) ?>" style="margin-bottom: 0;" placeholder="Ex: Vacances">
            </div>
            <div style="flex: 1; min-width: 150px;">
                <label for="date">Date de prise :</label>
                <input type="date" name="date" id="date" value="<?= htmlspecialchars($dateFilter) ?>" style="margin-bottom: 0;">
            </div>
            <button type="submit" class="btn" style="height: 44px;">Filtrer</button>
        </form>

        <h2 style="margin-top: 40px;">Résultats de recherche</h2>
        <?php if (empty($photos)): ?>
            <p style="color: var(--text-muted);">Aucune photo ne correspond à ces critères. Lancez une recherche pour voir des résultats.</p>
        <?php else: ?>
            <div class="photo-grid">
                <?php foreach ($photos as $photo): ?>
                    <div class="photo-card">
                        <img src="<?= BASE_URL ?><?= htmlspecialchars($photo['file_path']) ?>" alt="Photo" class="photo-trigger">
                        <p style="flex-grow: 1; margin-bottom: 10px; font-weight: 500;"><?= nl2br(htmlspecialchars($photo['description'])) ?></p>
                        <small style="color: var(--text-muted); display:block;">Album : <strong><?= htmlspecialchars($photo['album_title']) ?></strong></small>
                        <?php if(!empty($photo['capture_date'])): ?>
                            <small style="color: var(--text-muted); display:block;">Prise le : <?= htmlspecialchars(date('d/m/Y', strtotime($photo['capture_date']))) ?></small>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
    <script src="<?= BASE_URL ?>/js/app.js"></script>
</body>
</html>