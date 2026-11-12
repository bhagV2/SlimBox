<?php
require_once dirname(__DIR__, 2) . '/src/Config/env.php';
$appName = $_ENV["APP_NAME"];
?>
<form action="" method="post">
    <h1><?= $data[0] ?></h1>
    <label for="">mail</label>
    <input type="email" name="email" id="email">
    <label for="mdp">mot de passe</label>
    <input type="password" name="mdp" id="mdp">
    <button type="submit">Confirmer</button>
</form>

<footer>Bhagya &copy; <?= $appName ?> 2026</footer>