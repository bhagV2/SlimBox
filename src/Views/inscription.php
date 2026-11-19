<?php
require_once dirname(__DIR__, 2) . '/src/Config/env.php';
$appName = $_ENV["APP_NAME"];
$activePage = 'inscription';
?>
<?php require __DIR__ . '/header.php'; ?>

<form action="" method="post">
    <h1>Création de votre compte <?= htmlspecialchars($appName) ?></h1>
    <label for="email">Adresse e-mail</label>
    <input type="email" name="email" id="email" autocomplete="email" required>
    <label for="mdp">Mot de passe</label>
    <input type="password" name="mdp" id="mdp" autocomplete="current-password" required>
    <button type="submit">Se connecter</button>
    <p><a href="/inscription">Pas encore de compte? Créez le votre.</a></p>
</form>

<footer>Bhagya &copy; <?= $appName ?> 2026</footer>