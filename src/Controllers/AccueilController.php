<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AccueilController extends RenderController
{
    public function index(Request $request, Response $response): Response
    {
        return $this->render($response, 'accueil');
    }

    public function connexion(Request $request, Response $response): Response
    {
        return $this->render($response, 'connexion');
    }

    public function inscription(Request $request, Response $response): Response
    {
        return $this->render($response, 'inscription');
    }

    public function dashboard(Request $request, Response $response): Response
    {
        return $this->render($response, 'dashboard');
    }
}