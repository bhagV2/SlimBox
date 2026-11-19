<?php
require_once dirname(__DIR__, 2) . '/src/Config/env.php';
$appName = $_ENV["APP_NAME"];
?>
<header>
    <nav>
        <a href="/">Accueil</a>
        <a href="/connexion">Connexion</a>
    </nav>
</header>

<form action="" method="post">
    <h1>Connexion à votre compte <?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?></h1>
    <label for="email">Adresse e-mail</label>
    <input type="email" name="email" id="email" autocomplete="email" required>
    <label for="mdp">Mot de passe</label>
    <input type="password" name="mdp" id="mdp" autocomplete="current-password" required>
    <button type="submit">Se connecter</button>
</form>

<footer>Bhagya &copy; <?= $appName ?> 2026</footer>