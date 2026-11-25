<header>
    <div>
        <a href="<?= htmlspecialchars(APP_BASE_PATH) ?>/">
            <img src="<?= htmlspecialchars(APP_BASE_PATH) ?>/img/logo.png" alt="" width="56" height="56">
            <span><?= htmlspecialchars(APP_NAME) ?></span>
        </a>

        <nav>
            <?php if (empty($_SESSION['user_id'])): ?>
                <a href="<?= htmlspecialchars(APP_BASE_PATH) ?>/">Accueil</a>
            <?php endif; ?>

            <?php if (!empty($_SESSION['user_id'])): ?>
                <a href="<?= htmlspecialchars(APP_BASE_PATH) ?>/compte">Mon compte</a>

                <a href="<?= htmlspecialchars(APP_BASE_PATH) ?>/amis">Amis</a>

                <a href="<?= htmlspecialchars(APP_BASE_PATH) ?>/messages">Messages</a>

                <?php if (($_SESSION['user_role'] ?? '') === 'administrateur'): ?>
                    <a href="<?= htmlspecialchars(APP_BASE_PATH) ?>/dashboard">Gestion des comptes</a>
                <?php endif; ?>

                <form action="<?= htmlspecialchars(APP_BASE_PATH) ?>/deconnexion" method="post">
                    <button type="submit">Déconnexion</button>
                </form>

            <?php else: ?>
                <a href="<?= htmlspecialchars(APP_BASE_PATH) ?>/connexion">Connexion</a>

                <a href="<?= htmlspecialchars(APP_BASE_PATH) ?>/inscription">Créer un compte</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
