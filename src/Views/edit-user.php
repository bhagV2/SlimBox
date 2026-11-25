<?php
$pageStyle = 'edit-user';
$pageTitle = 'Modifier un compte | ' . $appName;
?>
<?php require __DIR__ . '/includes/head.php'; ?>
<?php require __DIR__ . '/includes/header.php'; ?>

<main id="edit-user">
    <h1>Modifier le compte de <?= htmlspecialchars($user->getUsername()) ?></h1>
    <?php if (!empty($alert)): ?>
        <p><?= htmlspecialchars($alert) ?></p>
    <?php endif; ?>
    <form action="<?= $basePath ?>/dashboard/utilisateurs/<?= $user->getId() ?>/modifier" method="post">
        <label for="username">Nom d’utilisateur</label>
        <input type="text" name="username" id="username" value="<?= htmlspecialchars($user->getUsername()) ?>" maxlength="50" required>

        <label for="password">Nouveau mot de passe (facultatif)</label>
        <input type="password" name="password" id="password" minlength="6" autocomplete="new-password">

        <button type="submit">Enregistrer</button>

        <p><a href="<?= $basePath ?>/dashboard">Retour à la liste des comptes</a></p>
    </form>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
