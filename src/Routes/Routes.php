<?php

use Slim\App;
use App\Controllers\AccueilController;

return function (App $app) {
    $app->get('/', [AccueilController::class, 'index']);
    $app->get('/connexion', [AccueilController::class, 'connexion']);
    $app->get('/dashboard', [AccueilController::class, 'dashboard']);
    $app->get('/inscription', [AccueilController::class, 'inscription']);
};