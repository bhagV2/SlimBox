<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AccueilController extends RenderController
{
    public function index(Request $request, Response $response): Response
    {
        $page = "accueil";
        return $this->render($response, $page, ['connexion']);
    }

    public function signin(Request $request, Response $response): Response
    {
        $titrePage = 'Sign In';

        ob_start();
        include dirname(__DIR__, 2) . '/src/Views/signin.php';
        $response->getBody()->write(ob_get_clean());

        return $response;
    }

    public function dashboard(Request $request, Response $response): Response
    {
        $titrePage = 'Page Home';

        ob_start();
        include dirname(__DIR__, 2) . '/src/Views/dashboard.php';
        $response->getBody()->write(ob_get_clean());

        return $response;
    }
}