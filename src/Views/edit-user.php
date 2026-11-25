<?php
require __DIR__ . '/includes/head.php';
?>
<title>Modifier un compte | <?= htmlspecialchars(APP_NAME) ?></title>
<link rel="stylesheet" href="<?= htmlspecialchars(APP_BASE_PATH) ?>/css/pages/edit-user.css">
</head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>

<main id="edit-user">
    <?php if (!empty($alert)): ?>
        <p><?= htmlspecialchars($alert) ?></p>
    <?php endif; ?>
    <?php if (isset($user)): ?>
        <h1>Modifier le compte de <?= htmlspecialchars($user->getUsername()) ?></h1>
        <form action="<?= htmlspecialchars(APP_BASE_PATH) ?>/dashboard/utilisateurs/<?= $user->getId() ?>/modifier" method="post">
            <label for="username">Nom d’utilisateur</label>
            <input type="text" name="username" id="username" value="<?= htmlspecialchars($user->getUsername()) ?>" maxlength="50" required>

            <label for="password">Nouveau mot de passe (facultatif)</label>
            <input type="password" name="password" id="password" minlength="6" autocomplete="new-password">

            <button type="submit">Enregistrer</button>

            <p><a href="<?= htmlspecialchars(APP_BASE_PATH) ?>/dashboard">Retour à la liste des comptes</a></p>
        </form>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
