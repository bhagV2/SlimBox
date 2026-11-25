<?php
require_once dirname(__DIR__, 2) . '/src/Config/env.php';
$appName = $_ENV["APP_NAME"];
$activePage = 'dashboard';
$pageTitle = 'Tableau de bord | ' . $appName;
?>
<?php require __DIR__ . '/head.php'; ?>
<?php require __DIR__ . '/header.php'; ?>

<main></main>

<?php require __DIR__ . '/footer.php'; ?>