<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter des photos</title>
</head>
<body>
    <nav>
        <a href="<?= BASE_URL ?>/album/show?id=<?= $album_id ?>">Retour à l'album</a>
    </nav>
    <main style="display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 80vh;">
        <h1 style="margin-bottom: 30px;">Ajouter des photos</h1>
        
        <form action="<?= BASE_URL ?>/photo/upload?album_id=<?= $album_id ?>" method="POST" enctype="multipart/form-data" style="width: 100%; max-width: 500px;">
            <label for="photos">Sélectionnez une ou plusieurs images :</label>
            <input type="file" name="photos[]" id="photos" multiple accept="image/jpeg, image/png, image/gif" required>
            
            <label for="capture_date">Date de prise de vue (appliquée à toutes) :</label>
            <input type="date" name="capture_date" id="capture_date">

            <label for="location">Lieu (appliqué à toutes) :</label>
            <input type="text" name="location" id="location" placeholder="Ex: Paris, France...">

            <label for="description">Description (appliquée à toutes) :</label>
            <textarea name="description" id="description" placeholder="Optionnel..."></textarea>
            
            <button type="submit" class="btn" style="width: 100%; font-size: 1.1rem; padding: 12px;">Importer les photos</button>
        </form>
    </main>
</body>
</html>