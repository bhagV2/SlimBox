<?php

use Slim\App;
use App\Controllers\AccueilController;
use App\Controllers\ConnexionController;
use App\Controllers\DashboardController;
use App\Controllers\InscriptionController;

return function (App $app) {
    $app->get('/', [AccueilController::class, 'index']);
    $app->get('/connexion', [ConnexionController::class, 'index']);
    $app->get('/dashboard', [DashboardController::class, 'index']);
    $app->get('/inscription', [InscriptionController::class, 'index']);
};