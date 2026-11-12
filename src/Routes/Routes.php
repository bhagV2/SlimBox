<?php

use Slim\App;
use App\Controllers\AccueilController;

return function (App $app) {
    $app->get('/', [AccueilController::class, 'index']);
    $app->get('/dashboard', [AccueilController::class, 'dashboard']);
    $app->get('/signin', [AccueilController::class, 'inscription']);
};