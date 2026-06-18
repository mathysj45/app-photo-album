<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une photo</title>
</head>
<body>
    <h1>Ajouter une photo à l'album</h1>
    <form action="/photo/upload?album_id=<?= htmlspecialchars((string)$album_id) ?>" method="POST" enctype="multipart/form-data">
        <input type="file" name="photo" accept="image/jpeg, image/png, image/gif" required>
        <textarea name="description" placeholder="Description de la photo"></textarea>
        <button type="submit">Uploader</button>
    </form>
</body>
</html>