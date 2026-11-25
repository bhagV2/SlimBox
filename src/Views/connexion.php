<?php
$activePage = 'connexion';
$pageStyle = 'connexion';
$pageTitle = 'Connexion | ' . $appName;
?>
<?php require __DIR__ . '/includes/head.php'; ?>
<?php require __DIR__ . '/includes/header.php'; ?>

<main id="connexion">
    <form action="<?= $basePath ?>/connexion" method="post">
        <h1>Connexion à votre compte <?= htmlspecialchars($appName) ?></h1>

        <?php if (!empty($alert)): ?>
            <p><?= htmlspecialchars($alert) ?></p>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <label for="username">Nom d’utilisateur</label>
        <input type="text" name="username" id="username" value="<?= htmlspecialchars($username ?? '') ?>" maxlength="50" autocomplete="username" required>

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" autocomplete="current-password" required>

        <button type="submit">Se connecter</button>

        <p><a href="<?= $basePath ?>/inscription">Pas encore de compte ? Créez le vôtre.</a></p>
    </form>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>