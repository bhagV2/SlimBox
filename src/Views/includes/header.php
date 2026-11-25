<header>
    <div>
        <a href="<?= $basePath ?>/" aria-label="<?= htmlspecialchars($appName) ?> - accueil">
            <img src="<?= $basePath ?>/img/logo.png" alt="" width="56" height="56">
            <span><?= htmlspecialchars($appName) ?></span>
        </a>

        <nav aria-label="Navigation principale">
            <?php if (empty($_SESSION['user_id'])): ?>
                <a href="<?= $basePath ?>/" <?= $activePage === 'accueil' ? 'aria-current="page"' : '' ?>>Accueil</a>
            <?php endif; ?>

            <?php if (!empty($_SESSION['user_id'])): ?>
                <a href="<?= $basePath ?>/amis" <?= $activePage === 'friends' ? 'aria-current="page"' : '' ?>>Amis</a>

                <a href="<?= $basePath ?>/messages" <?= $activePage === 'messages' ? 'aria-current="page"' : '' ?>>Messages</a>

                <?php if (($_SESSION['user_role'] ?? '') === 'administrateur'): ?>
                    <a href="<?= $basePath ?>/dashboard" <?= $activePage === 'dashboard' ? 'aria-current="page"' : '' ?>>Gestion des comptes</a>
                <?php endif; ?>

                <form action="<?= $basePath ?>/deconnexion" method="post">
                    <button type="submit">Déconnexion</button>
                </form>

            <?php else: ?>
                <a href="<?= $basePath ?>/connexion" <?= $activePage === 'connexion' ? 'aria-current="page"' : '' ?>>Connexion</a>

                <a href="<?= $basePath ?>/inscription">Créer un compte</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
