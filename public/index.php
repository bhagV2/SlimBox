<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/Config/env.php';

session_start();

// Choisir le chemin indiqué dans .env ou le déduire du dossier de l'application.
$basePath = trim($_ENV['APP_BASE_PATH'] ?? dirname($_SERVER['SCRIPT_NAME'] ?? '/'), '/');
define('APP_BASE_PATH', $basePath === '' ? '' : '/' . $basePath);

$app = AppFactory::create();
$app->setBasePath(APP_BASE_PATH);
$app->addBodyParsingMiddleware();
// Afficher les erreurs détaillées pendant le développement.
$app->addErrorMiddleware(true, true, true);

$routes = require __DIR__ . '/../src/Routes/Routes.php';
$routes($app);

$app->run();