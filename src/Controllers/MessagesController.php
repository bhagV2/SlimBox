<?php

namespace App\Controllers;

use App\Models\Friendship;
use App\Models\Message;
use App\Models\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MessagesController extends RenderController
{
    // Afficher les amis sans ouvrir de conversation.
    public function index(Request $request, Response $response): Response
    {
        $userId = $this->currentUserId();

        if ($userId === null) {
            return $this->redirect($response, '/connexion');
        }

        return $this->renderMessages($response, $userId, null);
    }

    // Afficher la conversation d’un ami accepté.
    public function conversation(Request $request, Response $response, array $args): Response
    {
        $userId = $this->currentUserId();

        if ($userId === null) {
            return $this->redirect($response, '/connexion');
        }

        $contactId = $this->routeId($args);

        if ($contactId === null) {
            return $this->notFound($response);
        }

        $contact = $this->findFriend($userId, $contactId);

        if ($contact === null) {
            return $this->notFound($response);
        }

        return $this->renderMessages($response, $userId, $contact);
    }

    // Valider et envoyer un message à un ami accepté.
    public function send(Request $request, Response $response, array $args): Response
    {
        $userId = $this->currentUserId();

        if ($userId === null) {
            return $this->redirect($response, '/connexion');
        }

        $contactId = $this->routeId($args);

        if ($contactId === null) {
            return $this->notFound($response);
        }

        $contact = $this->findFriend($userId, $contactId);

        if ($contact === null) {
            return $this->notFound($response);
        }

        $body = $this->postString('body');
        // Compter chaque caractère accentué comme un seul caractère.
        $bodyLength = preg_match_all('/./us', $body);

        if ($body === '') {
            $this->setAlert('Écrivez un message avant de l’envoyer.');
        } elseif ($bodyLength === false) {
            $this->setAlert('Le message contient un format invalide.');
        } elseif ($bodyLength > 2000) {
            $this->setAlert('Le message ne peut pas dépasser 2 000 caractères.');
        } else {
            Message::send($userId, $contactId, $body);
        }

        return $this->redirect($response, '/messages/' . $contactId);
    }

    // Récupérer un contact uniquement s’il est ami du compte courant.
    private function findFriend(int $userId, int $contactId): ?User
    {
        $contact = User::find($contactId);

        if ($contact === null || !Friendship::areFriends($userId, $contactId)) {
            return null;
        }

        return $contact;
    }

    // Afficher la messagerie avec ses contacts et ses échanges.
    private function renderMessages(Response $response, int $userId, ?User $contact): Response
    {
        return $this->render($response, 'messages', [
            'contacts' => Friendship::friends($userId),
            'currentUserId' => $userId,
            'selectedContact' => $contact,
            'messages' => $contact === null ? [] : Message::conversation($userId, $contact->getId()),
            'alert' => $this->takeAlert(),
        ]);
    }

    // Retourner une erreur 404 pour un utilisateur inaccessible.
    private function notFound(Response $response): Response
    {
        $response->getBody()->write('Utilisateur introuvable.');

        return $response->withStatus(404);
    }
}
