<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <meta charset="UTF-8">
    <title>Modifier mon profil</title>
</head>
<body>
    <nav>
        <a href="<?= BASE_URL ?>/profile/show">Retour au profil</a>
    </nav>
    <main style="display: flex; flex-direction: column; align-items: center;">
        <h1>Modifier mes informations</h1>
        <form action="<?= BASE_URL ?>/profile/edit" method="POST" enctype="multipart/form-data" style="width:100%; max-width:500px;">
            <label for="profile_pic">Photo de profil (Avatar) :</label>
            <input type="file" name="profile_pic" id="profile_pic" accept="image/*">

            <label for="bio">Biographie :</label>
            <textarea name="bio" id="bio" rows="5" style="width:100%; height:auto;"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>

            <button type="submit" class="btn" style="width:100%; margin-top:10px;">Enregistrer les modifications</button>
        </form>
    </main>
</body>
</html>