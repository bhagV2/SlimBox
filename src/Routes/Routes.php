<?php

use App\Controllers\AccueilController;
use App\Controllers\AccountController;
use App\Controllers\ConnexionController;
use App\Controllers\DashboardController;
use App\Controllers\FriendsController;
use App\Controllers\InscriptionController;
use App\Controllers\MessagesController;
use Slim\App;

return function (App $app): void {
    // Déclarer ici les pages accessibles sans compte.
    $app->get('/', [AccueilController::class, 'index']);
    $app->get('/connexion', [ConnexionController::class, 'index']);
    $app->post('/connexion', [ConnexionController::class, 'login']);
    $app->post('/deconnexion', [ConnexionController::class, 'logout']);

    // Gérer le compte connecté.
    $app->get('/compte', [AccountController::class, 'index']);
    $app->post('/compte', [AccountController::class, 'update']);

    // Gérer ici les comptes administrateur.
    $app->get('/dashboard', [DashboardController::class, 'index']);
    $app->get('/dashboard/utilisateurs/{id:[0-9]+}/modifier', [DashboardController::class, 'edit']);
    $app->post('/dashboard/utilisateurs/{id:[0-9]+}/modifier', [DashboardController::class, 'update']);
    $app->post('/dashboard/utilisateurs/{id:[0-9]+}/supprimer', [DashboardController::class, 'delete']);

    // Déclarer ici les pages de messagerie.
    $app->get('/messages', [MessagesController::class, 'index']);
    $app->get('/messages/{id:[0-9]+}', [MessagesController::class, 'conversation']);
    $app->post('/messages/{id:[0-9]+}/envoyer', [MessagesController::class, 'send']);

    // Gérer ici les demandes d'amis.
    $app->get('/amis', [FriendsController::class, 'index']);
    $app->post('/amis/{id:[0-9]+}/demander', [FriendsController::class, 'request']);
    $app->post('/amis/{id:[0-9]+}/accepter', [FriendsController::class, 'accept']);
    $app->post('/amis/{id:[0-9]+}/refuser', [FriendsController::class, 'decline']);

    // Déclarer ici la création de compte.
    $app->get('/inscription', [InscriptionController::class, 'index']);
    $app->post('/inscription', [InscriptionController::class, 'store']);
};