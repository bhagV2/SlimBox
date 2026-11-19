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

<main>
    <h1>Bienvenue sur <?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?></h1>
    <h2>La messagerie qui vous rapproche</h2>
    <p>
        <?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?> est une messagerie en ligne
        simple et pratique pour échanger avec vos proches.
    </p>
    <p><a href="/connexion">Connectez-vous à votre compte</a></p>
    <p><a href="/inscription">incrivez-vous</a></p>
    <p><a href="/dashboard">dashboard</a></p>
</main>

<footer>Bhagya &copy; <?= $appName ?> 2026</footer>