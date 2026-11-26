<?php

namespace App\Controllers;

use App\Models\User;
use PDOException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DashboardController extends RenderController
{
    // Afficher la liste des comptes à l’administrateur.
    public function index(Request $request, Response $response): Response
    {
        $accessResponse = $this->requireAdmin($response);

        if ($accessResponse !== null) {
            return $accessResponse;
        }

        return $this->render($response, 'dashboard', [
            'users' => User::all(),
            'alert' => $this->takeAlert(),
        ]);
    }

    // Afficher le formulaire de modification d’un compte.
    public function edit(Request $request, Response $response, array $args): Response
    {
        $accessResponse = $this->requireAdmin($response);

        if ($accessResponse !== null) {
            return $accessResponse;
        }

        $id = $this->routeId($args);
        $user = $id === null ? null : User::find($id);

        if ($user === null) {
            $this->setAlert('Utilisateur introuvable.');

            return $this->redirect($response, '/dashboard');
        }

        if ($id === (int) $_SESSION['user_id']) {
            $this->setAlert('Modifiez votre compte depuis la page Mon compte.');

            return $this->redirect($response, '/dashboard');
        }

        return $this->render($response, 'edit-user', [
            'user' => $user,
            'alert' => $this->takeAlert(),
        ]);
    }

    // Valider et enregistrer les modifications d’un compte.
    public function update(Request $request, Response $response, array $args): Response
    {
        $accessResponse = $this->requireAdmin($response);

        if ($accessResponse !== null) {
            return $accessResponse;
        }

        $id = $this->routeId($args);

        if ($id === null) {
            $this->setAlert('Utilisateur introuvable.');

            return $this->redirect($response, '/dashboard');
        }

        if ($id === (int) $_SESSION['user_id']) {
            $this->setAlert('Modifiez votre compte depuis la page Mon compte.');

            return $this->redirect($response, '/dashboard');
        }

        $editPath = '/dashboard/utilisateurs/' . $id . '/modifier';

        $user = User::find($id);
        $username = $this->postString('username');
        $password = $this->postString('password', false);

        if ($user === null) {
            $this->setAlert('Utilisateur introuvable.');

            return $this->redirect($response, '/dashboard');
        }

        if (!$this->validUsername($username) || ($password !== '' && !$this->validPassword($password))) {
            $this->setAlert('Vérifiez le nom d’utilisateur et le nouveau mot de passe (6 caractères minimum).');

            return $this->redirect($response, $editPath);
        }

        try {
            $user->update($username, $password === '' ? null : $password);
        } catch (PDOException $exception) {
            if ((string) $exception->getCode() !== '23000') {
                throw $exception;
            }

            $this->setAlert('Ce nom d’utilisateur est déjà utilisé.');

            return $this->redirect($response, $editPath);
        }

        $this->setAlert('Le compte a été modifié.');

        return $this->redirect($response, '/dashboard');
    }

    // Supprimer un compte autre que celui de l’administrateur connecté.
    public function delete(Request $request, Response $response, array $args): Response
    {
        $accessResponse = $this->requireAdmin($response);

        if ($accessResponse !== null) {
            return $accessResponse;
        }

        $id = $this->routeId($args);

        if ($id === null) {
            $this->setAlert('Utilisateur introuvable.');

            return $this->redirect($response, '/dashboard');
        }

        if ($id === (int) $_SESSION['user_id']) {
            $this->setAlert('Vous ne pouvez pas supprimer votre propre compte administrateur.');

            return $this->redirect($response, '/dashboard');
        }

        $user = User::find($id);

        if ($user === null) {
            $this->setAlert('Utilisateur introuvable.');
        } elseif ($user->delete()) {
            $this->setAlert('Le compte a été supprimé.');
        } else {
            $this->setAlert('Le compte n’a pas pu être supprimé.');
        }

        return $this->redirect($response, '/dashboard');
    }

    // Vérifier les droits d’administrateur avant l’accès.
    private function requireAdmin(Response $response): ?Response
    {
        $userId = $this->currentUserId();
        $user = $userId === null ? null : User::find($userId);

        if ($user === null) {
            unset($_SESSION['user_id'], $_SESSION['user_role']);

            return $this->redirect($response, '/connexion');
        }

        if ($user->getRole() !== 'administrateur') {
            $response->getBody()->write('Cette page est réservée aux administrateurs.');

            return $response->withStatus(403);
        }

        return null;
    }
}
