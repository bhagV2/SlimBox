<?php

namespace App\Models;

use App\Services\Database;

class Friendship
{
    // Récupérer la liste des amis acceptés.
    public static function friends(int $userId): array
    {
        $statement = Database::getConnection()->prepare(
            'SELECT ami.id, ami.nom_utilisateur
             FROM amities
             JOIN utilisateurs AS ami ON ami.id = amities.utilisateur_deux_id
             WHERE amities.utilisateur_un_id = :utilisateur_un_id AND amities.statut = \'acceptee\'
             UNION
             SELECT ami.id, ami.nom_utilisateur
             FROM amities
             JOIN utilisateurs AS ami ON ami.id = amities.utilisateur_un_id
             WHERE amities.utilisateur_deux_id = :utilisateur_deux_id AND amities.statut = \'acceptee\'
             ORDER BY nom_utilisateur'
        );
        $statement->execute([
            'utilisateur_un_id' => $userId,
            'utilisateur_deux_id' => $userId,
        ]);

        return $statement->fetchAll();
    }

    // Récupérer les demandes d’amis reçues.
    public static function incomingRequests(int $userId): array
    {
        $statement = Database::getConnection()->prepare(
            'SELECT demandeur.id, demandeur.nom_utilisateur
             FROM amities
             JOIN utilisateurs AS demandeur ON demandeur.id = amities.demandeur_id
             WHERE amities.statut = \'en_attente\'
               AND amities.demandeur_id <> :demandeur_id
               AND (amities.utilisateur_un_id = :utilisateur_un_id
                    OR amities.utilisateur_deux_id = :utilisateur_deux_id)
             ORDER BY demandeur.nom_utilisateur'
        );
        $statement->execute([
            'demandeur_id' => $userId,
            'utilisateur_un_id' => $userId,
            'utilisateur_deux_id' => $userId,
        ]);

        return $statement->fetchAll();
    }

    // Récupérer les demandes d’amis envoyées.
    public static function outgoingRequests(int $userId): array
    {
        $statement = Database::getConnection()->prepare(
            'SELECT ami.id, ami.nom_utilisateur
             FROM amities
             JOIN utilisateurs AS ami ON ami.id = amities.utilisateur_deux_id
             WHERE amities.utilisateur_un_id = :utilisateur_un_id
               AND amities.demandeur_id = :demandeur_un_id
               AND amities.statut = \'en_attente\'
             UNION
             SELECT ami.id, ami.nom_utilisateur
             FROM amities
             JOIN utilisateurs AS ami ON ami.id = amities.utilisateur_un_id
             WHERE amities.utilisateur_deux_id = :utilisateur_deux_id
               AND amities.demandeur_id = :demandeur_deux_id
               AND amities.statut = \'en_attente\'
             ORDER BY nom_utilisateur'
        );
        $statement->execute([
            'utilisateur_un_id' => $userId,
            'demandeur_un_id' => $userId,
            'utilisateur_deux_id' => $userId,
            'demandeur_deux_id' => $userId,
        ]);

        return $statement->fetchAll();
    }

    // Récupérer les utilisateurs sans relation d’amitié existante.
    public static function availableUsers(int $userId): array
    {
        $statement = Database::getConnection()->prepare(
            'SELECT utilisateurs.id, utilisateurs.nom_utilisateur
             FROM utilisateurs
             WHERE utilisateurs.id <> :utilisateur_id
               AND NOT EXISTS (
                   SELECT 1
                   FROM amities
                   WHERE (amities.utilisateur_un_id = :utilisateur_un_id
                          AND amities.utilisateur_deux_id = utilisateurs.id)
                      OR (amities.utilisateur_un_id = utilisateurs.id
                          AND amities.utilisateur_deux_id = :utilisateur_deux_id)
               )
             ORDER BY utilisateurs.nom_utilisateur'
        );
        $statement->execute([
            'utilisateur_id' => $userId,
            'utilisateur_un_id' => $userId,
            'utilisateur_deux_id' => $userId,
        ]);

        return $statement->fetchAll();
    }

    // Vérifier si deux utilisateurs sont amis.
    public static function areFriends(int $userId, int $otherUserId): bool
    {
        [$userOneId, $userTwoId] = self::orderedIds($userId, $otherUserId);
        $statement = Database::getConnection()->prepare(
            'SELECT 1 FROM amities
             WHERE utilisateur_un_id = :utilisateur_un_id
               AND utilisateur_deux_id = :utilisateur_deux_id
               AND statut = \'acceptee\''
        );
        $statement->execute([
            'utilisateur_un_id' => $userOneId,
            'utilisateur_deux_id' => $userTwoId,
        ]);

        return $statement->fetchColumn() !== false;
    }

    // Créer une demande si aucune relation d’amitié n’existe.
    public static function request(int $userId, int $otherUserId): bool
    {
        if ($userId === $otherUserId) {
            return false;
        }

        [$userOneId, $userTwoId] = self::orderedIds($userId, $otherUserId);
        $statement = Database::getConnection()->prepare(
            'INSERT INTO amities (utilisateur_un_id, utilisateur_deux_id, demandeur_id, statut)
             SELECT :utilisateur_un_id, :utilisateur_deux_id, :demandeur_id, \'en_attente\'
             FROM DUAL
             WHERE NOT EXISTS (
                 SELECT 1 FROM amities
                 WHERE utilisateur_un_id = :existant_utilisateur_un_id
                   AND utilisateur_deux_id = :existant_utilisateur_deux_id
             )'
        );
        $statement->execute([
            'utilisateur_un_id' => $userOneId,
            'utilisateur_deux_id' => $userTwoId,
            'demandeur_id' => $userId,
            'existant_utilisateur_un_id' => $userOneId,
            'existant_utilisateur_deux_id' => $userTwoId,
        ]);

        return $statement->rowCount() > 0;
    }

    // Accepter une demande d’amitié reçue.
    public static function accept(int $userId, int $otherUserId): bool
    {
        [$userOneId, $userTwoId] = self::orderedIds($userId, $otherUserId);
        $statement = Database::getConnection()->prepare(
            'UPDATE amities
             SET statut = \'acceptee\'
             WHERE utilisateur_un_id = :utilisateur_un_id
               AND utilisateur_deux_id = :utilisateur_deux_id
               AND demandeur_id = :demandeur_id
               AND statut = \'en_attente\''
        );
        $statement->execute([
            'utilisateur_un_id' => $userOneId,
            'utilisateur_deux_id' => $userTwoId,
            'demandeur_id' => $otherUserId,
        ]);

        return $statement->rowCount() > 0;
    }

    // Refuser une demande d’amitié reçue.
    public static function decline(int $userId, int $otherUserId): bool
    {
        [$userOneId, $userTwoId] = self::orderedIds($userId, $otherUserId);
        $statement = Database::getConnection()->prepare(
            'DELETE FROM amities
             WHERE utilisateur_un_id = :utilisateur_un_id
               AND utilisateur_deux_id = :utilisateur_deux_id
               AND demandeur_id = :demandeur_id
               AND statut = \'en_attente\''
        );
        $statement->execute([
            'utilisateur_un_id' => $userOneId,
            'utilisateur_deux_id' => $userTwoId,
            'demandeur_id' => $otherUserId,
        ]);

        return $statement->rowCount() > 0;
    }

    // Ordonner les identifiants pour retrouver la relation d’amitié.
    private static function orderedIds(int $userId, int $otherUserId): array
    {
        return $userId < $otherUserId
            ? [$userId, $otherUserId]
            : [$otherUserId, $userId];
    }
}
