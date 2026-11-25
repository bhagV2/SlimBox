<?php
require __DIR__ . '/includes/head.php';
?>
<title>Amis | <?= htmlspecialchars(APP_NAME) ?></title>
<link rel="stylesheet" href="<?= htmlspecialchars(APP_BASE_PATH) ?>/css/pages/friends.css">
</head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>

<main id="amis">
    <h1>Amis</h1>

    <?php if (!empty($alert)): ?>
        <p><?= htmlspecialchars($alert) ?></p>
    <?php endif; ?>

    <div>
        <section>
            <h2>Demandes reçues</h2>

            <?php if (empty($incomingRequests)): ?>
                <p>Aucune demande en attente.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($incomingRequests as $friend): ?>
                        <li>
                            <span><?= htmlspecialchars($friend['nom_utilisateur']) ?></span>

                            <div>
                                <form action="<?= htmlspecialchars(APP_BASE_PATH) ?>/amis/<?= (int) $friend['id'] ?>/accepter" method="post">
                                    <button type="submit">Accepter</button>
                                </form>

                                <form action="<?= htmlspecialchars(APP_BASE_PATH) ?>/amis/<?= (int) $friend['id'] ?>/refuser" method="post">
                                    <button type="submit">Refuser</button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <section>
            <h2>Mes amis</h2>

            <?php if (empty($friends)): ?>
                <p>Vous n’avez pas encore d’amis.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($friends as $friend): ?>
                        <li>
                            <a href="<?= htmlspecialchars(APP_BASE_PATH) ?>/messages/<?= (int) $friend['id'] ?>">
                                <?= htmlspecialchars($friend['nom_utilisateur']) ?>
                            </a>

                            <a href="<?= htmlspecialchars(APP_BASE_PATH) ?>/messages/<?= (int) $friend['id'] ?>">Écrire</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <section>
            <h2>Demandes envoyées</h2>

            <?php if (empty($outgoingRequests)): ?>
                <p>Aucune demande envoyée en attente.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($outgoingRequests as $friend): ?>
                        <li>
                            <span><?= htmlspecialchars($friend['nom_utilisateur']) ?></span>
                            <span>En attente</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <section>
            <h2>Ajouter un ami</h2>

            <?php if (empty($availableUsers)): ?>
                <p>Aucun utilisateur disponible.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($availableUsers as $friend): ?>
                        <li>
                            <span><?= htmlspecialchars($friend['nom_utilisateur']) ?></span>

                            <form action="<?= htmlspecialchars(APP_BASE_PATH) ?>/amis/<?= (int) $friend['id'] ?>/demander" method="post">
                                <button type="submit">Ajouter</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
