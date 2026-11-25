<?php
require __DIR__ . '/includes/head.php';
?>
<title>Mon compte | <?= htmlspecialchars(APP_NAME) ?></title>
<link rel="stylesheet" href="<?= htmlspecialchars(APP_BASE_PATH) ?>/css/pages/account.css">
</head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>

<main id="account">
    <form action="<?= htmlspecialchars(APP_BASE_PATH) ?>/compte" method="post">
        <h1>Mon compte</h1>

        <?php if (!empty($alert)): ?>
            <p><?= htmlspecialchars($alert) ?></p>
        <?php endif; ?>

        <label for="username">Nom d’utilisateur</label>
        <input type="text" name="username" id="username" value="<?= htmlspecialchars($username ?? '') ?>" maxlength="50" autocomplete="username" required>

        <label for="password">Nouveau mot de passe (facultatif)</label>
        <input type="password" name="password" id="password" minlength="6" autocomplete="new-password">
        <p>Laissez ce champ vide pour conserver le mot de passe actuel.</p>

        <button type="submit">Enregistrer</button>
    </form>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
