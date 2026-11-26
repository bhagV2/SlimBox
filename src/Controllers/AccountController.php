<?php

namespace App\Controllers;

use App\Models\User;
use PDOException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AccountController extends RenderController
{
    // Afficher les paramètres du compte connecté.
    public function index(Request $request, Response $response): Response
    {
        $user = $this->currentAccount();

        if ($user === null) {
            return $this->redirect($response, '/connexion');
        }

        return $this->render($response, 'account', [
            'username' => $user->getUsername(),
            'alert' => $this->takeAlert(),
        ]);
    }

    // Enregistrer le nom et le nouveau mot de passe facultatif.
    public function update(Request $request, Response $response): Response
    {
        $user = $this->currentAccount();

        if ($user === null) {
            return $this->redirect($response, '/connexion');
        }

        $username = $this->postString('username');
        $password = $this->postString('password', false);

        if (!$this->validUsername($username) || ($password !== '' && !$this->validPassword($password))) {
            $this->setAlert('Vérifiez le nom d’utilisateur et le nouveau mot de passe (6 caractères minimum).');

            return $this->redirect($response, '/compte');
        }

        try {
            $user->update($username, $password === '' ? null : $password);
        } catch (PDOException $exception) {
            if ((string) $exception->getCode() !== '23000') {
                throw $exception;
            }

            $this->setAlert('Ce nom d’utilisateur est déjà utilisé.');

            return $this->redirect($response, '/compte');
        }

        $this->setAlert('Votre compte a été modifié.');

        return $this->redirect($response, '/compte');
    }

    // Récupérer le compte connecté et invalider une session obsolète.
    private function currentAccount(): ?User
    {
        $userId = $this->currentUserId();
        $user = $userId === null ? null : User::find($userId);

        if ($user === null) {
            unset($_SESSION['user_id'], $_SESSION['user_role']);
        }

        return $user;
    }
}
