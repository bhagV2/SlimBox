<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AccueilController extends RenderController
{
    // Afficher l’accueil ou rediriger le compte connecté vers ses messages.
    public function index(Request $request, Response $response): Response
    {
        if ($this->currentUserId() !== null) {
            return $this->redirect($response, '/messages');
        }

        return $this->render($response, 'accueil');
    }
}