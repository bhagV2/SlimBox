<link rel="stylesheet" href="/css/header.css">

<header class="header">
    <div class="header-inner">
        <a class="header-brand" href="/" aria-label="<?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?> - accueil">
            <span class="header-logo" aria-hidden="true">S</span>
            <span><?= htmlspecialchars($appName, ENT_QUOTES, 'UTF-8') ?></span>
        </a>

        <nav class="header-nav" aria-label="Navigation principale">
            <a class="links" href="/"<?= $activePage === 'accueil' ? ' aria-current="page"' : '' ?>>Accueil</a>
            <a class="links" href="/connexion"<?= $activePage === 'connexion' ? ' aria-current="page"' : '' ?>>Connexion</a>
            <a class="header-signup" href="/inscription">Créer un compte</a>
        </nav>
    </div>
</header>
