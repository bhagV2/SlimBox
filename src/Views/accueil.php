<?php
require_once dirname(__DIR__, 2) . '/src/Config/env.php';
$appName = $_ENV["APP_NAME"];
$activePage = 'accueil';
$pageTitle = 'Accueil | ' . $appName;
?>
<?php require __DIR__ . '/head.php'; ?>
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

<?php require __DIR__ . '/footer.php'; ?>