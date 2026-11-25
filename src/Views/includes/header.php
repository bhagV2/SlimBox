<header>
    <div>
        <a href="<?= $basePath ?>/">
            <img src="<?= $basePath ?>/img/logo.png" alt="" width="56" height="56">
            <span><?= htmlspecialchars($appName) ?></span>
        </a>

        <nav>
            <?php if (empty($_SESSION['user_id'])): ?>
                <a href="<?= $basePath ?>/">Accueil</a>
            <?php endif; ?>

            <?php if (!empty($_SESSION['user_id'])): ?>
                <a href="<?= $basePath ?>/compte">Mon compte</a>

                <a href="<?= $basePath ?>/amis">Amis</a>

                <a href="<?= $basePath ?>/messages">Messages</a>

                <?php if (($_SESSION['user_role'] ?? '') === 'administrateur'): ?>
                    <a href="<?= $basePath ?>/dashboard">Gestion des comptes</a>
                <?php endif; ?>

                <form action="<?= $basePath ?>/deconnexion" method="post">
                    <button type="submit">Déconnexion</button>
                </form>

            <?php else: ?>
                <a href="<?= $basePath ?>/connexion">Connexion</a>

                <a href="<?= $basePath ?>/inscription">Créer un compte</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
