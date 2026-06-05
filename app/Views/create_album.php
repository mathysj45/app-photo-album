<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un album</title>
</head>
<body>
    <h1>Créer un nouvel album</h1>
    <form action="/album/create" method="POST">
        <input type="text" name="title" placeholder="Titre de l'album" required>
        <textarea name="description" placeholder="Description"></textarea>
        <input type="text" name="tags" placeholder="Étiquettes (séparées par des virgules)">
        <select name="visibility">
            <option value="private">Privé</option>
            <option value="public">Public</option>
            <option value="restricted">Restreint</option>
        </select>
        <button type="submit">Créer</button>
    </form>
</body>
</html>