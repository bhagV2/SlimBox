<link rel="stylesheet" href="/css/header.css">

<header class="site-header">
    <div class="site-header__inner">
        <a class="site-header__brand" href="/" aria-label="<?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?> - accueil">
            <span class="site-header__logo" aria-hidden="true">S</span>
            <span><?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?></span>
        </a>

        <nav class="site-header__nav" aria-label="Navigation principale">
            <a href="/"<?= $activePage === 'accueil' ? ' aria-current="page"' : '' ?>>Accueil</a>
            <a href="/connexion"<?= $activePage === 'connexion' ? ' aria-current="page"' : '' ?>>Connexion</a>
            <a class="site-header__cta" href="/inscription">Créer un compte</a>
        </nav>
    </div>
</header>
