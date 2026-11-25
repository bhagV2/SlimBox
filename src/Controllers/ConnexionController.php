<?php

namespace App\Controllers;

use App\Models\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ConnexionController extends RenderController
{
    // Afficher la page de connexion et une éventuelle alerte.
    public function index(Request $request, Response $response): Response
    {
        return $this->render($response, 'connexion', [
            'alert' => $this->takeAlert(),
        ]);
    }

    // Vérifier les identifiants et ouvrir la session utilisateur.
    public function login(Request $request, Response $response): Response
    {
        $username = $this->postString('username');
        $password = $this->postString('password', false);
        $user = User::findByUsername($username);

        if ($user === null || !$user->verifyPassword($password)) {
            return $this->render($response, 'connexion', [
                'error' => 'Nom d’utilisateur ou mot de passe incorrect.',
                'username' => $username,
            ]);
        }

        $role = $user->getRole();
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['user_role'] = $role;

        if ($role === 'administrateur') {
            return $this->redirect($response, '/dashboard');
        }

        return $this->redirect($response, '/');
    }

    // Fermer la session et rediriger vers la connexion.
    public function logout(Request $request, Response $response): Response
    {
        $_SESSION = [];
        session_regenerate_id(true);
        $this->setAlert('Vous êtes déconnecté.');

        return $this->redirect($response, '/connexion');
    }
}
