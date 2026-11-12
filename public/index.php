<?php

use App\Services\Database;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/Config/env.php';

$pdo = Database::getConnection();

$app = AppFactory::create();
$app->addBodyParsingMiddleware();
$app->addErrorMiddleware(true, true, true);

$routes = require __DIR__ . '/../src/Routes/Routes.php';
$routes($app);

$app->run();