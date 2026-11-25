<?php
require __DIR__ . '/includes/head.php';
?>
<title>Tableau de bord | <?= htmlspecialchars(APP_NAME) ?></title>
<link rel="stylesheet" href="<?= htmlspecialchars(APP_BASE_PATH) ?>/css/pages/dashboard.css">
</head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>

<main id="dashboard">
    <h1>Gestion des comptes</h1>

    <?php if (!empty($alert)): ?>
        <p><?= htmlspecialchars($alert) ?></p>
    <?php endif; ?>

    <p><a href="<?= htmlspecialchars(APP_BASE_PATH) ?>/inscription">Créer un compte</a></p>

    <?php if (empty($users)): ?>
        <p>Aucun compte à afficher.</p>
    <?php else: ?>
        <?php $currentUserId = (int) ($_SESSION['user_id'] ?? 0); ?>

        <div>
            <table>
                <thead>
                    <tr>
                        <th>Nom d’utilisateur</th>
                        <th>Rôle</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <?php $userId = $user->getId(); ?>

                        <tr>
                            <td><?= htmlspecialchars($user->getUsername()) ?></td>
                            <td><?= $user->getRole() === 'administrateur' ? 'Administrateur' : 'Utilisateur' ?></td>
                            <td>
                                <div>
                                    <?php if ($userId !== $currentUserId): ?>
                                        <a href="<?= htmlspecialchars(APP_BASE_PATH) ?>/dashboard/utilisateurs/<?= $userId ?>/modifier">Modifier</a>
                                        <form action="<?= htmlspecialchars(APP_BASE_PATH) ?>/dashboard/utilisateurs/<?= $userId ?>/supprimer" method="post">
                                            <button type="submit">Supprimer</button>
                                        </form>
                                    <?php else: ?>
                                        <span>Modifiable depuis <a href="<?= htmlspecialchars(APP_BASE_PATH) ?>/compte">Mon compte</a></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>