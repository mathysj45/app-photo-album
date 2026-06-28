<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <main style="display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 80vh;">
        <h1 style="margin-bottom: 30px;">Se connecter</h1>
        
        <form action="<?= BASE_URL ?>/login" method="POST" style="width: 100%; max-width: 400px;">
            <label for="email">Adresse email :</label>
            <input type="email" name="email" id="email" required>
            
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required>
            
            <button type="submit" style="width: 100%; margin-bottom: 20px; font-size: 1.1rem; padding: 12px;">Connexion</button>
            
            <div style="text-align: center; border-top: 1px solid var(--border-color); padding-top: 20px; margin-top: 10px;">
                <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 10px;">Vous n'avez pas encore de compte ?</p>
                <a href="<?= BASE_URL ?>/register" class="btn" style="background-color: var(--secondary-color); width: 100%; box-sizing: border-box; text-align: center; display: block;">Créer un compte</a>
            </div>
        </form>
    </main>
</body>
</html>