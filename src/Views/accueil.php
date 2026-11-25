<?php
require __DIR__ . '/includes/head.php';
?>
<title>Accueil | <?= htmlspecialchars(APP_NAME) ?></title>
<link rel="stylesheet" href="<?= htmlspecialchars(APP_BASE_PATH) ?>/css/pages/accueil.css">
</head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>

<main id="accueil">
    <h1>Bienvenue sur <?= htmlspecialchars(APP_NAME) ?></h1>
    <h2>La messagerie qui vous rapproche</h2>
    <p>
        <?= htmlspecialchars(APP_NAME) ?> est une messagerie en ligne
        simple et pratique pour échanger avec vos proches.
    </p>
    <p><a href="<?= htmlspecialchars(APP_BASE_PATH) ?>/connexion">Connectez-vous à votre compte</a></p>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>