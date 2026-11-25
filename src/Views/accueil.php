<?php
$activePage = 'accueil';
$pageStyle = 'accueil';
$pageTitle = 'Accueil | ' . $appName;
?>
<?php require __DIR__ . '/includes/head.php'; ?>
<?php require __DIR__ . '/includes/header.php'; ?>

<main id="accueil">
    <h1>Bienvenue sur <?= htmlspecialchars($appName) ?></h1>
    <h2>La messagerie qui vous rapproche</h2>
    <p>
        <?= htmlspecialchars($appName) ?> est une messagerie en ligne
        simple et pratique pour échanger avec vos proches.
    </p>
    <p><a href="<?= $basePath ?>/connexion">Connectez-vous à votre compte</a></p>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>