<?php

namespace App\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class FriendsController extends RenderController
{
    // Afficher les amis et les demandes du compte connecté.
    public function index(Request $request, Response $response): Response
    {
        $userId = $this->currentUserId();

        if ($userId === null) {
            return $this->redirect($response, '/connexion');
        }

        return $this->render($response, 'friends', [
            'friends' => Friendship::friends($userId),
            'incomingRequests' => Friendship::incomingRequests($userId),
            'outgoingRequests' => Friendship::outgoingRequests($userId),
            'availableUsers' => Friendship::availableUsers($userId),
            'alert' => $this->takeAlert(),
        ]);
    }

    // Envoyer une demande d’amitié à un utilisateur.
    public function request(Request $request, Response $response, array $args): Response
    {
        $userId = $this->currentUserId();

        if ($userId === null) {
            return $this->redirect($response, '/connexion');
        }

        $otherUserId = $this->routeId($args);

        if ($otherUserId === null) {
            $this->setAlert('Utilisateur introuvable.');

            return $this->redirect($response, '/amis');
        }

        $otherUser = User::find($otherUserId);

        if ($otherUser === null) {
            $this->setAlert('Utilisateur introuvable.');
        } elseif (Friendship::request($userId, $otherUserId)) {
            $this->setAlert('La demande d’ami a été envoyée.');
        } else {
            $this->setAlert('La demande est impossible ou existe déjà.');
        }

        return $this->redirect($response, '/amis');
    }

    // Accepter une demande d’amitié.
    public function accept(Request $request, Response $response, array $args): Response
    {
        return $this->updateRequest($response, $args, true);
    }

    // Refuser une demande d’amitié.
    public function decline(Request $request, Response $response, array $args): Response
    {
        return $this->updateRequest($response, $args, false);
    }

    // Accepter ou refuser une demande puis afficher le résultat.
    private function updateRequest(Response $response, array $args, bool $accept): Response
    {
        $userId = $this->currentUserId();

        if ($userId === null) {
            return $this->redirect($response, '/connexion');
        }

        $otherUserId = $this->routeId($args);

        if ($otherUserId === null) {
            $this->setAlert('Cette demande n’existe plus.');

            return $this->redirect($response, '/amis');
        }

        $updated = $accept
            ? Friendship::accept($userId, $otherUserId)
            : Friendship::decline($userId, $otherUserId);

        if (!$updated) {
            $this->setAlert('Cette demande n’existe plus.');
        } elseif ($accept) {
            $this->setAlert('La demande a été acceptée.');
        } else {
            $this->setAlert('La demande a été refusée.');
        }

        return $this->redirect($response, '/amis');
    }
}
