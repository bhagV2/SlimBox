<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;

class RenderController
{
    // Rendre une vue et ajouter son HTML à la réponse.
    protected function render(Response $response, string $view, array $data = []): Response
    {
        // Passer les valeurs de $data à la vue comme des variables.
        extract($data, EXTR_SKIP);

        // Récupérer le HTML de la vue pour l'ajouter à la réponse.
        ob_start();
        require dirname(__DIR__) . '/Views/' . $view . '.php';
        $html = ob_get_clean();
        $response->getBody()->write($html);

        return $response;
    }

    // Récupérer l’identifiant valide de l’utilisateur connecté.
    protected function currentUserId(): ?int
    {
        $userId = filter_var($_SESSION['user_id'] ?? null, FILTER_VALIDATE_INT);

        if ($userId === false || $userId === null || $userId < 1) {
            return null;
        }

        return $userId;
    }

    // Récupérer une valeur de formulaire sous forme de chaîne.
    protected function postString(string $key, bool $trim = true): string
    {
        $value = filter_input(INPUT_POST, $key, FILTER_UNSAFE_RAW);

        if (!is_string($value)) {
            return '';
        }

        return $trim ? trim($value) : $value;
    }

    // Récupérer un identifiant numérique des paramètres de route.
    protected function routeId(array $args): ?int
    {
        $id = filter_var($args['id'] ?? null, FILTER_VALIDATE_INT);

        return $id === false || $id < 1 ? null : $id;
    }

    // Vérifier la longueur du nom d’utilisateur.
    protected function validUsername(string $username): bool
    {
        return $username !== '' && strlen($username) <= 50;
    }

    // Vérifier la longueur minimale du mot de passe.
    protected function validPassword(string $password): bool
    {
        return strlen($password) >= 6;
    }

    // Rediriger vers le chemin indiqué.
    protected function redirect(Response $response, string $path): Response
    {
        return $response->withHeader('Location', APP_BASE_PATH . $path)->withStatus(303);
    }

    // Enregistrer une alerte dans la session.
    protected function setAlert(string $alert): void
    {
        $_SESSION['alert'] = $alert;
    }

    // Récupérer puis supprimer l’alerte de la session.
    protected function takeAlert(): ?string
    {
        $alert = $_SESSION['alert'] ?? null;
        unset($_SESSION['alert']);

        return is_string($alert) ? $alert : null;
    }
}
