<?php
require __DIR__ . '/includes/head.php';
?>
<title>Inscription | <?= htmlspecialchars(APP_NAME) ?></title>
<link rel="stylesheet" href="<?= htmlspecialchars(APP_BASE_PATH) ?>/css/pages/inscription.css">
</head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>

<main id="inscription">
    <form action="<?= htmlspecialchars(APP_BASE_PATH) ?>/inscription" method="post">
        <h1>Création de votre compte <?= htmlspecialchars(APP_NAME) ?></h1>

        <?php if (!empty($error)): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <label for="username">Nom d’utilisateur</label>
        <input type="text" name="username" id="username" value="<?= htmlspecialchars($username ?? '') ?>" maxlength="50" autocomplete="username" required>

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" minlength="6" autocomplete="new-password" required>

        <button type="submit">Créer mon compte</button>

        <p><a href="<?= htmlspecialchars(APP_BASE_PATH) ?>/connexion">Déjà inscrit ? Connectez-vous.</a></p>
    </form>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>