<?php

namespace App\Controllers;

use App\Models\User;
use PDOException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class InscriptionController extends RenderController
{
    // Afficher le formulaire de création de compte.
    public function index(Request $request, Response $response): Response
    {
        return $this->render($response, 'inscription');
    }

    // Valider les données et créer un compte utilisateur.
    public function store(Request $request, Response $response): Response
    {
        $username = $this->postString('username');
        $password = $this->postString('password', false);

        if (!$this->validUsername($username) || !$this->validPassword($password)) {
            return $this->render($response, 'inscription', [
                'error' => 'Vérifiez votre nom d’utilisateur et votre mot de passe (6 caractères minimum).',
                'username' => $username,
            ]);
        }

        try {
            User::create($username, $password);
        } catch (PDOException $exception) {
            if ((string) $exception->getCode() !== '23000') {
                throw $exception;
            }

            return $this->render($response, 'inscription', [
                'error' => 'Ce nom d’utilisateur est déjà utilisé.',
                'username' => $username,
            ]);
        }

        $this->setAlert('Votre compte a été créé. Vous pouvez vous connecter.');

        return $this->redirect($response, '/connexion');
    }
}
