<?php
require_once dirname(__DIR__, 2) . '/src/Config/env.php';
$appName = $_ENV["APP_NAME"];
$activePage = 'accueil';
?>
<?php require __DIR__ . '/header.php'; ?>

<main>
    <h1>Bienvenue sur <?= htmlspecialchars($appName) ?></h1>
    <h2>La messagerie qui vous rapproche</h2>
    <p>
        <?= htmlspecialchars($appName) ?> est une messagerie en ligne
        simple et pratique pour échanger avec vos proches.
    </p>
    <p><a href="/connexion">Connectez-vous à votre compte</a></p>
</main>

<footer>Bhagya &copy; <?= $appName ?> 2026</footer>