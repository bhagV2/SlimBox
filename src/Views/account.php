<?php
$pageStyle = 'account';
$pageTitle = 'Mon compte | ' . $appName;
?>
<?php require __DIR__ . '/includes/head.php'; ?>
<?php require __DIR__ . '/includes/header.php'; ?>

<main id="account">
    <form action="<?= $basePath ?>/compte" method="post">
        <h1>Mon compte</h1>

        <?php if (!empty($alert)): ?>
            <p><?= htmlspecialchars($alert) ?></p>
        <?php endif; ?>

        <label for="username">Nom d’utilisateur</label>
        <input type="text" name="username" id="username" value="<?= htmlspecialchars($user->getUsername()) ?>" maxlength="50" autocomplete="username" required>

        <label for="password">Nouveau mot de passe (facultatif)</label>
        <input type="password" name="password" id="password" minlength="6" autocomplete="new-password">
        <p>Laissez ce champ vide pour conserver le mot de passe actuel.</p>

        <button type="submit">Enregistrer</button>
    </form>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
